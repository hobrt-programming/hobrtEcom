<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author hobrt.me
 * @file p_helper.php
 * @package hobrtEcom
 * @link hobrt.me
 * @copyright hobrt.me 2018 => 2022
 *
 **/

use hobrt\Hbsms;

$hbsetting = null;

$hbtablesdata = array();

if (!function_exists('is_login')) {
	function is_login($t = "logged_in")
	{
		$CI = &get_instance();
		$info = $CI->session->userdata($t);
		if (!$info)
			return FALSE;
		else
			return $info['id'];
	}
}



if (!function_exists('load_lang')) {
	function load_lang()
	{
		$CI = &get_instance();
		/*
		$info = $CI->session->userdata("lang");
		if (!$info)
			$lang = "arabic";
		else
			$lang = $info['lang'];
		*/
		$lang = setting("store_lng");
		if (!in_array($lang, available_languages(), TRUE))
			$lang = 'arabic';
		$CI->lang->load('master', $lang);
		$CI->config->set_item('language', $lang);
	}
}


if (!function_exists('load_admin_lang')) {
	function load_admin_lang()
	{
		$CI = &get_instance();
		$lang = setting("admin_lng");
		if (!in_array($lang, available_languages(), TRUE))
			$lang = 'english';
		$CI->lang->load('admin', $lang);
		$CI->config->set_item('language', $lang);
	}
}

function send_to_google_sheet($data)
{

	$CI = &get_instance();

	$gsheet = $CI->m_p->s_a("google_sheets", array(), 1);

	if (count($gsheet) == 0)
		return 0;

	$google_client = new Google_Client();

	foreach ($gsheet as $key) {
		$client_id = $key->client_id;
		$client_secret = $key->client_secret;
		$id = $key->id;
		$sheetId = $key->sheetId;

		$token1 = [
			"access_token" => $key->token,
			"refresh_token" => $key->refresh_token,
			"expires_in" => $key->expire
		];
	}

	$google_client->setClientId($client_id);

	$google_client->setClientSecret($client_secret);

	$google_client->setRedirectUri(base_url("admin/sheet_connect"));

	$google_client->addScope('email');

	$google_client->addScope('profile');

	$google_client->addScope(Google_Service_Sheets::SPREADSHEETS);

	$google_client->setAccessType("offline");

	$google_client->setApprovalPrompt("force");

	$google_client->setAccessToken($token1);

	$googleSheet = new Google_Service_Sheets($google_client);

	$values = array();

	/*$values[] = [
        "Date",
        "Products",
        "Qty",
        "Name",
        "Address",
        "Phone number",
        "City",
        "Price"
    ];*/

	$values[] = $data;

	$range2 = "A2:K";

	$body = new Google_Service_Sheets_ValueRange([
		'values' => $values
	]);


	$params = [
		'valueInputOption' => "RAW"
	];

	$res = $googleSheet->spreadsheets_values->append($sheetId, $range2, $body, $params);
}

if (!function_exists('getHtml')) {
	function getHtml($url, $post = null)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
		curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);
		if (!empty($post)) {
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		}
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
}



if (!function_exists('login')) {
	function login()
	{
		$CI = &get_instance();
		$info = $CI->ion_auth->logged_in();
		if (!$info)
			return FALSE;
		else
			return $CI->ion_auth->user()->row()->id;
	}
}

if (!function_exists('is_admin')) {
	function is_admin()
	{
		return is_login("admin_login");
	}
}


if (!function_exists('currency_label')) {
	/**
	 * The currency as shoppers read it: the Arabic name (settings) on an Arabic
	 * store, the code (MAD, USD...) otherwise or when no Arabic name is set.
	 * $arabic forces the Arabic name, for pages that are always in Arabic.
	 */
	function currency_label($arabic = NULL)
	{
		if ($arabic === NULL)
			$arabic = setting('store_lng') === 'arabic';

		$name = trim((string) setting('currency_ar'));
		// setting() answers "-" before the database upgrade adds the column
		if ($arabic && $name !== '' && $name !== '-')
			return $name;

		return (string) setting('currency');
	}
}

