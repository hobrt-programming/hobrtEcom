<?php
/**
 * @author hobrt.me
 * @file install.php
 * @package hobrtEcom
 * @link hobrt.me
 *
 * Web installer and upgrader.
 *
 *  - New store: checks the server, creates the database tables, the admin
 *    account and application/config/local.php (database + base URL).
 *  - Upgrade: brings a 2019 (v1) or 2023 (v2) store database up to date.
 *    Old admin passwords keep working (they are re-hashed on first login).
 *
 * Once local.php exists the store is "installed": this page can then only run
 * pending upgrades on the configured database, after an admin login.
 **/

define('HB_ROOT', dirname(__DIR__));
define('BASEPATH', HB_ROOT . '/system/');           // lets us include application files
define('APPPATH', HB_ROOT . '/application/');
define('HB_LOCAL', APPPATH . 'config/local.php');
define('HB_SECRETS', APPPATH . 'config/secrets.php');
define('HB_MIN_PHP', '8.1.0');

require APPPATH . 'libraries/Hb_migrator.php';

ini_set('display_errors', '0');
error_reporting(E_ALL);
header('X-Frame-Options: DENY');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: same-origin');

session_name('hb_installer');
session_set_cookie_params(array(
	'lifetime' => 0,
	'path' => dirname($_SERVER['SCRIPT_NAME']),
	'secure' => is_https(),
	'httponly' => TRUE,
	'samesite' => 'Strict',
));
session_start();

if (empty($_SESSION['csrf']))
	$_SESSION['csrf'] = bin2hex(random_bytes(32));

if (isset($_GET['lang']) && in_array($_GET['lang'], array('ar', 'en'), TRUE))
	$_SESSION['lang'] = $_GET['lang'];
$lang = $_SESSION['lang'] ?? 'ar';

