<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* @author hobrt.me
* @file Ajax.php
* @package hobrtEcom
* @link hobrt.me
* @copyright hobrt.me 2018 => 2019
*
**/


class Ajax extends CI_Controller {


	function get_classrooms()
	{
		if (!$this->input->is_ajax_request()) {
		   exit('No direct script access allowed');
		}
		$data['mat'] = $this->input->post("mat");

		$data['name'] = "الفصل";


		$data["classes"] = $this->m_p->s_a("classroom", array(), FALSE, 0, array("*"), "position", "ASC");

		$this->load->view(template."/ajax", $data);
	}

	public function load_more_credit()
	{

		if (!$this->input->is_ajax_request()) {
		   exit('No direct script access allowed');
		}

		if(!login())
		{
			exit('No direct script access allowed');
		}

		$user = login();

		$page = $this->input->post("page");

		$start = $this->config->item("per_page") * $page; 

		$data['pays'] = $this->m_p->s_a("credit_history", array("user" => $user), $this->config->item("per_page"), $start);

		if(count($data['pays']) == 0){
			echo "1";
			exit();
		}

		$this->load->view(template."/ajax/credit", $data);

	}

	public function validCoupon()
	{
		if (!$this->input->is_ajax_request()) {
		   exit('No direct script access allowed');
		}

		$coupon = $this->input->post("coupon");

		$date = "Y-m-d";

		$c = $this->m_p->s_a("discounts", array("coupon" => $coupon, "date >=" => $date));

		if($c == 0)
			echo "0";
		else {
			foreach ($c as $key) {
				echo $key->num;
			}
		}

	}

	public function addToCart()
	{
		if (!$this->input->is_ajax_request()) {
		   exit('No direct script access allowed');
		}

		$ret = array();

		$ret['suc'] = 3;

		$id = $this->input->post("id");
		$q  = $this->input->post("q");

		$info = $this->m_p->s_a("products", array("id" => $id), 1);

		if(count($info) > 0)
		{
			foreach($info as $key)
			{
				$title 	= $key->title;
				$price 	= $key->price;
				$img 	= add_thumb($key->images, "_m");
			}

			if(is_null(get_cookie("cart"))){

				$arr = array();

				$arr[$id] = array("name" => $title, "id" => $id, "price" => $price, "img" => $img, "q" => $q);
				$ret['info'] = array("name" => $title, "id" => $id, "price" => $price, "img" => $img);

				$f = json_encode($arr);

				$cookie = array(
					'name'   => 'cart',
					'value'  => $f,
					'expire' => time()+12586500
				);

				set_cookie($cookie);

				$ret['suc'] = 1;
			}else {
				$arr = json_decode(get_cookie("cart"), TRUE);

				if(array_key_exists($id, $arr))
				{
					$q = $q + $arr[$id]["q"];

					$arr[$id] = array("name" => $title, "id" => $id, "price" => $price, "img" => $img, "q" => $q);
				}else {
					$arr[$id] = array("name" => $title, "id" => $id, "price" => $price, "img" => $img, "q" => $q);
				}
				$ret['info'] = array("name" => $title, "id" => $id, "price" => $price, "img" => $img);

				$f = json_encode($arr);

				$cookie = array(
					'name'   => 'cart',
					'value'  => $f,
					'expire' => time()+12586500
				);

				set_cookie($cookie);

				$ret['suc'] = 1;
				
			}
		}

		echo json_encode($ret);

	}

	public function deleteFromCart()
	{
		if (!$this->input->is_ajax_request()) {
		   exit('No direct script access allowed');
		}

		$id = $this->input->post("id");


		$arr = json_decode(get_cookie("cart"), TRUE);

		if(array_key_exists($id, $arr))
		{
			unset($arr[$id]);
			$f = json_encode($arr);

			$cookie = array(
				'name'   => 'cart',
				'value'  => $f,
				'expire' => time()+12586500
			);

			set_cookie($cookie);

			echo "1";
		}else {

			echo "2";

		}

	}

}