if (!function_exists('format_money')) {
	function format_money($price)
	{

		$currency = setting('currency');

		// Arabic name after the number: 199 درهم, 12.50 درهم
		if (currency_label() !== $currency) {
			$price = (float) $price;
			return number_format($price, floor($price) == $price ? 0 : 2) . ' ' . currency_label();
		}

		// the intl extension is not installed on every host
		if (!function_exists('numfmt_create'))
			return number_format((float) $price, 2) . ' ' . $currency;

		$fmt = numfmt_create('en_US', NumberFormatter::CURRENCY);

		return numfmt_format_currency($fmt, $price, $currency);;
	}
}


if (!function_exists('page_a')) {
    function page_a($total, $url, $uri = 3, $nb = 20)
    {
        $config = array(
            "base_url" => base_url() . $url,
            "total_rows" => $total,
            "per_page" => $nb,
            "uri_segment" => $uri,
            "full_tag_open" => "<ul class='pagination'>",
            "full_tag_close" => "</ul>",
            "num_tag_open" => '<li>',
            "num_tag_close" => '</li>',
            "cur_tag_open" => "<li><a class='active'>",
            "cur_tag_close" => "<span class='sr-only'></span></a></li>",
            "next_tag_open" => "<li>",
            "next_tag_close" => "</li>",
            "prev_tag_open" => "<li>",
            "prev_tag_close" => "</li>",
            "first_tag_open" => "<li>",
            "first_tag_close" => "</li>",
            "last_tag_open" => "<li>",
            "last_tag_close" => "</li>",
            "last_link" => "Last",
            "first_link" => "First",
            "next_link" => "»",
            "prev_link" => "«"
        );
        return $config;
    }
}

if (!function_exists('get_theme_paginate_config')) {
    function get_theme_paginate_config($template, $total, $url, $uri = 3, $nb = 20)
    {
        $config = include("./themes/" . $template . '/paginate.php');
        $config["base_url"] = base_url() . $url;
        $config["total_rows"] = $total;
        $config["per_page"] = $nb;
        $config["uri_segment"] = $uri;
        $config["reuse_query_string"] = TRUE;
        return $config;
    }
}



if (!function_exists('toAscii')) {
	function toAscii($string, $force_lowercase = true, $anal = false)
	{
		$strip = array(
			"~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
			"}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
			"â€”", "â€“", ",", "<", ".", ">", "/", "?"
		);
		$clean = trim(str_replace($strip, "", strip_tags($string)));
		$clean = preg_replace('/\s+/', "-", $clean);
		$clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean;
		return ($force_lowercase) ?
			(function_exists('mb_strtolower')) ?
			mb_strtolower($clean, 'UTF-8') :
			strtolower($clean) :
			$clean;
	}
}

if (!function_exists("short_text")) {
	function short_text($input, $maxWords, $maxChars)
	{
		$words = preg_split('/\s+/', $input);
		$words = array_slice($words, 0, $maxWords);
		$words = array_reverse($words);
		$chars = 0;
		$truncated = array();
		while (count($words) > 0) {
			$fragment = trim(array_pop($words));
			$chars += strlen($fragment);
			if ($chars > $maxChars) break;
			$truncated[] = $fragment;
		}
		$result = implode(' ', $truncated);
		return strip_tags($result . ($input == $result ? ' '  : ' ...'));
	}
}

if (!function_exists('add_thumb')) {
	function add_thumb($va, $t = '_m')
	{
		if (preg_match('/(,)+/', $va)) {
			$r = explode(',', $va);
			$va = $r[0];
		}
		$a = explode('.', $va);
		$a[0] = $a[0] . $t;

		array_pop($a);
		$a[] = "webp";
		$va = implode('.', $a);

		return $va;
	}
}


if (!function_exists('status')) {
	function status($s = "x")
	{
		$status = [
			0 => lang("admin_h10"),
			1 => lang("admin_h6"),
			2 => lang("admin_h7"),
			3 => lang("admin_h8"),
			5 => lang("admin_h9")
		];

		return $status[$s] ?? $status;
	}
}



if (!function_exists('send_sms')) {
	function send_sms($order)
	{
		$CI = &get_instance();

		$info = $CI->m_p->get_info('orders', $order, "*");

		$status = $info['status'];

		$phone = $info['tele'];

		$msg = $CI->m_p->s_a("sms", array("status" => $status), 1);

		if (count($msg) > 0) {

			// token and device are configured per store in admin > settings
			$token = trim((string) setting('hbsms_token'));
			$device = (int) setting('device_id');

			if ($token === '' || $token === '-' || $device <= 0)
				return;

			$sms = new Hbsms($token);

			try {

				$response = $sms->newSms($msg[0]->msg, $phone, $device);
			} catch (Exception $e) {
				log_message('error', 'Hbsms: ' . $e->getMessage());
			}
		}
	}
}

