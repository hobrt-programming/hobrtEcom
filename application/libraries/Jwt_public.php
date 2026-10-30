<?php

/** Requiere the JWT library. */
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;


/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @author     Enrique Chavez <noone@tmeister.net>
 */
class Jwt_public
{

	/**
	 * Store errors to display if the JWT is wrong
	 *
	 * @var WP_Error
	 */
	private $jwt_error = null;

	/**
	 * Admin id from the last token validate_token() accepted (0 before that).
	 *
	 * @var int
	 */
	public $user_id = 0;

	/**
	 * Per-install secret from config.php (secrets.php / HBECOM_JWT_SECRET).
	 * Too short or missing secrets disable the API instead of signing weak tokens.
	 */
	private function secret_key()
	{
		$CI = &get_instance();
		$secret = (string) $CI->config->item('jwt_secret');
		return strlen($secret) >= 32 ? $secret : false;
	}

	/**
	 * Get the user and password in the request body and generate a JWT
	 *
	 * @param [type] $request [description]
	 *
	 * @return [type] [description]
	 */
	public function generate_token($user)
	{
		$secret_key = $this->secret_key();


		/** First thing, check the secret key if not exist return a error*/
		if (!$secret_key) {

			return $this->Response(403, [
				"message" => "JWT is not configurated properly, please contact the admin."
			]);
		}

		/** Valid credentials, the user exists create the according Token */
		$issuedAt = time();
		$notBefore = $issuedAt;
		$expire = $issuedAt + (24 * 3600 * 30);

		$token = array(
			'iss' => base_url(),
			'iat' => $issuedAt,
			'nbf' => $notBefore,
			'exp' => $expire,
			'data' => array(
				'user' => array(
					'id' => $user->id,
				),
			),
		);

		/** Let the user modify the token data before the sign. */
		$token = JWT::encode($token, $secret_key, 'HS256');

		/** The token is signed, now create the object with no sensible user data to the client*/
		$data = array(
			'token' => $token,
			'username' => $user->username
		);

		/** Let the user modify the data before send it back */
		return $this->Response(200, $data);
	}

	public function Response($code, $data)
	{
		return [$code, $data];
	}

	/**
	 * Main validation function, this function try to get the Autentication
	 * headers and decoded.
	 *
	 * @param bool $output
	 *
	 * @return WP_Error | Object | Array
	 */
	public function validate_token($output = true)
	{
		/*
		 * Looking for the HTTP_AUTHORIZATION header, if not present just
		 * return the user.
		 */

		$auth = isset($_SERVER['HTTP_AUTHORIZATION']) ? $_SERVER['HTTP_AUTHORIZATION'] : false;

		/* Double check for different auth header string (server dependent) */
		if (!$auth) {
			$auth = isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION']) ? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] : false;
		}

		if (!$auth) {
			return $this->Response(403, [
				"message" => "Authorization header not found."
			]);
		}

		/*
		 * The HTTP_AUTHORIZATION is present verify the format
		 * if the format is wrong return the user.
		 */
		list($token) = sscanf($auth, 'Bearer %s');
		if (!$token) {

			return $this->Response(403, [
				"message" => "Authorization header malformed."
			]);
		}

		/** Get the Secret Key */
		$secret_key = $this->secret_key();
		if (!$secret_key) {
			
			return $this->Response(403, [
				"message" => "JWT is not configurated properly, please contact the admin."
			]);
		}

		/** Try to decode the token */
		try {
			$token = JWT::decode($token, new Key($secret_key, 'HS256'));
			/** The Token is decoded now validate the iss */
			if ($token->iss != base_url()) {
				/** The iss do not match, return error */
				
				return $this->Response(403, [
					"message" => "The iss do not match with this server."
				]);

			}
			/** So far so good, validate the user id in the token */
			if (!isset($token->data->user->id)) {
				/** No user id in the token, abort!! */
				
				return $this->Response(403, [
					"message" => "User ID not found in the token."
				]);
			}

			/** The admin account must still exist (deleted admins lose API access) */
			$CI = &get_instance();
			if (!$CI->m_p->findOneById("admins", (int) $token->data->user->id)) {
				return $this->Response(403, [
					"message" => "User not found."
				]);
			}

			$this->user_id = (int) $token->data->user->id;

			/** If the output is true return an answer to the request to show it */
			return TRUE;

		} catch (Throwable $e) {
			/** Something is wrong trying to decode the token, send back the error */
			
			return $this->Response(403, [
				"message" => $e->getMessage()
			]);
		}
	}
}