<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @author hobrt.me
 * @file Home.php
 * @package hobrtEcom
 * @link hobrt.me
 * @copyright hobrt.me 2018 => 2022
 *
 **/
class Home extends CI_Controller
{
	protected $PRODUCT_SELECT_COLUMN = array("id", "title", "slug", "cat", "images", "review", "price", "discount", "date");
	function __construct()
	{
		parent::__construct();
		load_lang();

		$theme = setting("theme");

		// the theme name is used in view/include paths
		if (!in_array($theme, available_themes(), TRUE))
			$theme = "hobrtEcom";

		define('template', "front/" . $theme);
	}

	public function index()
	{
		$data['latest_products'] = $this->m_p->s_a("products", array(), 8, 0, $this->PRODUCT_SELECT_COLUMN, "date");

		$data['featured'] = $this->m_p->s_a("products", array(), 8, 0, $this->PRODUCT_SELECT_COLUMN, "featured");

		$data['slider'] = $this->m_p->s_a("slider", array(), FALSE, 0, array("*"), "position", "ASC");

		$data['collections'] = $this->m_p->s_a("collections", array("visible_home" => 1), FALSE, 0, array("*"), "position", "ASC");

		// geting products details for each collection
		foreach ($data['collections'] as $key => $value) {
			$data['collections'][$key]->products = $this->m_p->select_where_in("products", implode(",", $this->PRODUCT_SELECT_COLUMN), "id", $data['collections'][$key]->products);
		}

		$data['promo1'] = $this->m_p->s_a("promo", array("tp" => 1), FALSE, 0, array("*"), "position", "ASC");
		$data['promo2'] = $this->m_p->s_a("promo", array("tp" => 2), FALSE, 0, array("*"), "position", "ASC");

		$data['code_header'] = $this->m_p->get_html_codes(1);

		$this->load->view(template . "/index", $data);
	}

	public function page($slug = FALSE)
	{

		$slug = urldecode($slug);

		$page = $this->m_p->findOneBySlug("pages", $slug);
		if (is_null($page))
			redirect("home");

		$data['code_header'] = $this->m_p->get_html_codes(3);

		$data['title'] = $page->title;

		$data['page'] = $page;

		$this->load->view(template . "/page", $data);
	}

	public function category($slug = FALSE, $page = 0)
	{
		$slug = urldecode($slug);

		$category = $this->m_p->findOneBySlug("cats", $slug);
		if (is_null($category))
			redirect("home");

		$data["title"] = $category->title;
		$data["image"] = $category->img;
		$data["description"] = "Category";

		$data['code_header'] = $this->m_p->get_html_codes(4);

		$data['total'] = $this->m_p->get_num("products", array("cat" => $category->id));

		$config = get_theme_paginate_config(template, $data['total'], "category/" . $category->slug, 3, $this->config->item("per_page"));

		$this->pagination->initialize($config);

		$data["products"] = $this->m_p->s_a("products", array("cat" => $category->id), $config["per_page"], $page, $this->PRODUCT_SELECT_COLUMN, "date");

		$data["links"] = $this->pagination->create_links();

		$this->load->view(template . "/shop-single-page", $data);
	}

	public function collection($slug = FALSE)
	{
		$slug = urldecode($slug);

		$collection = $this->m_p->findOneBySlug("collections", $slug);
		if (is_null($collection))
			redirect("home");

		$data["title"] = $collection->title;
		$data["image"] = $collection->image;
		$data["description"] = $collection->description;

		$data['code_header'] = $this->m_p->get_html_codes(4);

		$data["products"] = $this->m_p->select_where_in("products", implode(",", $this->PRODUCT_SELECT_COLUMN), "id", $collection->products);

		$data['total'] = count($data["products"]);

		$this->load->view(template . "/shop-single-page", $data);
	}

