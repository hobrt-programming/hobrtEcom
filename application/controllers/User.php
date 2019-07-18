<?php
if(!defined('BASEPATH')) exit();
/**
* @author hobrt.me
* @file User.php
* @package hobrtEcom
* @link hobrt.me
* @copyright hobrt.me 2018 => 2019
*
**/
class User extends CI_Controller
{
	
	public function admin_login()
	{
		$data = array();
		if(isset($_POST['u']))
		{
			$u = $this->input->post("u");
			$p = _hash($this->input->post("p"));
			$r = $this->m_p->s_a("admins", array("username" => $u, "password" => $p));
			if(count($r) > 0)
			{
				foreach ($r as $key) {
					$id = $key->id;
				}
				$arr = array("id" => $id);
				$this->session->set_userdata('admin_login',$arr);
				redirect('admin');
			}else
			{
				$data['msg'] = "البيانات المدخلة غير صحيحة ";
			}
		}
		$this->load->view('admin/login',$data);
	}

	public function logout()
	{
		$this->session->unset_userdata('admin_login');
        $this->session->sess_destroy();
        redirect("home");
	}
}



/* End of file user.php */
/* Location ./application/controllers/user.php */