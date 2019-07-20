<?php
if ( !defined('BASEPATH') ) exit();
/**
* @author hobrt.me
* @file Admin.php
* @package hobrtEcom
* @link hobrt.me
* @copyright hobrt.me 2018 => 2019
*
**/
class Admin extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!is_login("admin_login"))
		{
			redirect("user/admin_login");
		}
	}


	function admins()
	{

		$config = $config = page_a($this->m_p->get_num("admins", array()), "admin/admins", 3, $this->config->item("per_page"));

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$data['admins'] = $this->m_p->s_a("admins", array(), $config["per_page"], $page);

		$data["links"] = $this->pagination->create_links();

		//$data['admins'] = $this->m_p->s_a("admins");
		$this->load->view('admin/admins', $data);
	}
	function edit_admin($id = false)
	{

		if($id == false)
			redirect("admin");

		if (isset($_POST['test']))
		{
			$arr = array_pop($_POST);
			$arr = array_pop($_POST);
			foreach ($_POST as $key => $value) {
				$_POST[$key] = $this->input->post($key);
			}
			if(empty($_POST['password']))
			{
				$_POST['password'] = $this->m_p->get_info("admins",$id,"password");
			}else
			{
				$_POST['password'] = _hash($_POST['password']);
			}
			$this->m_p->up_d('admins',$_POST,"id = $id");

		}
		$data['info'] = $this->m_p->s_a("admins","id = $id",1,0);
		$this->load->view("admin/edit_admin",$data);
	}
	function add_admin()
	{
		admin_perm(1);
		$data = array();
		if(isset($_POST['test']))
		{
			$arr = array_pop($_POST);
			foreach ($_POST as $key => $value) {
				$_POST[$key] = $this->input->post($key);
				if($key == "password")
					$_POST[$key] = _hash($_POST[$key]);

			}
			$data['msg'] = true;
			$useri = $this->m_p->ins('admins',$_POST);

		}
		$this->load->view("admin/add_admin",$data);
	}

	public function requests()
	{

		$config = $config = page_a($this->m_p->get_num("orders", array()), "admin/requests", 3, $this->config->item("per_page"));

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$data['msg'] = $this->m_p->s_a("orders", array(), $config["per_page"], $page);

		$data["links"] = $this->pagination->create_links();

		$this->load->view("admin/requests",$data);
	}
	public function detiales($id)
	{
		if(isset($_POST['test']))
		{
			$arr = array(
				"status" => $this->input->post("status"),
				"address" => $this->input->post("address")
			);
			$this->m_p->up_d("orders", $arr, array("id" => $id));
		}

		$data['msg'] = $this->m_p->s_a("orders","id = $id",1,0);
		$this->load->view("admin/detiales",$data);
	}

	public function accept($id)
	{
		
		$this->m_p->up_d("requests", array("tp" => 1) , array("id" => $id));

		redirect("admin/requests");
	}
	public function unaccept($id)
	{

		$this->m_p->up_d("requests", array("tp" => 2) , array("id" => $id));

		redirect("admin/requests");
	}


	public function messages()
	{

		$config = $config = page_a($this->m_p->get_num("msg", array()), "admin/messages", 3, $this->config->item("per_page"));

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$data['msg'] = $this->m_p->s_a("msg", array(), $config["per_page"], $page);

		$data["links"] = $this->pagination->create_links();

		$this->load->view("admin/messages",$data);
	}
	public function show_msg($id)
	{
		$data['msg'] = $this->m_p->s_a("msg","id = $id",1,0);
		$this->load->view("admin/show_msg",$data);
	}

	public function cat()
	{
		$data['tp'] = "all";
		$data['cat'] = $this->m_p->s_a("cats", array(), FALSE, 0, array("*"), "position", "ASC");
		$this->load->view('admin/cats', $data);
	}
	public function add_cat()
	{

		$data = array();
		$data['tp'] = "add";
		if(isset($_POST['test']))
		{
			$arr = array_pop($_POST);
			foreach ($_POST as $key => $value) {
				$_POST[$key] = $this->input->post($key);
			}
			$data['msg'] = true;
			$this->m_p->ins('cats',$_POST);
		}
		$this->load->view("admin/cats",$data);
	}
	function edit_cat($id)
	{
		$data['cat'] = $this->m_p->s_a("cats","id = $id",1,0);
		$data['tp'] = "edit";
		$this->load->view("admin/cats",$data);
		if(isset($_POST['test']))
		{
			$arr = array_pop($_POST);
			foreach ($_POST as $key => $value) {
				$_POST[$key] = $this->input->post($key);
			}
			$this->m_p->up_d('cats',$_POST,"id = $id");
			redirect("admin/cat");
		}
	}


	public function products()
	{
		$data['tp'] = "all";


		$config = $config = page_a($this->m_p->get_num("products", array()), "admin/products", 3, $this->config->item("per_page"));

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$data['cat'] = $this->m_p->s_a("products", array(), $config["per_page"], $page);

		$data["links"] = $this->pagination->create_links();

		$this->load->view('admin/products', $data);
	}
	public function add_product()
	{
		$this->load->library("libre");

		$data = array();
		$data['tp'] = "add";

		$data['cats'] = $this->m_p->s_a("cats", array(), FALSE);

		if(isset($_POST['test']))
		{
			$arr = array_pop($_POST);

			$_POST['images'] = $this->libre->doupload("file", 'gif|jpg|jpeg|png');

			foreach ($_POST as $key => $value) {
				$_POST[$key] = $this->input->post($key);
			}
			$data['msg'] = true;
			$this->m_p->ins('products',$_POST);
		}
		$this->load->view("admin/products",$data);
	}
	function edit_product($id)
	{
		
		$this->load->library("libre");
		$data['cat'] = $this->m_p->s_a("products","id = $id",1,0);
		$data['cats'] = $this->m_p->s_a("cats", array(), FALSE);
		$data['tp'] = "edit";
		$this->load->view("admin/products",$data);
		if(isset($_POST['test']))
		{
			$arr = array_pop($_POST);

			$imgs = $this->libre->doupload("file", 'gif|jpg|jpeg|png|mp4');
			if(isset($_POST['old_img']))
			{
				if(empty($imgs))
				{
					$_POST['images'] = implode(",", $_POST['old_img']);
				}else {
					$_POST['images'] = implode(",", $_POST['old_img']).",".$imgs;
				}
				unset($_POST['old_img']);
			}else {
				$_POST['images'] = $imgs;
			}

			foreach ($_POST as $key => $value) {
				$_POST[$key] = $this->input->post($key);
			}
			$this->m_p->up_d('products',$_POST,"id = $id");
			redirect("admin/products");
		}
	}

	public function discounts()
	{
		$data['tp'] = "all";


		$config = $config = page_a($this->m_p->get_num("discounts", array()), "admin/discounts", 3, $this->config->item("per_page"));

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$data['cat'] = $this->m_p->s_a("discounts", array(), $config["per_page"], $page);

		$data["links"] = $this->pagination->create_links();

		$this->load->view('admin/faqs', $data);
	}
	public function add_discount()
	{

		$data = array();
		$data['tp'] = "add";

		$data['cats'] = $this->m_p->s_a("cats", array(), FALSE);

		if(isset($_POST['test']))
		{
			$arr = array_pop($_POST);

			foreach ($_POST as $key => $value) {
				$_POST[$key] = $this->input->post($key);
			}
			$data['msg'] = true;
			$this->m_p->ins('discounts',$_POST);
		}
		$this->load->view("admin/faqs",$data);
	}
	function edit_discount($id)
	{
		$data['cat'] = $this->m_p->s_a("discounts","id = $id",1,0);
		$data['tp'] = "edit";
		$data['cats'] = $this->m_p->s_a("cats", array(), FALSE);
		$this->load->view("admin/faqs",$data);
		if(isset($_POST['test']))
		{

			$arr = array_pop($_POST);

			foreach ($_POST as $key => $value) {
				$_POST[$key] = $this->input->post($key);
			}
			$this->m_p->up_d('discounts',$_POST,"id = $id");
			redirect("admin/discounts");
		}
	}


	function index()
	{
		$data['mo1'] = $this->m_p->get_num("products");
		$data['mo2'] = $this->m_p->get_num("orders", array("status" => 1));
		$data['mo3'] = $this->m_p->get_num("orders", array("status" => 5));
		$data['mo4'] = $this->m_p->get_num("reviews");

		$data['cat'] = $this->m_p->s_a("orders", array(), 6);

		$date = date("Y-m-d");

		$data['endsoon'] = $this->m_p->s_a("discounts", array("DATEDIFF(date, '$date') > " => 0), 6);
		$data['lastadd'] = $this->m_p->s_a("products", array(), 6);

		$this->load->view("admin/main.php",$data);
	}

	public function setting()
	{

		if(isset($_POST['test']))
		{
			
			$config['upload_path'] 				= './logo/';
			$config['allowed_types'] 			= 'gif|jpg|png';
			$config['encrypt_name'] 			= TRUE;
			$config['max_size']					= '10240'; // 10 MB
			$this->upload->initialize($config);
			$a = $this->upload->do_upload('logo');
			$data_upload = $this->upload->data();
			$arr = array_pop($_POST);
			if($a)
				$_POST['logo'] = $data_upload['file_name'];

			foreach ($_POST as $key => $value) {
				$_POST[$key] = $this->input->post($key);
			}
			$this->m_p->up_d('settings',$_POST);
		}
		$data['setting'] = $this->m_p->se_a("settings");
		$this->load->view("admin/setting",$data);
	}

	public function delt($table,$id,$red,$tp=false)
	{
		$this->m_p->delete($table, array("id" => $id));
		$to = $tp === false ? "admin/".$red : "admin".$red."/".$tp ;
		if (!$this->input->is_ajax_request()) {
		   redirect($to);
		}
		echo "1";
	}

	public function order_save()
	{
		foreach ($_POST as $key => $value) {
			$table = $key;
		}


		foreach ($_POST[$table] as $key => $value) {
			$this->m_p->qe("UPDATE $table SET position = '$key' WHERE id = '$value'");
		}
	}


	/*****************************************************
		   *            **	       *        
		  ***                     ***       **     **
		 ** **          **	     ** **       **   **
		**   **         **	    **   **       ** **
	   *********        **	   *********       ***
	  ***********       **	  ***********     ** **
	 **         **	**  **	 **         **   **   **
	**           **	*****	**           ** **     **

		Ajax Functions
	******************************************************/

	public function approve_comment()
	{
		if(isset($_POST['id']))
		{
			$id = intval($this->input->post("id"));

			$this->m_p->up_d("reviews", array("ac" => 1), array("id"=> $id));

			echo "1";
		}
	}

	public function delete_comment()
	{
		if(isset($_POST['id']))
		{
			$id = intval($this->input->post("id"));

			$this->m_p->delete("reviews", array("id" => $id));

			echo "1";
		}
	}

	public function test() {

		if (!$this->input->is_ajax_request()) {
		   exit('No direct script access allowed');
		}

		$id = $data['id'] = $this->input->post("id");

		$data['user'] = $this->input->post("user");

		$data['info'] = $this->m_p->s_a("packages", array("id" => $id), 1);

		$data['mats'] = $this->m_p->s_a("mat", array(), FALSE, 0, array("*"), "position", "ASC");

		$data['classroom'] = $this->m_p->s_a("classroom", array(), FALSE, 0, array("*"), "position", "ASC");

		$this->load->view("admin/test", $data);

	}


	/*****************************************************
		   *            **	       *        
		  ***                     ***       **     **
		 ** **          **	     ** **       **   **
		**   **         **	    **   **       ** **
	   *********        **	   *********       ***
	  ***********       **	  ***********     ** **
	 **         **	**  **	 **         **   **   **
	**           **	*****	**           ** **     **
		End Ajax Functions
	******************************************************/

}