	public function shop($page = 0)
{
    $where = array();
    if ($this->input->get("cat")) {
        $category = $this->m_p->findOneById("cats", $this->input->get("cat"));
        if ($category)
            $where = array("cat" => $category->id);
    }

    $data['code_header'] = $this->m_p->get_html_codes(4);

    $data['total'] = $this->m_p->get_num("products", $where);

    $config = array(
        "base_url" => base_url() . "shop/",
        "total_rows" => $data['total'],
        "per_page" => $this->config->item("per_page"),
        "uri_segment" => 3,
        "full_tag_open" => '<nav aria-label="Page navigation example" class="navigation-btn"><ul class="pagination justify-content-center">',
        "full_tag_close" => '</ul></nav>',
        "num_tag_open" => '<li class="page-item">',
        "num_tag_close" => '</li>',
        "cur_tag_open" => '<li class="page-item active"><a class="page-link">',
        "cur_tag_close" => '</a></li>',
        "next_tag_open" => '<li class="page-item">',
        "next_tag_close" => '</li>',
        "prev_tag_open" => '<li class="page-item">',
        "prev_tag_close" => '</li>',
        "first_tag_open" => '<li class="page-item">',
        "first_tag_close" => '</li>',
        "last_tag_open" => '<li class="page-item">',
        "last_tag_close" => '</li>',
        "last_link" => lang("lang_h67"),
        "first_link" => lang("lang_h68"),
        "next_link" => '<span aria-hidden="true"><i class="fas fa-angle-double-right"></i></span>',
        "prev_link" => '<span aria-hidden="true"><i class="fas fa-angle-double-left"></i></span>',
        "attributes" => array('class' => 'page-link')
    );

    $this->pagination->initialize($config);

    // Order
    switch ($this->input->get("order")) {
        case 'price_low':
            $order_by = "price";
            $order_as = "ASC";
            break;
        case 'price_high':
            $order_by = "price";
            $order_as = "DESC";
            break;

        default:
            $order_by = "date";
            $order_as = "DESC";
            break;
    }

    $data["products"] = $this->m_p->s_a("products", $where, $config["per_page"], $page, $this->PRODUCT_SELECT_COLUMN, $order_by, $order_as);

    $data["links"] = $this->pagination->create_links();

    $this->load->view(template . "/shop", $data);
}



	public function products()
	{

		$data['title'] = "كل المنتوجات";


		$data['products'] = $this->m_p->s_a("products", array(), 12, 0);

		$data['code_header'] = $this->m_p->get_html_codes(4);

		$data['cats'] = $this->m_p->s_a("cats", array(), FALSE, 0, array("*"), "position", "ASC");

		$this->load->view(template . "/cat", $data);
	}


	public function discounts()
	{
		$data['title'] = "تخفيضات";

		$data['products'] = $this->m_p->s_a("products", array("discount > " => 0), FALSE);

		$data['code_header'] = $this->m_p->get_html_codes(4);

		$data['cats'] = $this->m_p->s_a("cats", array(), FALSE, 0, array("*"), "position", "ASC");

		$this->load->view(template . "/cat", $data);
	}


	public function product($slug)
	{
		$slug = urldecode($slug);

		$product = $this->m_p->findOneBySlug("products", $slug);
		if (is_null($product))
			redirect("home");
		
		$data["product"] = $product;
		$data["title"] = $product->title;
		$data["description"] = $product->description;
		$data["category"] = $this->m_p->findOneById("cats", $product->cat);

		$data['code_header'] = $this->m_p->get_html_codes(2);

		if (is_login("admin_login")) {
			$data['reviews'] = $this->m_p->s_a("reviews", array("product_id" => $product->id), 6, 0, array("*"), "date", "DESC");
		} else {
			$data['reviews'] = $this->m_p->s_a("reviews", array("product_id" => $product->id, "ac" => 1), 6, 0, array("*"), "date", "DESC");
		}

		$data['related_products'] = $this->m_p->s_a("products", array("id <>" => $product->id, "cat" => $product->cat), 4);

		$this->load->view(template . "/product", $data);
	}

	public function js()
	{
		echo 'var lang_h31 = "' . lang("lang_h31") . '",';
		echo 'lang_h32 = "' . lang("lang_h32") . '",';
		echo 'lang_h33 = "' . lang("lang_h33") . '",';
		echo 'lang_h34 = "' . lang("lang_h34") . '";';
	}