if (!function_exists('pages_codes')) {
	function pages_codes($s = 'x')
	{
		$pages_codes = [
			1 => 'Home',
			2 => 'Product',
			3 => 'Page',
			4 => 'Category',
			5 => 'Thank you page',
			6 => 'Cart',
			7 => 'Landing Page',
		];

		return $pages_codes[$s] ?? $pages_codes;
	}
}

if (!function_exists('get_info')) {
	function get_info($tab, $id, $col)
	{
		global $hbtablesdata;

		$CI = &get_instance();

		if (!isset($hbtablesdata[$tab][$id])) {

			$dd = $CI->m_p->s_a($tab, array("id" => $id), 1);

			foreach ($dd as $key) {
				$hbtablesdata[$tab][$id] = $key;
			}
		}

		return $col != "*" ? $hbtablesdata[$tab][$id]->$col ?? "-" : $hbtablesdata[$tab][$id];
	}
}

if (!function_exists('setting')) {
	function setting($p)
	{
		global $hbsetting;

		$CI = &get_instance();

		if (is_null($hbsetting)) {
			$dd = $CI->m_p->se_a("settings");
			foreach ($dd as $key) {
				$hbsetting = $key;
			}
		}

		return $hbsetting->$p ?? "-";
	}
}

if (!function_exists('all_categories')) {
	function all_categories()
	{
		global $hb_categories;
		$CI = &get_instance();

		if (is_null($hb_categories)) {
			$CI = &get_instance();
			$hb_categories = $CI->m_p->s_a("cats", array(), FALSE, 0, array("*"), "position", "ASC");
		}

		return $hb_categories ?? [];
	}
}

if (!function_exists('header_pages')) {
	function header_pages()
	{
		global $hb_header_pages;
		$CI = &get_instance();

		if (is_null($hb_header_pages)) {
			$CI = &get_instance();
			$hb_header_pages = $CI->m_p->s_a("pages", array("header = " => 1), FALSE, 0, array("id", "title", "slug", "header", "footer"), "position", "ASC");
		}

		return $hb_header_pages ?? [];
	}
}

if (!function_exists('footer_pages')) {
	function footer_pages()
	{
		global $hb_footer_pages;
		$CI = &get_instance();

		if (is_null($hb_footer_pages)) {
			$CI = &get_instance();
			$hb_footer_pages = $CI->m_p->s_a("pages", array("footer = " => 1), FALSE, 0, array("id", "title", "slug", "header", "footer"), "position", "ASC");
		}

		return $hb_footer_pages ?? [];
	}
}

if (!function_exists('all_badges')) {
	function all_badges()
	{
		global $hb_all_badges;
		$CI = &get_instance();

		if (is_null($hb_all_badges)) {
			$CI = &get_instance();
			$hb_all_badges = $CI->m_p->s_a("badges", array(), FALSE, 0, array("*"), "position", "ASC");
		}
		return $hb_all_badges ?? [];
	}
}

if (!function_exists('close_website')) {
	function close_website()
	{
		$CI = &get_instance();
		if (setting("close_website") == 0) {
			redirect("close");
		}
	}
}


if (!function_exists('dd')) {
	function dd(...$args)
	{
		echo '<div style="background-color: #f8f8f8; border: 1px solid #ccc; padding: 10px; margin: 10px;">';
		foreach ($args as $arg) {
			echo '<pre style="background-color: #fff; border: 1px solid #e0e0e0; padding: 10px; margin: 0;">';
			var_dump($arg);
			echo '</pre>';
		}
		echo '</div>';
		die(); // Terminates script execution
	}
}