/*
| -------------------------------------------------------------------
| Texts
| -------------------------------------------------------------------
*/
$T = array(
	'ar' => array(
		'title' => 'تثبيت hobrtEcom',
		'requirements' => 'متطلبات الخادم',
		'ok' => 'متوفر',
		'missing' => 'غير متوفر',
		'writable' => 'قابل للكتابة',
		'not_writable' => 'غير قابل للكتابة',
		'fix_first' => 'الرجاء إصلاح العناصر الحمراء ثم إعادة تحميل الصفحة.',
		'vendor_help' => 'شغّل الأمر composer install داخل مجلد application',
		'new_store' => 'متجر جديد',
		'upgrade_store' => 'ترقية متجر موجود',
		'upgrade_help' => 'لمتجر مثبت بنسخة قديمة (2019 أو 2023). استعمل نفس قاعدة البيانات القديمة.',
		'database' => 'قاعدة البيانات',
		'db_host' => 'هوست القاعدة',
		'db_port' => 'المنفذ',
		'db_name' => 'إسم القاعدة',
		'db_user' => 'إسم المستخدم',
		'db_pass' => 'كلمة السر',
		'store' => 'المتجر',
		'base_url' => 'رابط المتجر',
		'store_title' => 'عنوان المتجر',
		'store_lang' => 'لغة المتجر',
		'admin' => 'حساب المدير',
		'admin_user' => 'إسم المستخدم',
		'admin_email' => 'البريد الإلكتروني',
		'admin_pass' => 'كلمة السر (8 أحرف على الأقل)',
		'old_admin' => 'حساب مدير المتجر الحالي',
		'old_admin_help' => 'للتأكد من أنها قاعدة بيانات متجرك.',
		'backup' => 'لدي نسخة احتياطية من قاعدة البيانات',
		'install_btn' => 'تثبيت المتجر',
		'upgrade_btn' => 'ترقية المتجر',
		'installed' => 'المتجر مثبت',
		'up_to_date' => 'قاعدة البيانات محدثة.',
		'pending' => 'تحديث قاعدة البيانات مطلوب (النسخة %d ← %d).',
		'login_to_upgrade' => 'سجل الدخول بحساب مدير لتشغيل التحديث.',
		'done_install' => 'تم تثبيت المتجر بنجاح.',
		'done_upgrade' => 'تمت ترقية المتجر بنجاح.',
		'delete_install' => 'لأمان أكثر احذف مجلد install من الخادم.',
		'go_store' => 'المتجر',
		'go_admin' => 'لوحة التحكم',
		'details' => 'التفاصيل',
		'err_csrf' => 'انتهت صلاحية الصفحة، أعد المحاولة.',
		'err_fields' => 'الرجاء ملء كل الحقول بشكل صحيح.',
		'err_connect' => 'تعذر الاتصال بقاعدة البيانات، تأكد من المعلومات.',
		'empty_db' => 'سيتم استعمال قاعدة البيانات "%s" المحددة في application/config/local.php، وهي لا تحتوي على متجر بعد.',
		'err_has_store' => 'قاعدة البيانات تحتوي على متجر. استعمل "ترقية متجر موجود" أو قاعدة بيانات فارغة.',
		'err_no_store' => 'لم يتم العثور على متجر في قاعدة البيانات هذه.',
		'err_admin' => 'إسم المستخدم أو كلمة السر غير صحيحة.',
		'err_backup' => 'خذ نسخة احتياطية أولاً ثم أكد ذلك.',
		'err_write' => 'تعذر كتابة الملف %s، تأكد من صلاحيات المجلد application/config.',
		'err_failed' => 'حدث خطأ أثناء العملية:',
		'err_throttle' => 'محاولات كثيرة، الرجاء الانتظار 15 دقيقة.',
	),
	'en' => array(
		'title' => 'hobrtEcom installer',
		'requirements' => 'Server requirements',
		'ok' => 'OK',
		'missing' => 'Missing',
		'writable' => 'Writable',
		'not_writable' => 'Not writable',
		'fix_first' => 'Fix the red items, then reload this page.',
		'vendor_help' => 'run composer install inside the application folder',
		'new_store' => 'New store',
		'upgrade_store' => 'Upgrade an existing store',
		'upgrade_help' => 'For a store installed with an older release (2019 or 2023). Use the same database.',
		'database' => 'Database',
		'db_host' => 'Host',
		'db_port' => 'Port',
		'db_name' => 'Database name',
		'db_user' => 'User',
		'db_pass' => 'Password',
		'store' => 'Store',
		'base_url' => 'Store URL',
		'store_title' => 'Store title',
		'store_lang' => 'Store language',
		'admin' => 'Admin account',
		'admin_user' => 'Username',
		'admin_email' => 'Email',
		'admin_pass' => 'Password (8 characters minimum)',
		'old_admin' => 'Current store admin account',
		'old_admin_help' => 'Used to make sure this is your store database.',
		'backup' => 'I have a backup of the database',
		'install_btn' => 'Install the store',
		'upgrade_btn' => 'Upgrade the store',
		'installed' => 'The store is installed',
		'up_to_date' => 'The database is up to date.',
		'pending' => 'A database update is required (version %d → %d).',
		'login_to_upgrade' => 'Log in with an admin account to run it.',
		'done_install' => 'The store was installed.',
		'done_upgrade' => 'The store was upgraded.',
		'delete_install' => 'For extra safety, delete the install folder from the server.',
		'go_store' => 'Store',
		'go_admin' => 'Admin panel',
		'details' => 'Details',
		'err_csrf' => 'This page expired, please try again.',
		'err_fields' => 'Please fill every field correctly.',
		'err_connect' => 'Could not connect to the database, check the details.',
		'empty_db' => 'Using the database "%s" from application/config/local.php. It has no store yet.',
		'err_has_store' => 'This database already contains a store. Use "Upgrade an existing store" or an empty database.',
		'err_no_store' => 'No store was found in this database.',
		'err_admin' => 'Wrong username or password.',
		'err_backup' => 'Take a backup first, then confirm it.',
		'err_write' => 'Could not write %s, check the permissions of application/config.',
		'err_failed' => 'The operation failed:',
		'err_throttle' => 'Too many attempts, please wait 15 minutes.',
	),
);

