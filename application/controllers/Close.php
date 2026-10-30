<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* @author hobrt.me
* @file Close.php
* @package hobrtEcom
* @link hobrt.me
* @copyright hobrt.me 2018 => 2022
*
**/
class Close extends CI_Controller {

	public function index()
	{
		$theme = setting("theme");

		// themes may provide their own close.php, otherwise show a plain 503 page
		if (in_array($theme, available_themes(), TRUE) && is_file(VIEWPATH . "front/" . $theme . "/close.php"))
			return $this->load->view("front/" . $theme . "/close");

		show_error(html_escape(setting("title")) . " is temporarily closed.", 503, "Store closed");
	}

}