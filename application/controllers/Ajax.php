<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* @author hobrt.me
* @file Ajax.php
* @package hobrtEcom
* @link hobrt.me
* @copyright hobrt.me 2018 => 2022
*
**/


class Ajax extends CI_Controller {

	public function validCoupon()
	{
		if (!$this->input->is_ajax_request()) {
		   exit('No direct script access allowed');
		}

		// slows down guessing coupon codes
		if (!rate_limit("coupon_" . $this->input->ip_address(), 20, 10 * 60)) {
			echo "0";
			return;
		}

		$coupon = (string) $this->input->post("coupon");

		$date = date("Y-m-d");

		$c = $this->m_p->s_a("discounts", array("coupon" => $coupon, "date >=" => $date));

		if(count($c) == 0)
			echo "0";
		else {
			foreach ($c as $key) {
				echo $key->num;
			}
		}

	}



	public function addToFav()
	{
		if (!$this->input->is_ajax_request()) {
		   exit('No direct script access allowed');
		}

		$ret = array();

		$ret['suc'] = 3;

		$id = (int) $this->input->post("id");

		$info = $this->m_p->findOneById("products", $id);

		if($info)
		{

			if(is_null(get_cookie("fav"))){

				$arr = array();

				$arr[] = $id;

				$f = json_encode($arr);

				$cookie = array(
					'name'   => 'fav',
					'value'  => $f,
					'expire' => time()+12586500
				);

				set_cookie($cookie);

				$ret['suc'] = 1;
			}else {
				$arr = json_decode(get_cookie("fav"), TRUE);

				if(!is_array($arr))
					$arr = array();

				if(!in_array($id, $arr))
				{
					$arr[] = $id;
				}

				$f = json_encode($arr);

				$cookie = array(
					'name'   => 'fav',
					'value'  => $f,
					'expire' => time()+12586500
				);

				set_cookie($cookie);

				$ret['suc'] = 1;
				
			}
		}

		echo json_encode($ret);

	}

	public function addToCart()
	{
		if (!$this->input->is_ajax_request()) {
		   exit('No direct script access allowed');
		}

		$ret = array();

		$ret['suc'] = 3;

		$id = (int) $this->input->post("id");
		$q  = clean_qty($this->input->post("qty"));

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

				$op = json_encode(clean_product_options($info[0], $_POST['option'] ?? array()), JSON_UNESCAPED_UNICODE);

				$arr[$id] = array("name" => $title, "id" => $id, "price" => $price, "img" => $img, "q" => $q, "op" => $op);
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

				if(!is_array($arr))
					$arr = array();

				$options = clean_product_options($info[0], $_POST['option'] ?? array());

				if(array_key_exists($id, $arr) && $arr[$id]["op"] == json_encode($options, JSON_UNESCAPED_UNICODE))
				{
					$q = clean_qty($q + clean_qty($arr[$id]["q"] ?? 1));

					$arr[$id] = array("name" => $title, "id" => $id, "price" => $price, "img" => $img, "q" => $q, "op" => json_encode($options, JSON_UNESCAPED_UNICODE));
				}else {
					$arr[$id] = array("name" => $title, "id" => $id, "price" => $price, "img" => $img, "q" => $q, "op" => json_encode($options, JSON_UNESCAPED_UNICODE));
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

		if(is_array($arr) && array_key_exists($id, $arr))
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

	public function submit_review() {
		$this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('rating', 'Rating', 'trim|required|integer|greater_than[0]|less_than[6]');
        $this->form_validation->set_rules('comment', 'Comment', 'trim|max_length[2000]');
        $this->form_validation->set_rules('product_id', 'Product', 'required|is_natural_no_zero');

        if (!rate_limit("review_" . $this->input->ip_address(), 5, 60 * 60)) {
			$this->output
            ->set_content_type('application/json')
            ->set_status_header(429)
            ->set_output(json_encode(['success' => false, 'errors' => 'Too many reviews, please try again later.']));
			return;
        }

        if ($this->form_validation->run() == FALSE || !$this->m_p->findOneById("products", $this->input->post("product_id"))) {
            // Validation failed, return validation errors
            $response['success'] = false;
            $response['errors'] = validation_errors();
			$this->output
            ->set_content_type('application/json')
            ->set_status_header(422)
            ->set_output(json_encode($response));
        } else {
            // Validation successful, perform database insert or other actions
            $response['success'] = true;
            // Insert review
			$img = upload_one_file($file = "img", $width = 500, $height = 500, $folder = './images/');
				
			$arr = array(
				"name" => $this->input->post("name"),
				"email" => $this->input->post("email"),
				"rating" => $this->input->post("rating"),
				"comment" => $this->input->post("comment"),
				"img" => $img,
				"product_id" => (int) $this->input->post("product_id")
			);

			$response['review_id'] = $this->m_p->ins("reviews", $arr);
			$this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
        }
	}

	/**
	 * Newsletter signup from the store themes (switched on in admin > Newsletter).
	 * Answers JSON: {ok: bool, message: string}
	 */
	public function subscribe()
	{
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}

		load_lang();

		$reply = function ($ok, $key) {
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(array("ok" => $ok, "message" => lang($key)), JSON_UNESCAPED_UNICODE));
		};

		$email = strtolower(trim((string) $this->input->post("email")));

		if (!newsletter_enabled())
			return $reply(FALSE, "lang_h116");

		if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 250)
			return $reply(FALSE, "lang_h115");

		if ($this->m_p->get_num("newsletter", array("email" => $email)) > 0)
			return $reply(TRUE, "lang_h114");

		// one IP can not fill the list with addresses (only new signups count)
		if (!rate_limit("newsletter_" . $this->input->ip_address(), 20, 60 * 60))
			return $reply(FALSE, "lang_h116");

		$this->m_p->ins("newsletter", array(
			"email" => $email,
			"lang" => (string) setting("store_lng"),
			"ip" => $this->input->ip_address(),
		));

		return $reply(TRUE, "lang_h113");
	}
}
