<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author hobrt.me
 * @file Default_404.php
 * @package hobrtEcom
 *
 * Every URL that matches no page ends here (routes.php: 404_override).
 * The secret admin login address (admin > settings) is one of them: it shows
 * the login form. Anything else is a normal 404.
 */
class Default_404 extends CI_Controller
{
	public function index()
	{
		$path = admin_path();
		if ($path !== '' && hash_equals($path, trim($this->uri->uri_string(), '/'))) {
			if (is_login('admin_login'))
				redirect('admin');
			return admin_login_page(TRUE);
		}

		show_404();
	}
}
