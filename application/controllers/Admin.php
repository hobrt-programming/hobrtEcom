<?php
if (!defined('BASEPATH')) exit();
/**
 * @author hobrt.me
 * @file Admin.php
 * @package hobrtEcom
 * @link hobrt.me
 * @copyright hobrt.me 2018 => 2022
 *
 **/
class Admin extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		if (!is_login("admin_login")) {
			// with a secret login address (settings) the admin is a 404 for visitors
			if (admin_path() !== '')
				show_404();
			redirect("user/admin_login");
		}

		load_admin_lang();
		define('admin', 'enAdmin');

		$this->load->library('upload');
	}

	public function sheet_connect()
	{

		$gsheet = $this->m_p->s_a("google_sheets", array(), 1);

		if (count($gsheet) == 0)
			redirect("admin/gsheets");

		$google_client = new Google_Client();

		foreach ($gsheet as $key) {
			$client_id = $key->client_id;
			$client_secret = $key->client_secret;
			$id = $key->id;
			$sheetId = $key->sheetId;
		}

		$google_client->setClientId($client_id);

		$google_client->setClientSecret($client_secret);

		$google_client->setRedirectUri(base_url("admin/sheet_connect"));

		$google_client->addScope('email');

		$google_client->addScope('profile');

		$google_client->addScope(Google_Service_Sheets::SPREADSHEETS);

		$google_client->setAccessType("offline");

		$google_client->setApprovalPrompt("force");


		if (isset($_GET["code"])) {
			// the callback must answer the authorization started from gsheets()
			$state = $this->session->userdata('gsheet_oauth_state');
			$this->session->unset_userdata('gsheet_oauth_state');
			if (!is_string($state) || !is_string($this->input->get("state")) || !hash_equals($state, $this->input->get("state")))
				show_error('Invalid OAuth state, please try connecting again.', 403);

			$token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

			if (!isset($token["error"])) {
				$google_client->setAccessToken($token['access_token']);

				$this->session->set_userdata('access_token', $token['access_token']);

				$google_service = new Google_Service_Oauth2($google_client);

				$data = $google_service->userinfo->get();

				$arrToins = [
					"token" => $token['access_token'],
					"refresh_token" => $token['refresh_token'],
					"expire" => $token['expires_in'],
					"email" => $data->email,
				];

				$this->m_p->up_d("google_sheets", $arrToins, array("id" => $id));

				$google_client = new Google_Client();

				$google_client->setClientId($client_id);

				$google_client->setClientSecret($client_secret);

				$google_client->setRedirectUri(base_url("admin/sheet_connect"));

				$google_client->addScope('email');

				$google_client->addScope('profile');

				$google_client->addScope(Google_Service_Sheets::SPREADSHEETS);

				$google_client->setAccessType("offline");

				$google_client->setApprovalPrompt("force");

				$token1 = [
					"access_token" => $token['access_token'],
					"refresh_token" => $token['refresh_token'],
					"expires_in" => $token['expires_in']
				];

				$google_client->setAccessToken($token1);

				$googleSheet = new Google_Service_Sheets($google_client);

				$values = [
					[
						"Date",
						"Products",
						"Qty",
						"Name",
						"Address",
						"Phone number",
						"City",
						"Price"
					]
				];

				$range2 = "A1:K";

				$body = new Google_Service_Sheets_ValueRange([
					'values' => $values
				]);


				$params = [
					'valueInputOption' => "RAW"
				];

				$res = $googleSheet->spreadsheets_values->append($sheetId, $range2, $body, $params);

				redirect('admin/gsheets');
			} else
				echo html_escape($token["error"]);
		}
	}


	public function gsheets()
	{

		$data = [];

		$data['gsheet'] = $this->m_p->s_a("google_sheets", array(), 1);

		if (isset($_POST['sheetId'])) {

			$arr = [
				"client_id" => $this->input->post("client_id"),
				"client_secret" => $this->input->post("client_secret"),
				"sheetId" => $this->input->post("sheetId")
			];

			if (count($data['gsheet']) == 0) {

				$this->m_p->ins("google_sheets", $arr);
			} else {

				foreach ($data['gsheet'] as $key) {
					$id = $key->id;
				}

				$this->m_p->up_d("google_sheets", $arr, array("id" => $id));
			}

			$google_client = new Google_Client();

			$google_client->setClientId($this->input->post("client_id"));

			$google_client->setClientSecret($this->input->post("client_secret"));

			$google_client->setRedirectUri(base_url("admin/sheet_connect"));

			$google_client->addScope('email');

			$google_client->addScope('profile');

			$google_client->addScope(Google_Service_Sheets::SPREADSHEETS);

			$google_client->setAccessType("offline");

			$google_client->setApprovalPrompt("force");

			$state = bin2hex(random_bytes(16));
			$this->session->set_userdata('gsheet_oauth_state', $state);
			$google_client->setState($state);

			redirect($google_client->createAuthUrl());
		}

		$this->load->view(admin . "/gsheet", $data);
	}


	public function index()
	{
		$stoday = strtotime(date("Y-m") . "-01 00:00");
		$etoday = strtotime(date("Y-m") . "-28 23:59");

		$startMonth = strtotime("01-" . date("m-Y"));

		$wh = "WHERE date > $startMonth ";


		if (isset($_GET['test'])) {

			array_pop($_GET);

			$w = [];
			$w2 = [];

			foreach ($_GET as $key => $value) {
				// skip empty or invalid dates (they used to break the query)
				if (!empty($value) && is_string($value)) {

					switch ($key) {
						case 'date3':
							if (($date1 = strtotime($value . " +1 day")) !== FALSE)
								$w2[] = "date < " . (int) $date1;
							break;
						case 'date4':
							if (($date2 = strtotime($value)) !== FALSE)
								$w2[] = "date > " . (int) $date2;
							break;
					}
				}
			}

			$w3 = array_merge($w, $w2);

			if (count($w3) > 0)
				$wh = " WHERE " . implode(" AND ", $w3);
		}

		$o['all'] = $this->m_p->qe_r("SELECT o.*, COUNT(o.id) AS total, COUNT(IF(o.confirmationDate != 0, 1, null)) AS tc FROM orders o WHERE date > $stoday AND date <= $etoday  LIMIT 1");

$sql = <<<EOD
SELECT
    o.*,
    COUNT(o.id) AS total,
    COUNT(IF(o.status = 1, 1, null)) AS tp,
    COUNT(IF(o.status = 2, 1, null)) AS tc,
    COUNT(IF(o.status = 0, 1, null)) AS tcan,
    COUNT(IF(o.status = 3, 1, null)) AS tship,
    COUNT(IF(o.status = 6, 1, null)) AS td,
    COUNT(IF(o.status = 7, 1, null)) AS trt,
    COUNT(IF(o.status = 8, 1, null)) AS trf,
    COUNT(IF(o.status = 5, 1, null)) AS ts,
    SUM(IF(o.status = 6, o.totalPrice, 0)) AS tc_sum
FROM
    orders o 
$wh
GROUP BY
    o.id
EOD;

$t = $this->m_p->qe_r($sql);


$o = array(
    "td" => 0,
    "tp" => 0,
    "tcan" => 0,
    "tship" => 0,
    "expenses" => 0,
    "tt" => 0,
    "ts" => 0,
    "tc" => 0,
    "total" => 0,
    "liv" => 0,
    "ret" => 0,
    "tcanceled" => 0,
    "trecall" => 0,
    "tout" => 0,
    "trt" => 0,
    "trf" => 0,
    "tpending" => 0,
    "all" => $o['all']
);

		$prds = array();

		foreach ($t as $key) {
			if ($key->status == 5) {
				$products = json_decode($key->products, TRUE);
				foreach ($products as $k) {
					if (isset($prds[$k['id']]))
						$prds[$k['id']] += $k['q'];
					else
						$prds[$k['id']] = $k['q'];
				}
			}

			switch ($key->status) {
				case 0:
					$o['tpending']++;
					break;
				case 1:
					$o['trecall']++;
					break;
				case 3:
					$o['tout']++;
					break;
				case 4:
					$o['tcanceled']++;
					break;
			}

			$o['td'] += $key->td;
			$o['tp'] += $key->tp;
			$o['tcan'] += $key->tcan;
			$o['tship'] += $key->tship;
			$o['ts'] += $key->ts;
			$o['trt'] += $key->trt;
			$o['trf'] += $key->trf;
			$o['tc'] += $key->tc;
			$o['total'] += $key->total;
		}



		$o['prods'] = $prds;

		$date = date("Y-m-d");

		$months = array();

		for ($i = 0; $i < 12; $i++) {

			$w3 = [];

			$m = strtotime("-$i month");
			$months[$i]['title'] = date("M", $m);
			$startMonth = strtotime("01-" . date("m-Y", $m));
			$endMonth = strtotime(date("t-m-Y 23:59:59", $m));


			$w3[] = "date < " . $endMonth;
			$w3[] = "date > " . $startMonth;

			$w = $w3;

			$wh = " WHERE " . implode(" AND ", $w);

			$sql = <<<EOD

						SELECT
							o.*,
							COUNT(o.id) AS total,
							COUNT(IF(o.status = 1, 1, null)) AS tp,
							COUNT(IF(o.status = 2, 1, null)) AS tc,
							COUNT(IF(o.status = 3, 1, null)) AS tship,
							COUNT(IF(o.status = 0, 1, null)) AS tcan,
							COUNT(IF(o.status = 6, 1, null)) AS td,
							COUNT(IF(o.status = 7, 1, null)) AS trt,
							COUNT(IF(o.status = 8, 1, null)) AS trf,
							COUNT(IF(o.status = 5, 1, null)) AS ts,
							SUM(IF(o.status = 6, o.totalPrice, 0)) AS t,
							CONCAT(MONTH(FROM_UNIXTIME(o.date)) ,'-', YEAR(FROM_UNIXTIME(o.date))) AS dd,
							MONTH(FROM_UNIXTIME(o.date)) AS m,
							YEAR(FROM_UNIXTIME(o.date)) AS y
						FROM
							orders o
						$wh
EOD;

			$t = $this->m_p->qe_r1($sql);

			$months[$i]['values'] = $t;
		}

		$allValues = array_reverse($months);



		$o["data"] = $allValues;



		// $o['productsPrices'] = count($prds) > 0 ? $this->m_p->get_products_values($prds) : 0;
		$o['productsPrices'] = $this->m_p->get_delivered_orders_total_price();
		$o['deliveredOrdersCount'] = $this->m_p->get_delivered_orders_count();

		// "Top cities" widget (status 2 = confirmed, 5 = delivered, as in the cards above)
		$o['cities'] = $this->m_p->qe_r("SELECT city AS name, COUNT(id) AS total, COUNT(IF(status = 2, 1, null)) AS tc, COUNT(IF(status = 5, 1, null)) AS td FROM orders GROUP BY city ORDER BY total DESC LIMIT 10");

		$this->load->view(admin . "/dashboard", $o);
	}

	function upload()
	{

		$config['upload_path'] 				= './uploads/';
		$config['allowed_types'] 			= 'gif|jpg|png';
		$config['encrypt_name'] 			= TRUE;
		$config['max_size']					= '10240'; // 10 MB
		$this->upload->initialize($config);
		$a = $this->upload->do_upload('file');
		$data_upload = $this->upload->data();

		if ($a) {
			make_image_sizes($data_upload['full_path']);

			echo $data_upload['file_name'];
			exit();
		}

		http_response_code(500);
	}

	public function template_editor($file = FALSE)
	{

		$data = [];

		$theme = setting("theme");

		if (!in_array($theme, available_themes(), TRUE))
			show_error("Unknown theme", 404);

		$data['files'] = array_filter(glob(VIEWPATH . '/front/' . $theme . '/*'), 'is_file');

		// only files that already exist in the active theme can be opened/edited
		if ($file !== FALSE) {
			$names = array_map('basename', $data['files']);
			if (!in_array($file, $names, TRUE))
				show_error("Unknown file", 404);
		}

		if (isset($_POST['content']) && $file !== FALSE) {
			$path = VIEWPATH . 'front/' . $theme . '/' . $file;
			// the web server needs write access to themes/front (see the README)
			if (is_writable($path) && @file_put_contents($path, $_POST['content'], LOCK_EX) !== FALSE)
				$data['saved'] = TRUE;
			else
				$data['write_error'] = TRUE;
		}

		if ($file !== FALSE)
			$data['writable'] = is_writable(VIEWPATH . 'front/' . $theme . '/' . $file);

		if ($file !== FALSE) {
			$data['file'] = $file;
			$data['content'] = file_get_contents(VIEWPATH . '/front/' . $theme . '/' . $file);
		}

		$this->load->library('hb_ai');
		$data['ai_ready'] = $this->hb_ai->is_configured();

		$this->load->view(admin . '/codes', $data);
	}

	function admins()
	{

		$config = $config = page_a($this->m_p->get_num("admins", array()), "admin/admins", 3, $this->config->item("per_page"));

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$data['admins'] = $this->m_p->s_a("admins", array(), $config["per_page"], $page);

		$data["links"] = $this->pagination->create_links();

		//$data['admins'] = $this->m_p->s_a("admins");
		$this->load->view(admin . '/admins', $data);
	}
	function edit_admin($id = false)
	{

		if ($id == false)
			redirect("admin");

		if (isset($_POST['test'])) {
			$arr = array(
				"username" => $this->input->post("username"),
				"email" => $this->input->post("email")
			);
			$password = $this->input->post("password", FALSE);
			if (is_string($password) && $password !== "") {
				$arr['password'] = password_hash($password, PASSWORD_DEFAULT);
			}
			$this->m_p->up_d('admins', $arr, array("id" => $id));
		}
		$data['info'] = $this->m_p->s_a("admins", array("id" => $id), 1, 0);
		$this->load->view(admin . "/edit_admin", $data);
	}
	function add_admin()
	{
		$data = array();
		if (isset($_POST['test'])) {
			$password = $this->input->post("password", FALSE);
			if (is_string($password) && $password !== "") {
				$arr = array(
					"username" => $this->input->post("username"),
					"email" => $this->input->post("email"),
					"password" => password_hash($password, PASSWORD_DEFAULT),
					"device_id" => ""
				);
				$data['msg'] = true;
				$useri = $this->m_p->ins('admins', $arr);
			}
		}
		$this->load->view(admin . "/add_admin", $data);
	}

	/*
	| -------------------------------------------------------------------
	| AI (Claude or OpenAI API key, used by the template editor assistant)
	| -------------------------------------------------------------------
	*/

	/**
	 * Secret address of the login page (settings page). Empty = the login stays
	 * at user/admin_login. The admin keeps its normal links once logged in.
	 */
	public function admin_path()
	{
		// a visited link must not change (or clear) the address
		if ($this->input->method() !== 'post')
			redirect('admin/setting#admin-address');

		$path =strtolower(trim((string) $this->input->post('admin_path'), " /"));

		// URL segments the store already uses, and folders that exist on disk
		$taken = array('admin', 'user', 'home', 'ajax', 'landing', 'close', 'api', 'default_404', 'category', 'collection',
			'cart', 'page', 'shop', 'product', 'l', 'special', 'install', 'themes', 'assets', 'uploads', 'images',
			'application', 'system', 'logo', 'reviews', 'general', 'index.php');

		if ($path !== '' && (!preg_match('/^[a-z0-9][a-z0-9-]{6,62}[a-z0-9]$/', $path) || in_array($path, $taken, TRUE) || file_exists(FCPATH . $path))) {
			$this->session->set_flashdata('admin_path_error', TRUE);
		} else {
			$this->db->replace('hb_meta', array('k' => 'admin_path', 'v' => $path));
			$this->session->set_flashdata('admin_path_saved', TRUE);
		}

		redirect('admin/setting#admin-address');
	}

	/**
	 * "Fill with AI" on the product and landing page forms.
	 * POST form (product|landing), brief, current (JSON of the form values).
	 * Answers the values to put in the form; nothing is saved.
	 */
	public function ai_fill()
	{
		if ($this->input->method() !== 'post')
			show_404();

		@set_time_limit(300);
		$this->load->library('hb_ai');
		if (!$this->hb_ai->is_configured())
			return $this->json(array('ok' => FALSE, 'setup' => TRUE));

		$this->load->library('hb_ai_fill');
		$current = json_decode((string) $this->input->post('current'), TRUE);

		try {
			$r = $this->hb_ai_fill->fill((string) $this->input->post('form'), (string) $this->input->post('brief'), is_array($current) ? $current : array(), (string) $this->input->post('photo'), (string) $this->input->post('feedback'), (int) $this->input->post('images'));
		} catch (InvalidArgumentException | RuntimeException $e) {
			return $this->json(array('ok' => FALSE, 'error' => $e->getMessage()));
		} catch (Throwable $e) {
			log_message('error', 'ai_fill: ' . $e->getMessage() . ' ' . $e->getFile() . ':' . $e->getLine());
			return $this->json(array('ok' => FALSE, 'error' => 'Server error: ' . $e->getMessage()));
		}

		return $this->json(array('ok' => TRUE) + $r);
	}

	/**
	 * Creates one product image for "Fill with AI" and saves it in uploads/.
	 * POST index (style), photo (uploaded file name or ''), looks, title.
	 */
	public function ai_image()
	{
		if ($this->input->method() !== 'post')
			show_404();

		@set_time_limit(300);
		$this->load->library('hb_ai_fill');

		try {
			$file = $this->hb_ai_fill->image((int) $this->input->post('index'), (string) $this->input->post('photo'), (string) $this->input->post('looks'), (string) $this->input->post('title'));
		} catch (InvalidArgumentException | RuntimeException $e) {
			return $this->json(array('ok' => FALSE, 'error' => $e->getMessage()));
		} catch (Throwable $e) {
			log_message('error', 'ai_image: ' . $e->getMessage() . ' ' . $e->getFile() . ':' . $e->getLine());
			return $this->json(array('ok' => FALSE, 'error' => 'Server error: ' . $e->getMessage()));
		}

		return $this->json(array('ok' => TRUE, 'file' => $file));
	}

	public function ai_settings()
	{
		$this->load->library('hb_ai');
		$data['saved'] = FALSE;

		if ($this->input->method() === 'post') {
			$forget = (string) $this->input->post('forget');
			if ($forget !== '')
				$this->hb_ai->forget_key($forget);
			else
				$this->hb_ai->save_settings((string) $this->input->post('provider'), (array) $this->input->post('ai'));
			$data['saved'] = TRUE;
		}

		$data['ai'] = $this->hb_ai->settings();
		$data['providers'] = Hb_ai::PROVIDERS;
		$this->load->view(admin . '/ai_settings', $data);
	}

	public function ai_test()
	{
		$this->load->library('hb_ai');
		try {
			$this->hb_ai->test();
			return $this->json(array('ok' => TRUE));
		} catch (RuntimeException $e) {
			return $this->json(array('ok' => FALSE, 'error' => $e->getMessage()));
		}
	}

	/** One step of the template editor assistant (the browser repeats while 'continue' is TRUE) */
	public function ai_chat()
	{
		@set_time_limit(300);
		$this->load->library('hb_ai');
		if (!$this->hb_ai->is_configured())
			return $this->json(array('ok' => FALSE, 'setup' => TRUE));

		$this->load->library('hb_theme_agent');
		$admin_id = is_login('admin_login');

		$message = mb_substr(trim((string) $this->input->post('message')), 0, 4000);
		$file = basename((string) $this->input->post('file'));
		$chat = $this->hb_theme_agent->load_chat($this->input->post('chat'), $admin_id) ?: $this->hb_theme_agent->new_chat($admin_id, $file);

		try {
			$r = $this->hb_theme_agent->turn($chat, $message, $file);
		} catch (RuntimeException $e) {
			// the chat is not saved, so the same step can simply be tried again
			return $this->json(array('ok' => FALSE, 'chat' => $chat['id'], 'error' => $e->getMessage()));
		}

		$this->hb_theme_agent->save_chat($chat);
		return $this->json(array('ok' => TRUE, 'chat' => $chat['id']) + $r);
	}

	/** This admin's earlier chats on one theme file, newest first */
	public function ai_history()
	{
		$this->load->library('hb_theme_agent');
		return $this->json(array('ok' => TRUE, 'chats' => $this->hb_theme_agent->list_chats(is_login('admin_login'), basename((string) $this->input->post('file')))));
	}

	/** One saved chat: transcript and proposals with their status */
	public function ai_load()
	{
		$this->load->library('hb_theme_agent');
		$chat = $this->hb_theme_agent->load_chat($this->input->post('chat'), is_login('admin_login'));
		return $this->json($chat ? array('ok' => TRUE) + $this->hb_theme_agent->view($chat) : array('ok' => FALSE, 'error' => 'Unknown chat'));
	}

	public function ai_delete()
	{
		$this->load->library('hb_theme_agent');
		return $this->json(array('ok' => $this->hb_theme_agent->delete_chat($this->input->post('chat'), is_login('admin_login'))));
	}

	public function ai_apply()
	{
		return $this->ai_proposal('apply');
	}

	public function ai_undo()
	{
		return $this->ai_proposal('undo');
	}

	private function ai_proposal($action)
	{
		$this->load->library('hb_theme_agent');
		$chat = $this->hb_theme_agent->load_chat($this->input->post('chat'), is_login('admin_login'));
		if (!$chat)
			return $this->json(array('ok' => FALSE, 'error' => 'Unknown chat'));

		$r = $this->hb_theme_agent->$action($chat, (int) $this->input->post('proposal'));
		if ($r['ok'])
			$this->hb_theme_agent->save_chat($chat);

		return $this->json($r);
	}

	private function json(array $data)
	{
		$this->output->set_content_type('application/json')->set_output(json_encode($data, JSON_UNESCAPED_UNICODE));
	}

	/**
	 * Newsletter: switch the store signup form on/off, list and export subscribers.
	 */
	public function newsletter()
	{
		// the table and setting arrive with database version 4 (admin > upgrade)
		$migrator = db_migrator();
		$data['ready'] = $migrator && $migrator->current_version() >= 4;
		$data['saved'] = FALSE;

		if ($data['ready'] && $this->input->method() === "post") {
			$this->m_p->up_d("settings", array("newsletter" => $this->input->post("newsletter") ? 1 : 0));
			$data['saved'] = TRUE;
		}

		$data['enabled'] = $data['ready'] && newsletter_enabled();
		$data['subscribers'] = array();
		$data['total'] = 0;
		$data['links'] = "";

		if ($data['ready']) {
			// the setting was cached by setting() before the update above
			$data['enabled'] = (int) $this->db->select("newsletter")->get("settings")->row()->newsletter === 1;

			$data['total'] = $this->m_p->get_num("newsletter", array());
			$config = page_a($data['total'], "admin/newsletter", 3, 50);
			$this->pagination->initialize($config);
			$page = (int) $this->uri->segment(3);
			$data['subscribers'] = $this->m_p->s_a("newsletter", array(), $config["per_page"], $page);
			$data['links'] = $this->pagination->create_links();
		}

		$this->load->view(admin . "/newsletter", $data);
	}

	public function newsletter_export()
	{
		$migrator = db_migrator();
		if (!$migrator || $migrator->current_version() < 4)
			show_404();

		$rows = $this->m_p->s_a("newsletter", array(), FALSE, 0, array("email", "lang", "date"), "id", "ASC");

		header("Content-Type: text/csv; charset=utf-8");
		header('Content-Disposition: attachment; filename="newsletter-' . date("Y-m-d") . '.csv"');

		$out = fopen("php://output", "w");
		fputcsv($out, array("email", "language", "subscribed_at"), ",", '"', "");
		foreach ($rows as $row)
			fputcsv($out, array($row->email, $row->lang, $row->date), ",", '"', "");
		fclose($out);
	}

	public function delete_subscriber($id = 0)
	{
		check_csrf_get();

		$this->m_p->delete("newsletter", array("id" => (int) $id));

		redirect("admin/newsletter");
	}

	public function themes()
	{

		//$themes = getHtml("https://hobrt.me/themes");

		//$data['themes'] = json_decode($themes, TRUE);

		$data['themes'] = array_filter(glob("themes/front/*"), "is_dir");

		$this->load->view(admin . "/themes", $data);
	}

	public function activate_theme($id = FALSE)
	{
		check_csrf_get();

		if (!in_array($id, available_themes(), TRUE))
			show_error("Unknown theme", 404);

		$this->m_p->up_d("settings", array("theme" => $id));

		redirect("admin/themes");
	}


	public function orders($tp = FALSE)
	{

		if ($tp === FALSE || $tp > 9) {
			$config = $config = page_a($this->m_p->get_num("orders", array()), "admin/requests", 3, $this->config->item("per_page"));

			$this->pagination->initialize($config);

			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

			$perPage = admin == "admin" ? $config["per_page"] : FALSE;

			$data['requests'] = $this->m_p->s_a("orders", array(), $perPage, $page);
		} else {

			$data['tp'] = $tp;

			$config = $config = page_a($this->m_p->get_num("orders", array("status" => $tp)), "admin/requests/$tp", 4, $this->config->item("per_page"));

			$this->pagination->initialize($config);

			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

			$perPage = admin == "admin" ? $config["per_page"] : FALSE;

			$data['requests'] = $this->m_p->s_a("orders", array("status" => $tp), $perPage, $page);
		}

		$data["links"] = $this->pagination->create_links();

		$this->load->view(admin . "/requests", $data);
	}


	public function details($id)
	{
		if (isset($_POST['test'])) {

			$status = get_info('orders', $id, "status");

			$arr = array(
				"status" => (int) $this->input->post("status"),
				"name" => $this->input->post("name"),
				"tele" => $this->input->post("tele"),
				"city" => $this->input->post("city"),
				"coupon" => $this->input->post("coupon"),
				"totalPrice" => $this->input->post("totalPrice"),
				"address" => $this->input->post("address")
			);
			$this->m_p->up_d("orders", $arr, array("id" => $id));

			if ($status != $this->input->post("status")) {
				send_sms($id);
			}
		}

		$data['msg'] = $this->m_p->s_a("orders", array("id" => $id), 1, 0);
		$this->load->view(admin . "/details", $data);
	}

	public function support()
	{
		$data["info"] = getHtml("https://hobrt.me/infoSupport");
	}



	public function slider()
	{
		$data['tp'] = "all";

		$data['sliders'] = $this->m_p->s_a("slider", array(), FALSE, 0, array("*"), "position", "ASC");

		$this->load->view(admin . "/slider", $data);
	}

	public function add_slider()
	{
		$data['tp'] = "add";

		if (isset($_POST['test'])) {
			$_POST['img'] = upload_one_file($file = "img", $width = 1920, $height = 1080, $folder = './images/');
			unset($_POST["test"]);
			$this->m_p->ins('slider', $this->m_p->only_columns('slider', $_POST));
			redirect("admin/slider");
		}

		$this->load->view(admin . "/slider", $data);
	}

	public function edit_slider($id = FALSE)
	{
		$data['tp'] = "edit";
		$slider = $this->m_p->findOneById("slider", $id);
		if (is_null($slider)) {
			return redirect("admin/slider");
		}
		$data['slider'] = $slider;

		if (isset($_POST['test'])) {
			if (!empty($_FILES['img']['name']))
				$_POST['img'] = upload_one_file($file = "img", $width = 1920, $height = 1080, $folder = './images/');

			unset($_POST["test"]);
			$this->m_p->up_d('slider', $this->m_p->only_columns('slider', $_POST), array("id" => $id));
			redirect("admin/slider");
		}

		$this->load->view(admin . "/slider", $data);
	}


	public function sms()
	{
		$data['tp'] = "all";
		$data['cat'] = $this->m_p->s_a("sms", array(), FALSE);
		$this->load->view(admin . '/sms', $data);
	}
	public function add_sms()
	{

		$data = array();
		$data['tp'] = "add";
		if (isset($_POST['test'])) {
			$arr = array_pop($_POST);
			foreach ($_POST as $key => $value) {
				$_POST[$key] = $this->input->post($key);
			}
			$data['msg'] = true;
			$this->m_p->ins('sms', $this->m_p->only_columns('sms', $_POST));
		}
		$this->load->view(admin . "/sms", $data);
	}
	function edit_sms($id)
	{
		$data['cat'] = $this->m_p->s_a("sms", array("id" => $id), 1, 0);
		$data['tp'] = "edit";
		$this->load->view(admin . "/sms", $data);
		if (isset($_POST['test'])) {
			$arr = array_pop($_POST);
			foreach ($_POST as $key => $value) {
				$_POST[$key] = $this->input->post($key);
			}
			$this->m_p->up_d('sms', $this->m_p->only_columns('sms', $_POST), array("id" => $id));
			redirect("admin/sms");
		}
	}

	public function cat()
	{
		$data['tp'] = "all";
		$data['cat'] = $this->m_p->s_a("cats", array(), FALSE, 0, array("*"), "position", "ASC");
		$this->load->view(admin . '/cats', $data);
	}
	public function add_cat()
	{

		$data = array();
		$data['tp'] = "add";
		if (isset($_POST['test'])) {

			if (!empty($_FILES['img']['name']))
				$_POST['img'] = upload_one_file($file = "img", $width = 400, $height = 400, $folder = './images/');
			// generate slug 
			$_POST["slug"] = $this->m_p->generate_slug("cats", $_POST["title"]);

			unset($_POST["test"]);
			$this->m_p->ins('cats', $this->m_p->only_columns('cats', $_POST));
			redirect("admin/cat");
		}
		$this->load->view(admin . "/cats", $data);
	}
	function edit_cat($id)
	{
		$data['cat'] = $this->m_p->s_a("cats", array("id" => $id), 1, 0);
		$data['tp'] = "edit";
		$this->load->view(admin . "/cats", $data);
		if (isset($_POST['test'])) {
			if (!empty($_FILES['img']['name']))
				$_POST['img'] = upload_one_file($file = "img", $width = 400, $height = 400, $folder = './images/');
			unset($_POST['test']);
			$this->m_p->up_d('cats', $this->m_p->only_columns('cats', $_POST), array("id" => $id));
			redirect("admin/cat");
		}
	}


	public function promo()
	{
		$data['tp'] = "all";
		$data['cat'] = $this->m_p->s_a("promo", array(), FALSE, 0, array("*"), "position", "ASC");
		$this->load->view(admin . '/promo', $data);
	}
	public function add_promo()
	{

		$data = array();
		$data['tp'] = "add";
		if (isset($_POST['test'])) {

			$config['upload_path'] 				= './images/';
			$config['allowed_types'] 			= 'gif|jpg|png';
			$config['encrypt_name'] 			= TRUE;
			$config['max_size']					= '10240'; // 10 MB
			$this->upload->initialize($config);
			$a = $this->upload->do_upload('img');
			$data_upload = $this->upload->data();
			$arr = array_pop($_POST);
			if ($a)
				$_POST['img'] = $data_upload['file_name'];

			foreach ($_POST as $key => $value) {
				$_POST[$key] = $this->input->post($key);
			}
			$data['msg'] = true;
			$this->m_p->ins('promo', $this->m_p->only_columns('promo', $_POST));
		}
		$this->load->view(admin . "/promo", $data);
	}
	function edit_promo($id)
	{
		$data['cat'] = $this->m_p->s_a("promo", array("id" => $id), 1, 0);
		$data['tp'] = "edit";
		$this->load->view(admin . "/promo", $data);
		if (isset($_POST['test'])) {
			$config['upload_path'] 				= './images/';
			$config['allowed_types'] 			= 'gif|jpg|png';
			$config['encrypt_name'] 			= TRUE;
			$config['max_size']					= '10240'; // 10 MB
			$this->upload->initialize($config);
			$a = $this->upload->do_upload('img');
			$data_upload = $this->upload->data();
			$arr = array_pop($_POST);
			if ($a)
				$_POST['img'] = $data_upload['file_name'];

			foreach ($_POST as $key => $value) {
				$_POST[$key] = $this->input->post($key);
			}
			$this->m_p->up_d('promo', $this->m_p->only_columns('promo', $_POST), array("id" => $id));
			redirect("admin/promo");
		}
	}

	public function badge()
	{
		$data['tp'] = "all";
		$data['badges'] = $this->m_p->s_a("badges", array(), FALSE, 0, array("*"), "position", "ASC");
		$this->load->view(admin . '/badge', $data);
	}

	public function add_badge()
	{
		$data = array();
		$data['tp'] = "add";
		if (isset($_POST['test'])) {

			if (!empty($_FILES['img']['name']))
				$_POST['img'] = upload_one_file($file = "img", $width = 32, $height = 32, $folder = './images/');
			unset($_POST['test']);
			$this->m_p->ins('badges', $this->m_p->only_columns('badges', $_POST));
			redirect("admin/badge");
		}
		$this->load->view(admin . "/badge", $data);
	}

	function edit_badge($id)
	{
		$data['badge'] = $this->m_p->findOneById("badges", $id);
		if (!$data['badge'])
			return redirect("admin/badge");

		$data['tp'] = "edit";
		if (isset($_POST['test'])) {
			if (!empty($_FILES['img']['name']))
				$_POST['img'] = upload_one_file($file = "img", $width = 70, $height = 70, $folder = './images/');

			unset($_POST['test']);
			$this->m_p->up_d('badges', $this->m_p->only_columns('badges', $_POST), array("id" => $id));
			redirect("admin/badge");
		}
		$this->load->view(admin . "/badge", $data);
	}

	public function order_save()
	{
		$order = $this->input->post("order");
		$table = $this->input->post("table");

		// only the sortable lists of the admin panel
		$sortable = array("slider", "cats", "promo", "badges", "html_codes", "collections", "pages");
		if (!in_array($table, $sortable, TRUE) || !is_array($order))
			show_error("Bad request", 400);

		foreach ($order as $key => $value) {
			$this->m_p->up_d($table, array("position" => (int) $key), array("id" => (int) $value));
		}
	}

	public function html_codes()
	{
		$data['tp'] = "all";
		$data['cat'] = $this->m_p->s_a("html_codes", array(), FALSE, 0, array("*"), "position", "ASC");
		$this->load->view(admin . '/html_codes', $data);
	}

	public function collections()
	{
		$data['tp'] = "all";
		$data['collections'] = $this->m_p->s_a("collections", array(), FALSE, 0, array("*"), "position", "ASC");
		foreach ($data['collections'] as $key => $collection) {
			# get the products title and image to show in each collection
			$data['collections'][$key]->number_of_products = $data['collections'][$key]->products ? sizeof(explode(",", $data['collections'][$key]->products)) : 0;
		}

		$this->load->view(admin . '/collections', $data);
	}

	public function add_collection()
	{

		$data = array();
		$data['tp'] = "add";

		if (isset($_POST['test'])) {
			// saving collection
			if (!empty($_FILES['img']['name']))
				$_POST['image'] = upload_one_file($file = "img", $width = 400, $height = 400, $folder = './images/');

			// generate slug 
			$_POST["slug"] = $this->m_p->generate_slug($table = "collections", $from_string = $_POST["title"]);

			unset($_POST["test"]);
			$this->m_p->ins('collections', $this->m_p->only_columns('collections', $_POST));

			$data['msg'] = true;
			redirect("admin/collections");
		}
		$this->load->view(admin . "/collections", $data);
	}

	function edit_collection($id)
	{
		$collection = $this->m_p->findOneById("collections", $id);
		if (is_null($collection)) {
			# collection not found
			return redirect("admin/collections");
		}

		// get products data
		$collection->products_data = $this->m_p->select_where_in("products", "id,title,images", "id", $where_in = $collection->products);
		$data['collection'] = $collection;

		$data['tp'] = "edit";

		if (isset($_POST['test'])) {
			if (!empty($_FILES['img']['name']))
				$_POST['image'] = upload_one_file($file = "img", $width = 400, $height = 400, $folder = './images/');

			unset($_POST["test"]);
			$this->m_p->up_d('collections', $this->m_p->only_columns('collections', $_POST), array("id" => $id));

			$data['msg'] = true;
			redirect("admin/collections");
		}
		$this->load->view(admin . "/collections", $data);
	}

	# function to retrieve products in add/edit collection using ajax
	public function ajax_search_products()
	{
		$searchQuery = $this->input->post('searchQuery');
		$not_in = $this->input->post('not_in');
		if ($not_in) {
			$not_in = explode(",", $not_in);
		}
		$data['products'] = $this->m_p->searchProducts($searchQuery, $not_in);
		$this->load->view(admin . '/ajax_product_search_results', $data);
	}

	public function add_code()
	{

		$data = array();
		$data['tp'] = "add";
		if (isset($_POST['test'])) {
			$arr = array_pop($_POST);

			$_POST['pages'] = implode(',', $_POST['pages'] ?? []);

			foreach ($_POST as $key => $value) {
				$_POST[$key] = $this->input->post($key);
			}
			$data['msg'] = true;
			$this->m_p->ins('html_codes', $this->m_p->only_columns('html_codes', $_POST));
		}
		$this->load->view(admin . "/html_codes", $data);
	}

	function edit_code($id)
	{
		$data['cat'] = $this->m_p->s_a("html_codes", array("id" => $id), 1, 0);
		$data['tp'] = "edit";
		$this->load->view(admin . "/html_codes", $data);
		if (isset($_POST['test'])) {
			$arr = array_pop($_POST);
			foreach ($_POST as $key => $value) {
				$_POST[$key] = $this->input->post($key);
			}
			$this->m_p->up_d('html_codes', $this->m_p->only_columns('html_codes', $_POST), array("id" => $id));
			redirect("admin/html_codes");
		}
	}

	public function pages()
	{
		$data['tp'] = "all";
		$data['pages'] = $this->m_p->s_a("pages", array(), FALSE, 0, array("*"), "position", "ASC");
		$this->load->view(admin . '/pages', $data);
	}

	public function add_page()
	{
		$data['tp'] = "add";
		if (isset($_POST['test'])) {
			$_POST["slug"] = $this->m_p->generate_slug("pages", $_POST["title"]);
			unset($_POST["test"]);
			unset($_POST["files"]);
			$this->m_p->ins('pages', $this->m_p->only_columns('pages', $_POST));
			return redirect("admin/pages");
		}
		$this->load->view(admin . "/pages", $data);
	}

	function edit_page($id)
	{
		$data['tp'] = "edit";
		$data['page'] = $this->m_p->findOneById("pages", $id);
		if (!$data["page"])
			return redirect("admin/pages");

		if (isset($_POST['test'])) {
			unset($_POST["test"]);
			unset($_POST["files"]);
			$this->m_p->up_d('pages', $this->m_p->only_columns('pages', $_POST), array("id" => $id));
			redirect("admin/pages");
		}
		$this->load->view(admin . "/pages", $data);
	}

	public function landing_pages()
	{
		$data['tp'] = "all";
		$data['landing_pages'] = $this->m_p->s_a("landing_pages", array(), FALSE);
		$this->load->view(admin . '/landing_pages', $data);
	}

	public function add_landing_page()
	{
		$data['tp'] = "add";
		if (isset($_POST['test'])) {
			$_POST["slug"] = $this->m_p->generate_slug("landing_pages", $_POST["title"]);
			unset($_POST["test"]);
			unset($_POST["files"]);

			$_POST['reviews'] = json_encode(landing_reviews_from_post(), JSON_UNESCAPED_UNICODE);
			unset($_POST['image'], $_POST['text'], $_POST['name'], $_POST['city']);
			// empty optional prices are stored as 0 (the columns are numbers)
			foreach (array('price', 'old_price', 'price2', 'price3') as $k)
				$_POST[$k] = (float) str_replace(',', '.', (string) ($_POST[$k] ?? 0));

			$this->m_p->ins('landing_pages', $this->m_p->only_columns('landing_pages', $_POST));
			return redirect("admin/landing_pages");
		}

		$data['products'] = $this->m_p->s_a("products", array(), FALSE);

		$this->load->view(admin . "/landing_pages", $data);
	}

	function edit_landing_page($id)
	{
		$data['tp'] = "edit";
		$data['landing_page'] = $this->m_p->findOneById("landing_pages", $id);
		if (!$data["landing_page"])
			return redirect("admin/landing_pages");

		if (isset($_POST['test'])) {
			unset($_POST["test"]);
			unset($_POST["files"]);

			$_POST['reviews'] = json_encode(landing_reviews_from_post(), JSON_UNESCAPED_UNICODE);
			unset($_POST['image'], $_POST['text'], $_POST['name'], $_POST['city']);
			// empty optional prices are stored as 0 (the columns are numbers)
			foreach (array('price', 'old_price', 'price2', 'price3') as $k)
				$_POST[$k] = (float) str_replace(',', '.', (string) ($_POST[$k] ?? 0));

			$this->m_p->up_d('landing_pages', $this->m_p->only_columns('landing_pages', $_POST), array("id" => $id));
			redirect("admin/landing_pages");
		}

		$data['products'] = $this->m_p->s_a("products", array(), FALSE);
		
		$this->load->view(admin . "/landing_pages", $data);
	}


	public function products()
	{
		$data['tp'] = "all";


		$config = page_a($this->m_p->get_num("products", array()), "admin/products", 3, $this->config->item("per_page"));

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$perPage = admin == "admin" ? $config["per_page"] : FALSE;

		$data['products'] = $this->m_p->s_a("products", array(), $perPage, $page);

		$data["links"] = $this->pagination->create_links();

		$this->load->view(admin . '/products', $data);
	}
	public function add_product()
	{
		$this->load->library("libre");

		$data = array();
		$data['tp'] = "add";

		$data['cats'] = $this->m_p->s_a("cats", array(), FALSE);

		if (isset($_POST['title'])) {

			$_POST['images'] = $this->input->post("images") ?? $this->libre->doupload("file", 'gif|jpg|jpeg|png');

			$info = array();

			$n = $_POST['tp'];

			foreach ($n as $key => $value) {
				if (!empty($value)) {
					$info[$key]['tp'] = $value;
					$info[$key]['info'] = $_POST['info'][$key];
				}
			}

			unset($_POST['tp']);
			unset($_POST['info']);

			$_POST['slug'] = toAscii($_POST['title']);

			foreach ($_POST as $key => $value) {
				$_POST[$key] = $this->input->post($key, FALSE);
			}

			$_POST['variants'] = json_encode($info, JSON_UNESCAPED_UNICODE);

			$data['msg'] = true;
			$this->m_p->ins('products', $this->m_p->only_columns('products', $_POST));
		}
		$this->load->view(admin . "/products", $data);
	}
	function edit_product($id)
	{

		$this->load->library("libre");
		$data['cat'] = $this->m_p->s_a("products", array("id" => $id), 1, 0);
		$data['cats'] = $this->m_p->s_a("cats", array(), FALSE);
		$data['tp'] = "edit";
		$this->load->view(admin . "/products", $data);
		if (isset($_POST['title'])) {

			if (admin == "admin") {

				$imgs = $this->libre->doupload("file", 'gif|jpg|jpeg|png|mp4');
				if (isset($_POST['old_img'])) {
					if (empty($imgs)) {
						$_POST['images'] = implode(",", $_POST['old_img']);
					} else {
						$_POST['images'] = implode(",", $_POST['old_img']) . "," . $imgs;
					}
					unset($_POST['old_img']);
				} else {
					$_POST['images'] = $imgs;
				}
			}

			$info = array();


			$n = $_POST['tp'];

			foreach ($n as $key => $value) {
				if (!empty($value)) {
					$info[$key]['tp'] = $value;
					$info[$key]['info'] = $_POST['info'][$key];
				}
			}

			unset($_POST['tp']);
			unset($_POST['info']);

			$_POST['slug'] = toAscii($_POST['title']);

			foreach ($_POST as $key => $value) {
				$_POST[$key] = $this->input->post($key, FALSE);
			}

			$_POST['variants'] = json_encode($info, JSON_UNESCAPED_UNICODE);

			$this->m_p->up_d('products', $this->m_p->only_columns('products', $_POST), array("id" => $id));
			redirect("admin/products");
		}
	}

	public function reviews(){
		
		if(isset($_POST["accept-review"])){
			$this->m_p->up_d('reviews', ["ac" => 1], array("id" => (int) $this->input->post("review_id")));
			$data['success'] = true;
		}

		$this->load->helper('date');
		$where = array();
		if($this->input->get("product_id")){
			$where["product_id"] = $this->input->get("product_id");
		}
		if($this->input->get("pending")){
			$where["ac"] = 0;
		}
		$data['reviews'] = $this->m_p->s_a("reviews", $where, 10, 0, array("*"), "date", "DESC");

		foreach ($data['reviews'] as $key => $value) {
			$data['reviews'][$key]->product = $this->m_p->findOneById("products",$value->product_id);
		}

		$this->load->view(admin . "/reviews", $data);
	}

	public function discounts()
	{
		$data['tp'] = "all";


		$config = $config = page_a($this->m_p->get_num("discounts", array()), "admin/discounts", 3, $this->config->item("per_page"));

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$data['cat'] = $this->m_p->s_a("discounts", array(), $config["per_page"], $page);

		$data["links"] = $this->pagination->create_links();

		$this->load->view(admin . '/discounts', $data);
	}
	public function add_discount()
	{

		$data = array();
		$data['tp'] = "add";

		$data['cats'] = $this->m_p->s_a("cats", array(), FALSE);

		if (isset($_POST['test'])) {
			$arr = array_pop($_POST);

			foreach ($_POST as $key => $value) {
				$_POST[$key] = $this->input->post($key);
			}
			$data['msg'] = true;
			$this->m_p->ins('discounts', $this->m_p->only_columns('discounts', $_POST));
		}
		$this->load->view(admin . "/discounts", $data);
	}
	function edit_discount($id)
	{
		$data['cat'] = $this->m_p->s_a("discounts", array("id" => $id), 1, 0);
		$data['tp'] = "edit";
		$data['cats'] = $this->m_p->s_a("cats", array(), FALSE);
		$this->load->view(admin . "/discounts", $data);
		if (isset($_POST['test'])) {

			$arr = array_pop($_POST);

			foreach ($_POST as $key => $value) {
				$_POST[$key] = $this->input->post($key);
			}
			$this->m_p->up_d('discounts', $this->m_p->only_columns('discounts', $_POST), array("id" => $id));
			redirect("admin/discounts");
		}
	}

	public function setting()
	{

		if (isset($_POST['test'])) {
			if (!empty($_FILES['logo']['name']))
				$_POST['logo'] = upload_one_file($file = "logo", $width = 200, $height = 80, $folder = './images/');

			unset($_POST['test']);

			// values that end up in file paths (theme folder, language files)
			if (isset($_POST['theme']) && !in_array($_POST['theme'], available_themes(), TRUE))
				unset($_POST['theme']);
			foreach (array('store_lng', 'admin_lng') as $lng) {
				if (isset($_POST[$lng]) && !in_array($_POST[$lng], available_languages(), TRUE))
					unset($_POST[$lng]);
			}

			// the code goes to the price formatter and the ad pixels: 3 letters (MAD)
			if (isset($_POST['currency'])) {
				$_POST['currency'] = strtoupper(trim((string) $_POST['currency']));
				if (!preg_match('/^[A-Z]{3}$/', $_POST['currency']))
					unset($_POST['currency']);
			}
			if (isset($_POST['currency_ar']))
				$_POST['currency_ar'] = mb_substr(trim(strip_tags((string) $_POST['currency_ar'])), 0, 30);

			$this->m_p->up_d('settings', $this->m_p->only_columns('settings', $_POST));
			$data["success"] = True;
		}
		$data['setting'] = $this->m_p->se_a("settings");
		$this->load->view(admin . "/setting", $data);
	}

	/**
	 * Database upgrade after new release files were uploaded (POST runs it).
	 */
	public function upgrade()
	{
		$migrator = db_migrator();
		if (!$migrator)
			show_error("The database upgrade needs the pdo database driver.", 500);

		$data = array("log" => NULL, "error" => NULL);

		if ($this->input->method() === "post") {
			try {
				$data["log"] = $migrator->migrate();
			} catch (Throwable $e) {
				log_message("error", "upgrade: " . $e->getMessage());
				$data["error"] = $e->getMessage();
			}
		}

		$data["current"] = $migrator->current_version();
		$data["latest"] = Hb_migrator::VERSION;

		$this->load->view(admin . "/upgrade", $data);
	}

	public function admin_lang_setting(){
		$previous_url = $_SERVER['HTTP_REFERER'] ?? '';
		$lng = $this->input->post("admin_lng");
		if(in_array($lng, available_languages(), TRUE))
		$this->m_p->up_d('settings', [
			"admin_lng"=> $lng
		]);
		// only go back to a page of this site
		if (!empty($previous_url) && strpos($previous_url, base_url()) === 0) {
			// Redirect back to the previous page
			redirect($previous_url);
		} else {
			// If there is no previous URL, you can redirect to a default page
			// For example, you can redirect to the homepage:
			redirect(base_url("admin"));
		}
	}

	public function delt($table, $id, $red, $tp = false)
	{
		// POST requests are already checked by the CSRF filter, links carry the token
		if ($this->input->method() !== 'post')
			check_csrf_get();

		$deletable = array(
			"admins", "badges", "cats", "collections", "discounts", "google_sheets", "html_codes",
			"landing_pages", "msg", "orders", "pages", "products", "promo", "reviews", "slider", "sms",
			"infos", "vote"
		);
		if (!in_array($table, $deletable, TRUE))
			show_error("Bad request", 400);

		// an admin can not delete the account they are logged in with
		if ($table === "admins" && (int) $id === (int) is_login("admin_login"))
			show_error("You can not delete your own account.", 400);

		$this->m_p->delete($table, array("id" => $id));
		$to = $tp === false ? "admin/" . $red : "admin/" . $red . "/" . $tp;
		if (!$this->input->is_ajax_request()) {
			redirect($to);
		}
		echo "1";
	}




	public function csv($tp = FALSE)
	{

		$filename = "orders.csv";

		$delimiter = ";";

		if ($tp === FALSE)
			$all = $this->m_p->sel("orders");
		else
			$all = $this->m_p->sel("orders", array("status" => $tp));


		$array = array();

		$array[] = array(
			"المنتج",
			"إسم المشتري",
			"رقم الهاتف",
			"المدينة",
			"العنوان",
			"سعر المنتج",
			"تاريخ الطلب",
			"الحالة",
			"رقم التتبع"
		);

		foreach ($all as $key) {

			$prods = "";

			$pcs = json_decode($key->products, TRUE) ?: array();
			foreach ($pcs as $item) {
				$prods .= get_info("products", $item['id'] ?? 0, "title") . " / العدد " . ($item['q'] ?? 1) . "\n";
			}

			switch ($key->status) {
				case 1:
					$stat = "بإنتظار التأكيد";
					break;

				case 2:
					$stat = "بإنتظار الشحن";
					break;

				case 3:
					$stat = "تم الإرسال";
					break;

				case 0:
					$stat = "تم إلغاء الطلب";
					break;

				default:
					$stat = "تم الإستلام";
					break;
			}


			$array[] = array(
				$prods,
				$key->name,
				$key->tele,
				$key->city,
				$key->address,
				$key->totalPrice,
				date("d/m/Y", $key->date),
				$stat,
				""
			);
		}

		// open raw memory as file so no temp files needed, you might run out of memory though
		$f = fopen('php://memory', 'w');
		// loop over the input array
		foreach ($array as $line) {
			// customer data starting with = + - @ would run as a formula in Excel
			foreach ($line as $i => $cell) {
				if (is_string($cell) && preg_match('/^[=+\-@\t\r]/', $cell))
					$line[$i] = "'" . $cell;
			}
			// generate csv lines from the inner arrays
			fputcsv($f, $line, $delimiter, '"', '\\');
		}
		// reset the file pointer to the start of the file
		fseek($f, 0);
		// tell the browser it's going to be a csv file
		header('Content-Type: application/csv');
		// tell the browser we want to save it instead of displaying it
		header('Content-Disposition: attachment; filename="' . $filename . '";');
		// make php send the generated csv lines to the browser
		fpassthru($f);
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

		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}

		if (isset($_POST['id'])) {
			$id = intval($this->input->post("id"));

			$this->m_p->up_d("reviews", array("ac" => 1), array("id" => $id));

			echo "1";
		}
	}

	public function search()
	{

		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}

		if (isset($_POST['q'])) {

			$q = $this->input->post("q");

			$prds = $this->m_p->s_a("products", array("title LIKE " => $q . "%"), 10);

			$all = array();

			if (count($prds) == 0) {
				echo json_encode(array("success" => FALSE));
			} else {

				foreach ($prds as $key) {
					$all[] = $key;
				}

				echo json_encode($all, JSON_UNESCAPED_UNICODE);
			}
		}
	}

	public function addProductToOrder($id)
	{

		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}

		$info = $this->m_p->s_a("orders", array("id" => $id), 1);

		if (count($info) == 0)
			show_404();

		$prods = json_decode($info[0]->products, TRUE) ?: array();
		$product_id = (int) $this->input->post("id");

		foreach ($prods as $key => $value) {
			if ($value['id'] == $product_id)
				unset($prods[$key]);
		}

		$product = $this->m_p->findOneById("products", $product_id);

		if (isset($_POST['qty']) && $product) {

			$arr = array(
				"id" => $product_id,
				"q" => clean_qty($this->input->post("qty")),
				"options" => json_encode(clean_product_options($product, $_POST['option'] ?? []), JSON_UNESCAPED_UNICODE)
			);

			$prods[] = $arr;
		}

		$prods = array_values($prods);

		$p = json_encode($prods, JSON_UNESCAPED_UNICODE);

		$this->m_p->up_d("orders", array("products" => $p), array("id" => $id));

		$info = $this->m_p->s_a("orders", array("id" => $id), 1);

		$this->load->view(admin . "/ajax", ["info" => $info]);
	}

	public function delete_comment()
	{

		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}


		if (isset($_POST['id'])) {
			$id = intval($this->input->post("id"));

			$this->m_p->delete("reviews", array("id" => $id));

			echo "1";
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
		End Ajax Functions
	 ******************************************************/
}
