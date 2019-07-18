<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* @author hobrt.me
* @file Home.php
* @package hobrtEcom
* @link hobrt.me
* @copyright hobrt.me 2018 => 2019
*
**/
class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['products'] = $this->m_p->s_a("products", array(), FALSE);

		$data['cats'] = $this->m_p->s_a("cats", array(), FALSE, 0, array("*"), "position", "ASC");

		$this->load->view(template."/index", $data);
	}

	public function category($id = FALSE)
	{

		if($id == FALSE)
			redirect("home");

		$cat = $this->m_p->s_a("cats", array("id" => $id), 1);

		if(count($cat) == 0)
			redirect("home");

		foreach ($cat as $key) {
			$data['title'] = $key->title;
		}

		$data['products'] = $this->m_p->s_a("products", array("cat" => $id), FALSE);

		$data['cats'] = $this->m_p->s_a("cats", array(), FALSE, 0, array("*"), "position", "ASC");

		$this->load->view(template."/cat", $data);

	}
	

	public function discounts()
	{
		$data['title'] = "تخفيضات";
		
		$data['products'] = $this->m_p->s_a("products", array("discount > " => 0), FALSE);

		$data['cats'] = $this->m_p->s_a("cats", array(), FALSE, 0, array("*"), "position", "ASC");

		$this->load->view(template."/cat", $data);

	}
	

	public function show($id = FALSE)
	{
		if($id == FALSE)
			redirect("home");
		
		$data['info'] = $this->m_p->s_a("products", array("id" => $id), 1);

		if(count($data['info']) == 0)
			redirect("home");

		$data['cats'] = $this->m_p->s_a("cats", array(), FALSE, 0, array("*"), "position", "ASC");


		$form_validation = array(
			array(
				"field" => "name",
				"label" => "الإسم الكامل",
				"rules" => "trim|required"
				),
			array(
				"field" => "comment",
				"label" => "التعليق",
				"rules" => "trim|required"
				)
			);
		$this->form_validation->set_rules($form_validation);
		if($this->form_validation->run() === TRUE)
		{
			$config['upload_path'] 				= './reviews/';
			$config['allowed_types'] 			= 'jpg|jpeg|png';
			$config['encrypt_name'] 			= TRUE;
			$config['max_size']					= '10240'; // 10 MB
			$this->upload->initialize($config);
			$a = $this->upload->do_upload('img');
			$data_upload = $this->upload->data();
			$img = "";
			if($a)
			{
				$this->image_l
					->load($data_upload['full_path'])
					->resize_crop(300,300)
					->save_pa('','',TRUE);

				$img = $data_upload['file_name'];
			}

			if(isset($_POST['starv'])){

				$arr = array(
					"name" => $this->input->post("name"),
					"comment" => $this->input->post("comment"),
					"vote" => $this->input->post("starv"),
					"img" => $img,
					"date" => time(),
					"product" => $id

				);

				$this->m_p->ins("reviews", $arr);

				$data['msg'] = "تم إضافة التقييم الخاص بك سوف يظهر بعد مراجعة الإدارة .";

			}


		}

		if(is_login("admin_login"))
		{
			$data['votes'] = $this->m_p->s_a("reviews", array("product" => $id), 50);
		}else {
			$data['votes'] = $this->m_p->s_a("reviews", array("product" => $id, "ac" => 1), 50);
		}

		foreach($data['info'] as $key)
		{
			$data['title'] = $key->title;
			$cat = $key->cat;
		}

		$data['related'] = $this->m_p->s_a("products", array("id <>" => $id, "cat" => $cat), 4);

		$this->load->view(template."/show", $data);

	}


	public function cart()
	{
		
		$data['cats'] = $this->m_p->s_a("cats", array(), FALSE, 0, array("*"), "position", "ASC");

		if(!is_null(get_cookie("cart"))){
			$arr = json_decode(get_cookie("cart"), TRUE);

			// print_r($arr);
			// exit();


			$ids = array();

			foreach($arr as $a)
			{
				$ids[] = $a['id'];
			}

			$data['arr'] = $arr;

			if(count($ids) > 0)
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
			if($this->form_validation->run() === TRUE)
			{
				$products = array();

				$tprice = 0;
				$ship = 0;
				foreach($data['info'] as $key)
				{
					$products[$key->id] = $data['arr'][$key->id]['q'];

					$pr = floor($key->price - ($key->price * $key->discount / 100)); $tpr = isset($data['arr'][$key->id]['q']) ? $pr * $arr[$key->id]['q'] : $pr;

					$tprice = $tprice + $tpr;
					$ship = $ship + $key->shipping;


				}

				$coupon = $this->input->post("coupon");

				$date = "Y-m-d";

				if(!empty($coupon))
				{
					$c = $this->m_p->s_a("discounts", array("coupon" => $coupon, "date >=" => $date));

					if(count($c) != 0)
					{
						foreach($c as $k)
							$num = $k->num;

						$tprice = $tprice - $num * $tprice / 100;
					}
				}

				$arr = array(
					"name" => $this->input->post("fullname"),
					"tele" => $this->input->post("phone"),
					"address" => $this->input->post("address"),
					"city" => $this->input->post("city"),
					"coupon" => $this->input->post("coupon"),
					"totalPrice" => $tprice + $ship,
					"products" => json_encode($products),
					"date" => time()
				);

				$this->m_p->ins("orders", $arr);

				delete_cookie("cart");

				redirect("home/thanks");
			}


			$data['ids'] = implode(",", $ids);
		}else
			$data['info'] = array();

		$this->load->view(template."/cart", $data);
	}

	public function thanks()
	{
		$data['cats'] = $this->m_p->s_a("cats", array(), FALSE, 0, array("*"), "position", "ASC");

		$this->load->view(template."/end", $data);
	}
	


}
