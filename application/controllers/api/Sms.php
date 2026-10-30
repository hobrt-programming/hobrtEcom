<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* @author hobrt.me
* @file Sms.php
* @package hobrtEcom
* @link hobrt.me
* @copyright hobrt.me 2018 => 2022
*
**/

use chriskacerguis\RestServer\RestController;

class Sms extends RestController {

	public function early_checks()
	{
		$this->load->library('jwt_public');

		$valide_token = $this->jwt_public->validate_token();

		if($valide_token !== TRUE) {
			$this->response($valide_token[1], $valide_token[0]);
			exit;
		}
	}

	public function index_get()
	{
		$sms = $this->m_p->s_a("sms", array('sent' => 0));

		$o['sms'] = $sms;

		return $this->response($o, 200);
	}
}