function t($key) { global $T, $lang; return $T[$lang][$key] ?? $key; }
function h($s) { return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8'); }
function post($k, $default = '') { return isset($_POST[$k]) && is_string($_POST[$k]) ? trim($_POST[$k]) : $default; }

function is_https()
{
	return (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off')
		|| (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
}

/*
| -------------------------------------------------------------------
| Helpers
| -------------------------------------------------------------------
*/
function local_config()
{
	return is_file(HB_LOCAL) ? (include HB_LOCAL) : array();
}

function is_installed()
{
	$local = local_config();
	return !empty($local['installed']) && configured_empty_db() === NULL;
}

/**
 * Database settings from local.php when that database is reachable but has no
 * store yet (config written, tables never created): installing is allowed
 * again, but only into this database. NULL otherwise.
 */
function configured_empty_db()
{
	static $db = FALSE;
	if ($db !== FALSE)
		return $db;

	$db = NULL;
	$local = local_config();
	if (!empty($local['installed']) && !empty($local['db'])) {
		try {
			if (!(new Hb_migrator(connect($local['db'])))->has_store())
				$db = $local['db'];
		} catch (Throwable $e) {
			// unreachable: keep treating the store as installed
		}
	}
	return $db;
}

function guess_base_url()
{
	$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
	if (!preg_match('/^[A-Za-z0-9.\-]+(:\d+)?$/', $host))
		$host = 'localhost';
	$path = rtrim(str_replace('\\', '/', dirname(dirname($_SERVER['SCRIPT_NAME']))), '/');
	return (is_https() ? 'https' : 'http') . '://' . $host . $path . '/';
}

function clean_base_url($url)
{
	$url = trim($url);
	if (!filter_var($url, FILTER_VALIDATE_URL) || !preg_match('#^https?://#i', $url) || preg_match('/[\'"<>\s\\\\]/', $url))
		return FALSE;
	return rtrim($url, '/') . '/';
}

/** Validated database settings from the form, or FALSE */
function db_from_post()
{
	$db = array(
		'hostname' => post('db_host', 'localhost'),
		'port' => post('db_port', '3306'),
		'database' => post('db_name'),
		'username' => post('db_user'),
		'password' => isset($_POST['db_pass']) && is_string($_POST['db_pass']) ? $_POST['db_pass'] : '',
	);

	// host and name go into the DSN string: no ";" or "=" allowed
	if (!preg_match('/^[A-Za-z0-9.\-_]{1,255}$/', $db['hostname'])
		|| !ctype_digit($db['port']) || (int) $db['port'] < 1 || (int) $db['port'] > 65535
		|| !preg_match('/^[A-Za-z0-9_$\-]{1,64}$/', $db['database'])
		|| $db['username'] === '' || strlen($db['username']) > 80)
		return FALSE;

	$db['port'] = (int) $db['port'];
	return $db;
}

function connect(array $db)
{
	$dsn = 'mysql:host=' . $db['hostname'] . ';port=' . $db['port'] . ';dbname=' . $db['database'] . ';charset=utf8mb4';
	return new PDO($dsn, $db['username'], $db['password'], array(
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_TIMEOUT => 10,
	));
}

/** Writes a PHP config file that returns $data, atomically */
function write_config($file, array $data, $comment)
{
	$php = "<?php defined('BASEPATH') OR exit('No direct script access allowed');\n"
		. "// $comment\n"
		. 'return ' . var_export($data, TRUE) . ";\n";
	$tmp = $file . '.' . bin2hex(random_bytes(4)) . '.tmp';
	if (@file_put_contents($tmp, $php, LOCK_EX) === FALSE || !@rename($tmp, $file)) {
		@unlink($tmp);
		throw new RuntimeException(sprintf(t('err_write'), 'application/config/' . basename($file)));
	}
	@chmod($file, 0640);
}

function save_store_config(array $db, $base_url)
{
	write_config(HB_LOCAL, array(
		'installed' => TRUE,
		'installed_at' => date('c'),
		'base_url' => $base_url,
		'db' => $db,
	), 'Written by install/install.php. Keep it private, it holds the database password.');

	if (!is_file(HB_SECRETS)) {
		write_config(HB_SECRETS, array(
			'encryption_key' => bin2hex(random_bytes(32)),
			'jwt_secret' => bin2hex(random_bytes(32)),
		), 'Per-install secrets.');
	}
}

/** 5 failed admin logins per IP per 15 minutes (file next to the sessions) */
function throttle($hit = FALSE)
{
	$file = APPPATH . 'cache/hb_installer_attempts.json';
	$ip = $_SERVER['REMOTE_ADDR'] ?? 'cli';
	$data = is_file($file) ? (json_decode((string) @file_get_contents($file), TRUE) ?: array()) : array();
	$now = time();
	$data = array_filter($data, function ($a) use ($now) { return $a['t'] > $now - 900; });
	$count = count(array_filter($data, function ($a) use ($ip) { return $a['ip'] === $ip; }));

	if ($hit) {
		$data[] = array('ip' => $ip, 't' => $now);
		@file_put_contents($file, json_encode(array_values($data)), LOCK_EX);
	}
	return $count < 5;
}

function requirements()
{
	$checks = array();
	$checks[] = array('PHP >= ' . HB_MIN_PHP . ' (' . PHP_VERSION . ')', version_compare(PHP_VERSION, HB_MIN_PHP, '>='), '');
	foreach (array('pdo_mysql', 'gd', 'intl', 'curl', 'mbstring', 'json') as $ext)
		$checks[] = array("PHP extension: $ext", extension_loaded($ext), '');

	$checks[] = array('Composer packages (application/vendor)', is_file(APPPATH . 'vendor/autoload.php') && is_dir(APPPATH . 'vendor/google/apiclient'), t('vendor_help'));

	if (!is_dir(HB_ROOT . '/images'))
		@mkdir(HB_ROOT . '/images', 0755, TRUE);

	foreach (array('application/config', 'application/cache', 'application/logs', 'uploads', 'images') as $dir)
		$checks[] = array($dir, is_dir(HB_ROOT . '/' . $dir) && is_writable(HB_ROOT . '/' . $dir), '', TRUE);

	return $checks;
}

/*
| -------------------------------------------------------------------
| Actions
| -------------------------------------------------------------------
*/
$error = NULL;
$result = NULL;     // array('message' => .., 'log' => [..])
$installed = is_installed();
$pending = NULL;    // array(current, latest) when installed

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$action = post('action');

	if (!hash_equals($_SESSION['csrf'], post('csrf'))) {
		$error = t('err_csrf');
	} elseif ($installed) {
		// installed store: only pending upgrades on the configured database
		if ($action === 'upgrade_installed') {
			if (!throttle()) {
				$error = t('err_throttle');
			} else {
				try {
					$local = local_config();
					$migrator = new Hb_migrator(connect($local['db']));
					if (!$migrator->verify_admin(post('admin_user'), $_POST['admin_pass'] ?? '')) {
						throttle(TRUE);
						$error = t('err_admin');
					} else {
						$result = array('message' => t('done_upgrade'), 'log' => $migrator->migrate());
					}
				} catch (Throwable $e) {
					$error = t('err_failed') . ' ' . $e->getMessage();
				}
			}
		}
	} else {
		$db = configured_empty_db() ?: db_from_post();
		$base_url = clean_base_url(post('base_url'));

		if ($db === FALSE || $base_url === FALSE) {
			$error = t('err_fields');
		} else {
			try {
				$pdo = connect($db);
			} catch (Throwable $e) {
				$pdo = NULL;
				$error = t('err_connect');
			}

			if ($pdo && $action === 'install') {
				$store = array(
					'title' => post('store_title'),
					'store_lng' => post('store_lng') === 'english' ? 'english' : 'arabic',
				);
				$admin = array(
					'username' => post('admin_user'),
					'email' => post('admin_email'),
					'password' => isset($_POST['admin_pass']) && is_string($_POST['admin_pass']) ? $_POST['admin_pass'] : '',
				);

				if ($store['title'] === '' || !preg_match('/^[\p{L}\p{N}_.\-]{3,50}$/u', $admin['username'])
					|| !filter_var($admin['email'], FILTER_VALIDATE_EMAIL) || strlen($admin['password']) < 8) {
					$error = t('err_fields');
				} else {
					try {
						$migrator = new Hb_migrator($pdo);
						if ($migrator->has_store()) {
							$error = t('err_has_store');
						} else {
							$migrator->install($store, $admin);
							save_store_config($db, $base_url);
							$result = array('message' => t('done_install'), 'log' => $migrator->log());
						}
					} catch (Throwable $e) {
						$error = t('err_failed') . ' ' . $e->getMessage();
					}
				}
			} elseif ($pdo && $action === 'upgrade') {
				if (empty($_POST['backup'])) {
					$error = t('err_backup');
				} elseif (!throttle()) {
					$error = t('err_throttle');
				} else {
					try {
						$migrator = new Hb_migrator($pdo);
						if (!$migrator->has_store()) {
							$error = t('err_no_store');
						} elseif (!$migrator->verify_admin(post('admin_user'), $_POST['admin_pass'] ?? '')) {
							throttle(TRUE);
							$error = t('err_admin');
						} else {
							$log = $migrator->migrate();
							save_store_config($db, $base_url);
							$result = array('message' => t('done_upgrade'), 'log' => $log);
						}
					} catch (Throwable $e) {
						$error = t('err_failed') . ' ' . $e->getMessage();
					}
				}
			}
		}
	}

	// one token per form display
	$_SESSION['csrf'] = bin2hex(random_bytes(32));
	$installed = is_installed();
}

if ($installed && !$result) {
	try {
		$local = local_config();
		$m = new Hb_migrator(connect($local['db']));
		$pending = array($m->current_version(), Hb_migrator::VERSION);
	} catch (Throwable $e) {
		$error = $error ?: t('err_connect');
	}
}

$checks = $installed ? array() : requirements();
$ready = !in_array(FALSE, array_column($checks, 1), TRUE);
$local = local_config();
$store_url = $local['base_url'] ?? guess_base_url();
$csrf = $_SESSION['csrf'];
$rtl = $lang === 'ar';
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $rtl ? 'rtl' : 'ltr' ?>">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex">
	<title><?= h(t('title')) ?></title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<?php if ($rtl): ?><link href="css/bt.rtl.css" rel="stylesheet"><?php endif; ?>
	<style>
		body { background: #f5f5f5; padding: 30px 0; }
		.box { max-width: 680px; margin: 0 auto 20px; background: #fff; border: 1px solid #e5e5e5; border-radius: 6px; padding: 20px 28px; }
		h3 { margin-top: 0; }
		.check { display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #f0f0f0; }
		.check small { display: block; color: #888; }
		legend { font-size: 16px; font-weight: bold; margin-top: 10px; }
		.log { font-family: monospace; font-size: 12px; max-height: 240px; overflow: auto; background: #fafafa; padding: 8px; }
		.lang { text-align: center; margin-bottom: 10px; }
	</style>
</head>
<body>
<div class="lang"><a href="?lang=ar">العربية</a> · <a href="?lang=en">English</a></div>
<div class="box">
	<h3><?= h(t('title')) ?></h3>

	<?php if ($error): ?><div class="alert alert-danger"><?= h($error) ?></div><?php endif; ?>

	<?php if ($result): ?>
		<div class="alert alert-success"><?= h($result['message']) ?></div>
		<p><?= h(t('delete_install')) ?></p>
		<p>
			<a class="btn btn-default" href="<?= h($store_url) ?>"><?= h(t('go_store')) ?></a>
			<a class="btn btn-primary" href="<?= h($store_url) ?>admin"><?= h(t('go_admin')) ?></a>
		</p>
		<details><summary><?= h(t('details')) ?></summary>
			<div class="log"><?php foreach ($result['log'] as $line) echo h($line), '<br>'; ?></div>
		</details>

	<?php elseif ($installed): ?>
		<div class="alert alert-info"><?= h(t('installed')) ?></div>
		<?php if ($pending && $pending[0] < $pending[1]): ?>
			<p><?= h(sprintf(t('pending'), $pending[0], $pending[1])) ?> <?= h(t('login_to_upgrade')) ?></p>
			<form method="post">
				<input type="hidden" name="csrf" value="<?= h($csrf) ?>">
				<input type="hidden" name="action" value="upgrade_installed">
				<div class="form-group"><label><?= h(t('admin_user')) ?></label><input class="form-control" name="admin_user" required autocomplete="username"></div>
				<div class="form-group"><label><?= h(t('db_pass')) ?></label><input class="form-control" type="password" name="admin_pass" required autocomplete="current-password"></div>
				<button class="btn btn-success"><?= h(t('upgrade_btn')) ?></button>
			</form>
		<?php elseif ($pending): ?>
			<p><?= h(t('up_to_date')) ?></p>
			<p><?= h(t('delete_install')) ?></p>
			<a class="btn btn-primary" href="<?= h($store_url) ?>admin"><?= h(t('go_admin')) ?></a>
		<?php endif; ?>

	<?php else: ?>
		<legend><?= h(t('requirements')) ?></legend>
		<?php foreach ($checks as $c): ?>
			<div class="check">
				<span><?= h($c[0]) ?><?php if (!$c[1] && $c[2]): ?><small><?= h($c[2]) ?></small><?php endif; ?></span>
				<span class="label label-<?= $c[1] ? 'success' : 'danger' ?>"><?= h(!empty($c[3]) ? t($c[1] ? 'writable' : 'not_writable') : t($c[1] ? 'ok' : 'missing')) ?></span>
			</div>
		<?php endforeach; ?>

		<?php if (!$ready): ?>
			<div class="alert alert-warning" style="margin-top:15px"><?= h(t('fix_first')) ?></div>
		<?php else:
			$mode = post('action') === 'upgrade' ? 'upgrade' : 'install';
		?>
			<ul class="nav nav-tabs" style="margin-top:20px">
				<li class="<?= $mode === 'install' ? 'active' : '' ?>"><a href="#" onclick="return tab('install')"><?= h(t('new_store')) ?></a></li>
				<li class="<?= $mode === 'upgrade' ? 'active' : '' ?>"><a href="#" onclick="return tab('upgrade')"><?= h(t('upgrade_store')) ?></a></li>
			</ul>

			<form method="post" id="form" style="margin-top:15px">
				<input type="hidden" name="csrf" value="<?= h($csrf) ?>">
				<input type="hidden" name="action" id="action" value="<?= h($mode) ?>">

				<p class="text-muted only-upgrade"><?= h(t('upgrade_help')) ?></p>

				<legend><?= h(t('database')) ?></legend>
				<?php if ($empty_db = configured_empty_db()): ?>
				<p class="text-muted"><?= h(sprintf(t('empty_db'), $empty_db['database'])) ?></p>
				<?php else: ?>
				<div class="row">
					<div class="col-sm-8 form-group"><label><?= h(t('db_host')) ?></label><input class="form-control" name="db_host" value="<?= h(post('db_host', 'localhost')) ?>" required></div>
					<div class="col-sm-4 form-group"><label><?= h(t('db_port')) ?></label><input class="form-control" name="db_port" value="<?= h(post('db_port', '3306')) ?>" required></div>
				</div>
				<div class="form-group"><label><?= h(t('db_name')) ?></label><input class="form-control" name="db_name" value="<?= h(post('db_name')) ?>" required></div>
				<div class="row">
					<div class="col-sm-6 form-group"><label><?= h(t('db_user')) ?></label><input class="form-control" name="db_user" value="<?= h(post('db_user')) ?>" required autocomplete="off"></div>
					<div class="col-sm-6 form-group"><label><?= h(t('db_pass')) ?></label><input class="form-control" type="password" name="db_pass" autocomplete="off"></div>
				</div>
				<?php endif; ?>

				<legend><?= h(t('store')) ?></legend>
				<div class="form-group"><label><?= h(t('base_url')) ?></label><input class="form-control" name="base_url" dir="ltr" value="<?= h(post('base_url', guess_base_url())) ?>" required></div>
				<div class="only-install">
					<div class="form-group"><label><?= h(t('store_title')) ?></label><input class="form-control" name="store_title" value="<?= h(post('store_title')) ?>"></div>
					<div class="form-group"><label><?= h(t('store_lang')) ?></label>
						<select class="form-control" name="store_lng">
							<option value="arabic">العربية</option>
							<option value="english" <?= post('store_lng') === 'english' ? 'selected' : '' ?>>English</option>
						</select>
					</div>
				</div>

				<legend class="only-install"><?= h(t('admin')) ?></legend>
				<legend class="only-upgrade"><?= h(t('old_admin')) ?></legend>
				<p class="text-muted only-upgrade"><?= h(t('old_admin_help')) ?></p>
				<div class="row">
					<div class="col-sm-6 form-group"><label><?= h(t('admin_user')) ?></label><input class="form-control" name="admin_user" value="<?= h(post('admin_user')) ?>" autocomplete="username"></div>
					<div class="col-sm-6 form-group only-install"><label><?= h(t('admin_email')) ?></label><input class="form-control" type="email" name="admin_email" value="<?= h(post('admin_email')) ?>"></div>
				</div>
				<div class="form-group"><label class="only-install"><?= h(t('admin_pass')) ?></label><label class="only-upgrade"><?= h(t('db_pass')) ?></label><input class="form-control" type="password" name="admin_pass" autocomplete="new-password"></div>

				<div class="checkbox only-upgrade"><label><input type="checkbox" name="backup" value="1"> <?= h(t('backup')) ?></label></div>

				<button class="btn btn-success only-install"><?= h(t('install_btn')) ?></button>
				<button class="btn btn-warning only-upgrade"><?= h(t('upgrade_btn')) ?></button>
			</form>

			<script>
			function tab(mode) {
				document.getElementById('action').value = mode;
				document.querySelectorAll('.nav-tabs li').forEach(function (li, i) { li.className = (i === 0) === (mode === 'install') ? 'active' : ''; });
				document.querySelectorAll('.only-install').forEach(function (el) { el.style.display = mode === 'install' ? '' : 'none'; });
				document.querySelectorAll('.only-upgrade').forEach(function (el) { el.style.display = mode === 'upgrade' ? '' : 'none'; });
				return false;
			}
			tab(<?= json_encode($mode) ?>);
			</script>
		<?php endif; ?>
	<?php endif; ?>
</div>
<div style="text-align:center">hobrtEcom <?= h(Hb_migrator::VERSION) ?> · <a href="https://hobrt.me">hobrt</a></div>
</body>
</html>
