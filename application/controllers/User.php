<?php
if(!defined('BASEPATH')) exit();
/**
* @author hobrt.me
* @file User.php
* @package hobrtEcom
* @link hobrt.me
* @copyright hobrt.me 2018 => 2022
*
**/

class User extends CI_Controller
{
	
	public function admin_login()
	{
		// with a secret login address (settings) this URL does not exist
		if (admin_path() !== '')
			show_404();

		admin_login_page();
	}

	/** POST only (with the CSRF token), so another site can't log the admin out */
	public function logout()
	{
		if ($this->input->method() !== 'post')
			redirect(is_login('admin_login') ? 'admin' : 'home');

		$this->session->unset_userdata('admin_login');
		$this->session->sess_destroy();

		// back to the login page: the secret address when one is set
		redirect((admin_path() !== '' ? admin_path() : 'user/admin_login') . '?out=1');
	}
}



/* End of file user.php */
/* Location ./application/controllers/user.php */