function ad_perm()
{
	$ar = array(
		1 	=> array("title" => "المنتوجات", "url" => "products"),
		5 	=> array(
			"title" => "الطلبات", "options" => array(
				array("title" => "الكل", "url" => "orders"),
				array("title" => "بإنتظار التأكيد", "url" => "orders/1"),
				array("title" => "بإنتظار الشحن", "url" => "orders/2"),
				array("title" => "تم الإرسال", "url" => "orders/3"),
				array("title" => "تم إلغاء الطلب", "url" => "orders/0"),
				array("title" => "تم الإستلام", "url" => "orders/5")
			)
		),
		10 	=> array("title" => "الخصومات", "url" => "discounts"), //options
		9 	=> array("title" => "الاقسام", "url" => "cat"),
		10 	=> array("title" => "الصفحات", "url" => "pages"),
		12 	=> array("title" => "الدعم", "url" => "support"),
		2 	=> array("title" => "المدراء", "url" => "admins"),
		13 	=> array("title" => "إعدادات الموقع", "url" => "setting"),
	);
	return $ar;
}



/**
 * Date_arabic
 *
 * Returns an Date en arabic.  This is a helper function
 *
 * @access	public
 * @param	int	time in seconds
 * @return	string
 */
if (!function_exists("data_arabic")) {
	function date_arabic($sec)
	{
		$days = array("الأحد", "الاثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة", "السبت");
		$months = array("", "يناير", "فبراير", "مارس", "إبريل", "مايو", "يونيو", "يوليو", "اغسطس", "سبتمبر", "اكتوبر", "نوفمبر", "ديسمبر");
		$date = getdate($sec);
		return $days[$date['wday']] . ' ' . $date['mday'] . ' ' . $months[$date['mon']] . ' ' . $date['year'];
	}
}


function get_gravatar($email, $s = 80, $d = 'mp', $r = 'g', $img = false, $atts = array())
{
	$url = 'https://www.gravatar.com/avatar/';
	$url .= md5(strtolower(trim($email)));
	$url .= "?s=$s&d=$d&r=$r";
	if ($img) {
		$url = '<img src="' . $url . '"';
		foreach ($atts as $key => $val)
			$url .= ' ' . $key . '="' . $val . '"';
		$url .= ' />';
	}
	return $url;
}

/**
 * Uploads a single file and optionally resizes it.
 *
 * @param string $file The name of the file input field in the HTML form.
 * @param int|null $width The desired width for resizing the uploaded image.
 * @param int|null $height The desired height for resizing the uploaded image.
 * @param string $folder The destination folder where the uploaded file will be saved.
 * @return string|null (.webp) $filename The name of the saved image
 */
function upload_one_file($file = "img", $width = NULL, $height = NULL, $folder = './uploads/')
{
	if (!is_dir($folder)) {
		// The folder doesn't exist, so create it
		if (!mkdir($folder, 0755, true)) {
			log_message('error', 'upload_one_file: could not create ' . $folder);
			return null;
		}
	}

	$CI = &get_instance();
	$CI->load->library('upload');
	$CI->load->library('image_l');
	$config['upload_path'] 				= $folder;
	$config['allowed_types'] 			= 'gif|jpg|png';
	$config['encrypt_name'] 			= TRUE;
	$config['max_size']					= '10240'; // 10 MB
	// refuse huge images before GD tries to decode them (memory exhaustion)
	$config['max_width']				= 6000;
	$config['max_height']				= 6000;

	$CI->upload->initialize($config);

	if (!$CI->upload->do_upload($file)) {
		$errors = $CI->upload->display_errors();
		//print_r($errors);
		return null;
	} else {
		$data_upload = $CI->upload->data();
		$tmp = $CI->image_l
			->load($data_upload['full_path']);
		if ($width || $height)
			$tmp->resize($width, $height);
		$tmp->save_pa('', '', TRUE);
		return pathinfo($data_upload['file_name'], PATHINFO_FILENAME) . '.webp';
	}
}

if (!function_exists('csrf_url')) {
	/**
	 * base_url() with the CSRF token appended, for admin links that change data
	 * (delete, activate ...). The controller checks it with check_csrf_get().
	 */
	function csrf_url($path = '')
	{
		$CI = &get_instance();
		$url = base_url($path);
		$sep = strpos($url, '?') === FALSE ? '?' : '&';
		return $url . $sep . $CI->security->get_csrf_token_name() . '=' . $CI->security->get_csrf_hash();
	}
}

if (!function_exists('check_csrf_get')) {
	/**
	 * Stops the request unless it carries the CSRF token in the query string.
	 */
	function check_csrf_get()
	{
		$CI = &get_instance();
		$token = $CI->input->get($CI->security->get_csrf_token_name(), FALSE);
		if (!is_string($token) || !hash_equals($CI->security->get_csrf_hash(), $token)) {
			show_error('The action you have requested is not allowed.', 403);
		}
	}
}