	public function cart()
	{

		$data['cats'] = $this->m_p->s_a("cats", array(), FALSE, 0, array("*"), "position", "ASC");

		$data['code_header'] = $this->m_p->get_html_codes(6);

		if (!is_null(get_cookie("cart"))) {
			$arr = json_decode(get_cookie("cart"), TRUE);

			if (!is_array($arr))
				$arr = array();

			$ids = array();

			foreach ($arr as $a) {
				if (isset($a['id']))
					$ids[] = (int) $a['id'];
			}

			$data['arr'] = $arr;

			if (count($ids) > 0)
				$data["info"] = $this->m_p->s_cart("products", $ids, FALSE);
			else
				$data['info'] = array();

			$form_validation = array(
				array(
					"field" => "fullname",
					"label" => "الإسم الكامل",
					"rules" => "trim|required"
				),
				array(
					"field" => "phone",
					"label" => "الهاتف",
					"rules" => "trim|required"
				)
			);
			$this->form_validation->set_rules($form_validation);
			if ($this->form_validation->run() === TRUE) {
				$products = array();

				$qty = 0;
				$prods = [];

				$tprice = 0;
				$ship = 0;
				// one IP can not flood the store with orders (each order can send an SMS)
				rate_limit_or_die("order_" . $this->input->ip_address(), 5, 15 * 60);

				foreach ($data['info'] as $key) {
					// the cart cookie is client data: only trust ids, re-check qty and options
					$line = $arr[$key->id] ?? array();
					$q = clean_qty($line['q'] ?? 1);
					$options = clean_product_options($key, $line['op'] ?? array());

					$pr = floor($key->price - ($key->price * $key->discount / 100));

					$tprice = $tprice + $pr * $q;
					$ship = $ship + $key->shipping;

					$products[] = [
						"id" => $key->id,
						"q" => $q,
						"options" => json_encode($options, JSON_UNESCAPED_UNICODE)
					];

					$qty += $q;

					$prods[] = $key->title;
				}

				$coupon = $this->input->post("coupon") ?? "";

				$date = date("Y-m-d");

				if (!empty($coupon)) {
					$c = $this->m_p->s_a("discounts", array("coupon" => $coupon, "date >=" => $date));

					if (count($c) != 0) {
						foreach ($c as $k)
							$num = $k->num;

						$tprice = $tprice - $num * $tprice / 100;
					}
				}

				$arr = array(
					"name" => $this->input->post("fullname") ?? "",
					"tele" => $this->input->post("phone") ?? "",
					"address" => $this->input->post("address") ?? "",
					"city" => $this->input->post("city") ?? "",
					"coupon" => $this->input->post("coupon") ?? "",
					"totalPrice" => $tprice + $ship,
					"products" => json_encode($products, JSON_UNESCAPED_UNICODE),
					"date" => time()
				);

				$o = $this->m_p->ins("orders", $arr);

				send_sms($o);

				$data = [
					date("Y-m-d H:i"),
					implode("\n", $prods),
					$qty,
					$this->input->post("fullname") ?? "",
					$this->input->post("address") ?? "",
					$this->input->post("phone") ?? "",
					$this->input->post("city") ?? "",
					$tprice + $ship

				];

				send_to_google_sheet($data);

				delete_cookie("cart");

				redirect("home/thanks?order_id=" . (int) $o);
			}


			$data['ids'] = implode(",", $ids);
		} else
			$data['info'] = array();

		// themes without a cart page order straight from the product page:
		// a rejected order goes back there instead of a 404
		$back = (string) $this->input->server("HTTP_REFERER");
		if ($this->input->method() === "post" && !is_file(VIEWPATH . template . "/cart.php") && strpos($back, base_url()) === 0)
			redirect($back);

		$this->theme_view("cart", $data);
	}

	/** Loads a view of the active theme, or 404 when the theme does not provide it */
	private function theme_view($view, $data)
	{
		if (!is_file(VIEWPATH . template . "/" . $view . ".php"))
			show_404();

		$this->load->view(template . "/" . $view, $data);
	}


	public function thanks()
	{
		$data['code_header'] = $this->m_p->get_html_codes(5);

		$this->load->view(template . "/end", $data);
	}


	public function rss()
	{

		$data['items'] = $this->m_p->s_a("products", array(), FALSE);

		$this->_rss2($data);
	}

	public function _rss2($data)
	{

		$this->load->helper("xml");

		header('Content-type: text/xml');
		echo 	'<?xml version="1.0"?>';
		echo	'<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">',
		'<channel>',
		'<title>', setting('title'), '</title>',
		'<link>', base_url(), '</link>',
		'<description>', setting('descr'), '</description>';
		foreach ($data['items'] as $item) {
			echo '<item>',
			'<g:id>', $item->id, '</g:id>',
			'<g:title>', xml_convert($item->title), '</g:title>',
			'<g:description>', short_text(strip_tags($item->descr), 60, 200), '</g:description>',
			'<g:link>', base_url("product/$item->slug"), '</g:link>',
			'<g:image_link>', base_url() . 'uploads/' . add_thumb($item->images, ""), '</g:image_link>',
			'<g:condition>new</g:condition>',
			'<g:price>', $item->price . ' MAD', '</g:price>',
			'<g:shipping>',
			'<g:country>MA</g:country>',
			'<g:service>Standard</g:service>',
			'<g:price>', $item->shipping . ' MAD', '</g:price>',
			'</g:shipping>',
			'</item>';
		}
		echo		'</channel>',
		'</rss>';
	}
}
