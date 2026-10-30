<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* @author hobrt.me
* @file Welcome.php
* @package hobrtEcom
* @link hobrt.me
* @copyright hobrt.me 2018 => 2021
*
**/
class Landing extends CI_Controller {


	function __construct() {
		parent::__construct();
	}
	
	public function thanks()
	{

		$id = $this->session->landing ?? 0;

		if($id == 0)
			redirect('home');

		$data['code_header'] = $this->m_p->get_html_codes(5);

		$data['info'] = $this->m_p->s_a("landing_pages", array("id" => $id), 1);

		foreach($data['info'] as $key)
		{
			$upsell = $key->upsell ?? "";
		}

		$upsell_ids = array_filter(array_map('intval', explode(",", $upsell ?? "")));

		$data['upsell'] = empty($upsell_ids) ? [] : array_slice($this->m_p->select_where_in("products", "*", "id", implode(",", $upsell_ids)), 0, 4);

		$this->load->view("landing/thanks", $data);
	}
	
	public function index($id = FALSE)
	{
		// $domain = DOMAIN ?? '';

		// if($id === FALSE) {

		// 	$g = $this->m_p->s_a('landing_pages', array("domain" => $domain), 1);

		// 	if(count($g) == 0)
		// 		show_404();

		// 	foreach($g as $k) {
		// 		$id = $k->id;
		// 	}

		// }

		$id = urldecode($id);

		$data['code_header'] = $this->m_p->get_html_codes(7);

		$data['p'] = $this->m_p->s_a("landing_pages", array("slug" => $id), 1)[0] ?? null;

		if(!$data['p'])
			show_404();

		$this->load->view("landing/index", $data);

	}
	public function order()
	{
		if(!isset($_POST['order']))
		{
			show_404();
		}

		$id = (int) $this->input->post("id");
		$qty = (int) $this->input->post("qty");
		$fullname = trim((string) $this->input->post("fullname"));
		$phone = trim((string) $this->input->post("phone"));

		$products = array();

		$tprice = 0;

		$ids = [];

		$ship = 0;

		$data['info'] = $this->m_p->s_a("landing_pages", array("id" => $id), 1);

		if(count($data['info']) == 0)
			show_404();

		// name and phone are required to deliver the order
		if($fullname === "" || $phone === "")
			redirect("l/" . rawurlencode($data['info'][0]->slug));

		rate_limit_or_die("order_" . $this->input->ip_address(), 5, 15 * 60);

		foreach($data['info'] as $key)
		{

			// bundle prices for 2 or 3 pieces when they are set, otherwise one piece
			if($qty == 2 && $key->price2 > 0) {
				$tpr = $key->price2;
			} elseif($qty == 3 && $key->price3 > 0) {
				$tpr = $key->price3;
			} else {
				$qty = 1;
				$tpr = floor($key->price - ($key->price * $key->discount / 100));
			}

			$ids[] = $key->product_id;

			$products[] = [
				"id" => $key->product_id,
				"q" => $qty,
				"options" => json_encode([])
			];

			$tprice = $tprice + $tpr;
			$ship = $ship + $key->shipping;


		}


		$arr = array(
			"name" => $fullname,
			"tele" => $phone,
			"city" => $this->input->post("city"),
			"address"      => $this->input->post("address") ?? "-",
			"totalPrice" => $tprice + $ship,
			"products" => json_encode($products),
			"date" => time()
		);

		$ido = $this->m_p->ins("orders", $arr);

		$this->session->set_userdata("price", $tprice + $ship);
		$this->session->set_userdata("landing", $id);
		$this->session->set_userdata("orderId", $ido);

		redirect("landing/thanks");

	}
}