if (!function_exists('rate_limit')) {
	/**
	 * Fixed window rate limiter backed by the file cache (application/cache).
	 * Returns FALSE once $max hits for $key happened in the last $seconds.
	 */
	function rate_limit($key, $max, $seconds)
	{
		$CI = &get_instance();
		$CI->load->driver('cache', array('adapter' => 'file'));

		$id = 'rl_' . sha1($key);
		$now = time();
		$hit = $CI->cache->get($id);

		if (!is_array($hit) || $hit['start'] + $seconds <= $now) {
			$hit = array('start' => $now, 'count' => 0);
		}

		$hit['count']++;
		$CI->cache->save($id, $hit, max(1, $hit['start'] + $seconds - $now));

		return $hit['count'] <= $max;
	}
}

if (!function_exists('rate_limit_or_die')) {
	function rate_limit_or_die($key, $max, $seconds)
	{
		if (!rate_limit($key, $max, $seconds)) {
			show_error('Too many requests, please try again later.', 429);
		}
	}
}

if (!function_exists('clean_qty')) {
	/**
	 * Quantities come from the client (cart cookie, forms): keep 1..999.
	 */
	function clean_qty($q)
	{
		$q = filter_var($q, FILTER_VALIDATE_INT);
		if ($q === FALSE || $q < 1)
			return 1;
		return min($q, 999);
	}
}

if (!function_exists('clean_product_options')) {
	/**
	 * Keeps only the options that exist on the product.
	 * Option keys are bin2hex(base64_encode(variant title)) as rendered by the
	 * product page, values must be one of the variant choices.
	 *
	 * @param object $product row from the products table
	 * @param mixed $options array, or JSON string as stored in the cart cookie
	 * @return array
	 */
	function clean_product_options($product, $options)
	{
		if (is_string($options))
			$options = json_decode($options, TRUE);

		if (!is_array($options) || empty($product->variants))
			return array();

		$variants = json_decode($product->variants, TRUE);
		if (!is_array($variants))
			return array();

		$allowed = array();
		foreach ($variants as $v) {
			if (!isset($v['tp'], $v['info']))
				continue;
			$allowed[bin2hex(base64_encode($v['tp']))] = array_map('trim', explode(',', $v['info']));
		}

		$clean = array();
		foreach ($options as $key => $value) {
			if (is_string($value) && isset($allowed[$key]) && in_array(trim($value), $allowed[$key], TRUE))
				$clean[$key] = trim($value);
		}

		return $clean;
	}
}

if (!function_exists('option_label')) {
	/**
	 * Decodes an option key back to the variant title for display (escaped).
	 */
	function option_label($key)
	{
		$hex = @hex2bin((string) $key);
		$label = $hex === FALSE ? '' : base64_decode($hex, TRUE);
		return html_escape($label === FALSE ? '' : $label);
	}
}

if (!function_exists('db_migrator')) {
	/**
	 * Hb_migrator on the application connection (dbdriver "pdo").
	 */
	function db_migrator()
	{
		$CI = &get_instance();
		require_once APPPATH . 'libraries/Hb_migrator.php';
		return $CI->db->conn_id instanceof PDO ? new Hb_migrator($CI->db->conn_id) : NULL;
	}
}

if (!function_exists('db_upgrade_pending')) {
	/**
	 * TRUE when the database is older than this release (shown in the admin panel).
	 */
	function db_upgrade_pending()
	{
		static $pending = NULL;
		if ($pending === NULL) {
			try {
				$migrator = db_migrator();
				$pending = $migrator ? $migrator->is_pending() : FALSE;
			} catch (Throwable $e) {
				$pending = FALSE;
			}
		}
		return $pending;
	}
}

if (!function_exists('available_languages')) {
	function available_languages()
	{
		return array_map('basename', array_filter(glob(APPPATH . 'language/*'), 'is_dir'));
	}
}

if (!function_exists('available_themes')) {
	function available_themes()
	{
		return array_map('basename', array_filter(glob(VIEWPATH . 'front/*'), 'is_dir'));
	}
}

