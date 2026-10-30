<?php
if(!defined('BASEPATH')) exit();
/**
* @author hobrt.me
* @file Login.php
* @package hobrtEcom
* @link hobrt.me
* @copyright hobrt.me 2018 => 2022
*
**/

use chriskacerguis\RestServer\RestController;

class Login extends RestController
{
	
	public function index_post() {

		// With a secret admin address (settings), the app must send it too;
		// otherwise this is a 404 like user/admin_login and the admin pages.
		$path = admin_path();
		if ($path !== '' && !hash_equals($path, strtolower(trim((string) $this->input->post('admin_path'), " /"))))
			show_404();

		$this->load->library('jwt_public');

		if(isset($_POST['u']))
		{

			$login = $this->m_p->login($this->input->post("u"), $this->input->post("p"));

			if(is_object($login)) {

				$user_id = $login->id;

				$token = $this->jwt_public->generate_token($login);

				if($token[0] === 200)
					$this->m_p->up_d('admins', ['device_id' => (string) ($this->input->post('device_token') ?? '')], ['id' => $user_id]);

				return $this->response($token[1], $token[0]);

			}else {
				$data = ['message' => $login, 'code' => 403];

				return $this->response($data, 403);
			}
		}

		$data = ['message' => "Username is required .", 'code' => 403];

		return $this->response($data, 403);
	}
}



/* End of file user.php */
/* Location ./application/controllers/user.php */