/**/
/**/
if (!function_exists('store_logo')) {
	/** URL of the uploaded store logo, or the bundled placeholder */
	function store_logo()
	{
		$logo = setting("logo");
		return base_url($logo ? "images/" . $logo : "assets/img/logo.png");
	}
}

if (!function_exists('newsletter_enabled')) {
	/** The newsletter signup forms are switched on in admin > Newsletter */
	function newsletter_enabled()
	{
		return (string) setting("newsletter") === "1";
	}
}

if (!function_exists('status_badge')) {
	/** An order status as a coloured pill for the admin panel */
	function status_badge($s)
	{
		$colors = array(0 => "danger", 1 => "warning", 2 => "info", 3 => "primary", 5 => "success");
		$label = status($s);
		if (is_array($label))
			$label = "?";

		return '<span class="badge badge-pill badge-' . ($colors[$s] ?? "secondary") . ' status-badge">' . html_escape($label) . '</span>';
	}
}

if (!function_exists('admin_path')) {
	/**
	 * Secret address of the admin login page (admin > settings), '' when the
	 * login stays at user/admin_login. With one set, the admin pages are a 404
	 * for anyone not logged in.
	 */
	function admin_path()
	{
		static $path = NULL;
		if ($path === NULL) {
			$CI = &get_instance();
			$row = $CI->db->select('v')->where('k', 'admin_path')->get('hb_meta')->row();
			$path = $row ? (string) $row->v : '';
		}
		return $path;
	}
}

if (!function_exists('admin_login_page')) {
	/**
	 * The admin login form: at user/admin_login, or at the secret admin
	 * address when one is set (Default_404). Signs in and goes to the admin.
	 *
	 * @param bool $check_csrf TRUE at the secret address: CodeIgniter only
	 *                         checks the token on admin/ and user/ URLs (and
	 *                         removes it from $_POST once it has).
	 */
	function admin_login_page($check_csrf = FALSE)
	{
		$CI = &get_instance();
		load_admin_lang();

		$data = array();
		if (isset($_POST['u'])) {
			if ($check_csrf) {
				$token = $CI->input->post($CI->security->get_csrf_token_name());
				if (!is_string($token) || !hash_equals($CI->security->get_csrf_hash(), $token))
					show_error('The action you have requested is not allowed.', 403);
			}

			$login = $CI->m_p->login($CI->input->post("u"), $CI->input->post("p"));

			if (is_object($login)) {
				// new session id on privilege change (session fixation)
				$CI->session->sess_regenerate(TRUE);
				$CI->session->set_userdata('admin_login', array("id" => $login->id));
				redirect('admin');
			}

			$data['msg'] = strpos((string) $login, 'Too many') === 0 ? lang('admin_h304') : lang('admin_h303');
		}

		$CI->load->view('enAdmin/login', $data);
	}
}

if (!function_exists('make_image_sizes')) {
	/**
	 * The smaller copies the themes use next to an uploaded image:
	 * name_s (100x100), name_sv (185x210), name_m (400x400), name_mv (350x590).
	 */
	function make_image_sizes($path)
	{
		$CI = &get_instance();
		$CI->image_l->load($path)->save_pa('', '', TRUE);
		foreach (array('_s' => array(100, 100), '_sv' => array(185, 210), '_m' => array(400, 400), '_mv' => array(350, 590)) as $suffix => $size)
			$CI->image_l->load($path)->resize_crop($size[0], $size[1])->save_pa('', $suffix, FALSE);
	}
}

if (!function_exists('landing_reviews_from_post')) {
	/**
	 * The landing page reviews from the form (image[], name[], city[], text[]).
	 * The photo is optional; a review needs a name or a text.
	 */
	function landing_reviews_from_post()
	{
		$CI = &get_instance();
		$field = function ($k) use ($CI) {
			$v = $CI->input->post($k);
			return is_array($v) ? $v : array();
		};
		$image = $field('image');
		$name = $field('name');
		$city = $field('city');
		$text = $field('text');

		$out = array();
		foreach (array_keys($name + $text + $image) as $i) {
			$r = array(
				'image' => basename(trim((string) ($image[$i] ?? ''))),
				'name' => trim((string) ($name[$i] ?? '')),
				'text' => trim((string) ($text[$i] ?? '')),
				'city' => trim((string) ($city[$i] ?? '')),
			);
			if ($r['name'] !== '' || $r['text'] !== '')
				$out[] = $r;
		}
		return $out;
	}
}
