<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author hobrt.me
 * @file Hb_migrator.php
 * @package hobrtEcom
 * @link hobrt.me
 *
 * Database schema for hobrtEcom: fresh installs and upgrades.
 *
 * Every step is idempotent: running migrate() again (for example after a
 * failure halfway) only does what is still missing. It is used by the web
 * installer (install/install.php, no CodeIgniter) and by admin/upgrade.
 *
 * Known database generations it upgrades from:
 *   1 - 2019 release (install/sql.sql): sha1 passwords, orders products as {"id": qty},
 *       reviews.vote / reviews.product, int dates, no slugs
 *   2 - 2023 release: no landing_pages table, few column defaults
 *   3 - first recorded version (hb_meta)
 *   4 - newsletter subscribers table, settings.newsletter
 *   5 - ai_chats (template editor assistant history)
 *   6 - settings.currency_ar (currency name shown on Arabic store pages)
 **/
class Hb_migrator
{
	const VERSION = 6;

	/** @var PDO */
	private $db;

	private $log = array();

	public function __construct(PDO $db)
	{
		$this->db = $db;
	}

	/*
	| -------------------------------------------------------------------
	| Target schema
	| -------------------------------------------------------------------
	| Text columns stay NULL-able unless the code relies on a string, other
	| NOT NULL columns get a default so inserts never depend on the SQL mode.
	*/
	public static function schema()
	{
		$id = "int(11) NOT NULL AUTO_INCREMENT";

		return array(
			'hb_meta' => array(
				'columns' => array(
					'k' => "varchar(64) NOT NULL",
					'v' => "text NULL",
				),
				'primary' => 'k',
			),
			'admins' => array(
				'columns' => array(
					'id' => $id,
					'username' => "varchar(250) NOT NULL",
					'email' => "varchar(250) NOT NULL DEFAULT ''",
					'password' => "varchar(250) NOT NULL",
					'device_id' => "varchar(200) NOT NULL DEFAULT ''",
				),
				'indexes' => array('idx_username' => 'username(191)'),
			),
			'badges' => array(
				'columns' => array(
					'id' => $id,
					'title' => "varchar(300) NOT NULL DEFAULT ''",
					'subtitle' => "varchar(300) NOT NULL DEFAULT ''",
					'img' => "varchar(100) NULL DEFAULT NULL",
					'position' => "int(11) NULL DEFAULT 0",
				),
			),
			'cats' => array(
				'columns' => array(
					'id' => $id,
					'title' => "varchar(200) NOT NULL",
					'slug' => "varchar(250) NULL DEFAULT NULL",
					'img' => "varchar(300) NULL DEFAULT NULL",
					'position' => "int(11) NOT NULL DEFAULT 0",
				),
				'indexes' => array('idx_slug' => 'slug(191)'),
			),
			'collections' => array(
				'columns' => array(
					'id' => $id,
					'title' => "varchar(300) NOT NULL",
					'description' => "text NULL",
					'image' => "varchar(300) NULL DEFAULT NULL",
					'products' => "text NULL",
					'slug' => "varchar(300) NOT NULL DEFAULT ''",
					'visible_home' => "int(11) NOT NULL DEFAULT 0",
					'position' => "int(11) NULL DEFAULT 0",
				),
				'indexes' => array('idx_slug' => 'slug(191)'),
			),
			'discounts' => array(
				'columns' => array(
					'id' => $id,
					'coupon' => "varchar(100) NOT NULL",
					'num' => "int(11) NOT NULL DEFAULT 0",
					'date' => "date NOT NULL",
				),
				'indexes' => array('idx_coupon' => 'coupon'),
			),
			'google_sheets' => array(
				'columns' => array(
					'id' => "bigint(20) unsigned NOT NULL AUTO_INCREMENT",
					'email' => "varchar(255) NOT NULL DEFAULT ''",
					'client_id' => "varchar(255) NOT NULL DEFAULT ''",
					'client_secret' => "varchar(255) NOT NULL DEFAULT ''",
					'token' => "varchar(2048) NOT NULL DEFAULT ''",
					'refresh_token' => "varchar(2048) NOT NULL DEFAULT ''",
					'expire' => "varchar(255) NOT NULL DEFAULT ''",
					'sheetId' => "varchar(255) NOT NULL DEFAULT ''",
					'active' => "tinyint(4) NOT NULL DEFAULT 1",
				),
			),
			'html_codes' => array(
				'columns' => array(
					'id' => $id,
					'name' => "varchar(200) NOT NULL",
					'content' => "text NULL",
					'pages' => "varchar(300) NOT NULL DEFAULT ''",
					'active' => "int(1) NOT NULL DEFAULT 0",
					'position' => "int(11) NOT NULL DEFAULT 0",
				),
			),
			'landing_pages' => array(
				'columns' => array(
					'id' => $id,
					'title' => "varchar(300) NOT NULL",
					'slug' => "varchar(300) NOT NULL DEFAULT ''",
					'product_id' => "int(11) NOT NULL DEFAULT 0",
					'price' => "float NOT NULL DEFAULT 0",
					'old_price' => "float NOT NULL DEFAULT 0",
					'price2' => "float NOT NULL DEFAULT 0",
					'price3' => "float NOT NULL DEFAULT 0",
					'discount' => "int(11) NOT NULL DEFAULT 0",
					'shipping' => "float NOT NULL DEFAULT 0",
					'upsell' => "varchar(300) NOT NULL DEFAULT ''",
					'header_color' => "varchar(20) NOT NULL DEFAULT ''",
					'btn_color' => "varchar(20) NOT NULL DEFAULT ''",
					'pixel' => "text NULL",
					'content' => "longtext NULL",
					'reviews' => "longtext NULL",
				),
				'indexes' => array('idx_slug' => 'slug(191)'),
			),
			'login_attempts' => array(
				'columns' => array(
					'id' => $id,
					'username' => "varchar(100) NOT NULL",
					'time' => "int(11) NOT NULL",
				),
				'indexes' => array('idx_username_time' => 'username, time'),
			),
			'orders' => array(
				'columns' => array(
					'id' => $id,
					'name' => "varchar(300) NOT NULL DEFAULT ''",
					'tele' => "varchar(300) NOT NULL DEFAULT ''",
					'address' => "varchar(300) NOT NULL DEFAULT ''",
					'city' => "varchar(300) NOT NULL DEFAULT ''",
					'coupon' => "varchar(300) NOT NULL DEFAULT ''",
					'totalPrice' => "float NOT NULL DEFAULT 0",
					'shipping' => "float NOT NULL DEFAULT 0",
					'products' => "text NULL",
					'date' => "int(11) NOT NULL DEFAULT 0",
					'status' => "int(11) NOT NULL DEFAULT 1",
					'user' => "int(11) NOT NULL DEFAULT 0",
					'company' => "int(11) NOT NULL DEFAULT 0",
					'shippedDate' => "int(11) NOT NULL DEFAULT 0",
					'confirmationDate' => "int(11) NOT NULL DEFAULT 0",
					'note' => "text NULL",
					'sentDate' => "int(11) NOT NULL DEFAULT 0",
					'product' => "varchar(250) NOT NULL DEFAULT ''",
					'source' => "int(11) NOT NULL DEFAULT 1",
				),
				'indexes' => array('idx_status' => 'status', 'idx_date' => 'date'),
			),
			'pages' => array(
				'columns' => array(
					'id' => $id,
					'title' => "varchar(300) NOT NULL",
					'slug' => "varchar(250) NULL DEFAULT NULL",
					'content' => "longtext NULL",
					'header' => "tinyint(1) NULL DEFAULT 0",
					'footer' => "int(1) NOT NULL DEFAULT 0",
					'position' => "int(11) NULL DEFAULT 0",
				),
				'indexes' => array('idx_slug' => 'slug(191)'),
			),
			'products' => array(
				'columns' => array(
					'id' => $id,
					'title' => "varchar(300) NOT NULL",
					'descr' => "mediumtext NULL",
					'price' => "float NOT NULL DEFAULT 0",
					'discount' => "int(2) NOT NULL DEFAULT 0",
					'images' => "mediumtext NULL",
					'cat' => "int(11) NOT NULL DEFAULT 0",
					'date' => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP",
					'shipping' => "float NOT NULL DEFAULT 0",
					'info' => "mediumtext NULL",
					'variants' => "mediumtext NULL",
					'featured' => "tinyint(1) NOT NULL DEFAULT 0",
					'slug' => "varchar(250) NOT NULL DEFAULT ''",
					'description' => "text NULL",
					'review' => "float NULL DEFAULT 0",
					'nbr_review' => "int(11) NOT NULL DEFAULT 0",
				),
				'indexes' => array('idx_slug' => 'slug(191)', 'idx_cat' => 'cat'),
			),
			'promo' => array(
				'columns' => array(
					'id' => $id,
					'title' => "varchar(300) NOT NULL DEFAULT ''",
					'subtitle' => "varchar(300) NOT NULL DEFAULT ''",
					'link' => "varchar(300) NOT NULL DEFAULT ''",
					'tp' => "int(1) NOT NULL DEFAULT 1",
					'img' => "varchar(100) NOT NULL DEFAULT ''",
					'position' => "int(11) NOT NULL DEFAULT 0",
				),
			),
			'reviews' => array(
				'columns' => array(
					'id' => $id,
					'rating' => "int(1) NOT NULL DEFAULT 5",
					'name' => "varchar(300) NOT NULL",
					'email' => "varchar(300) NOT NULL DEFAULT ''",
					'img' => "varchar(300) NULL DEFAULT NULL",
					'comment' => "text NULL",
					'product_id' => "int(11) NOT NULL DEFAULT 0",
					'date' => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP",
					'ac' => "int(1) NOT NULL DEFAULT 0",
				),
				// 2019 column names
				'renames' => array('vote' => 'rating', 'product' => 'product_id'),
				'indexes' => array('idx_product' => 'product_id'),
			),
			// setting('x') prints "-" for NULL values, so the text columns stay NOT NULL
			'settings' => array(
				'columns' => array(
					'id' => $id,
					'title' => "varchar(300) NOT NULL DEFAULT ''",
					'googlea' => "text NOT NULL",
					'fbpixel' => "text NOT NULL",
					'tiktok_pixel' => "text NOT NULL",
					'snap_pixel' => "text NOT NULL",
					'color' => "varchar(300) NOT NULL DEFAULT '#20e506'",
					'descr' => "text NOT NULL",
					'header' => "text NOT NULL",
					'teles' => "text NOT NULL",
					'whs' => "text NOT NULL",
					'messangers' => "text NOT NULL",
					'logo' => "varchar(300) NOT NULL DEFAULT ''",
					'currency' => "varchar(20) NOT NULL DEFAULT 'MAD'",
					// shown instead of the code on Arabic store pages (version 6)
					'currency_ar' => "varchar(30) NOT NULL DEFAULT ''",
					'theme' => "varchar(150) NOT NULL DEFAULT 'hobrtEcom'",
					'fb' => "varchar(200) NOT NULL DEFAULT ''",
					'tw' => "varchar(200) NOT NULL DEFAULT ''",
					'ig' => "varchar(200) NOT NULL DEFAULT ''",
					'yt' => "varchar(200) NOT NULL DEFAULT ''",
					'hbsms_token' => "varchar(64) NOT NULL DEFAULT ''",
					'device_id' => "int(11) NOT NULL DEFAULT 0",
					'store_lng' => "varchar(10) NOT NULL DEFAULT 'arabic'",
					'admin_lng' => "varchar(10) NOT NULL DEFAULT 'english'",
					'newsletter' => "tinyint(1) NOT NULL DEFAULT 0",
				),
			),
			// newsletter subscribers (version 4)
			'newsletter' => array(
				'columns' => array(
					'id' => $id,
					'email' => "varchar(250) NOT NULL",
					'lang' => "varchar(10) NOT NULL DEFAULT ''",
					'ip' => "varchar(45) NOT NULL DEFAULT ''",
					'date' => "timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP",
				),
				'indexes' => array('idx_email' => 'email(191)'),
			),
			// template editor AI assistant chats, one row per chat (version 5)
			'ai_chats' => array(
				'columns' => array(
					'id' => $id,
					'chat_id' => "char(32) NOT NULL",
					'admin' => "int(11) NOT NULL DEFAULT 0",
					'theme' => "varchar(150) NOT NULL DEFAULT ''",
					'file' => "varchar(250) NOT NULL DEFAULT ''",
					'title' => "varchar(300) NOT NULL DEFAULT ''",
					'data' => "longtext NULL",
					'created' => "int(11) NOT NULL DEFAULT 0",
					'updated' => "int(11) NOT NULL DEFAULT 0",
				),
				'indexes' => array('idx_chat' => 'chat_id', 'idx_page' => 'admin, theme, file(191)'),
			),
			'slider' => array(
				'columns' => array(
					'id' => $id,
					'title' => "varchar(300) NULL DEFAULT NULL",
					'link' => "varchar(300) NULL DEFAULT NULL",
					'img' => "varchar(300) NULL DEFAULT NULL",
					'subtitle' => "varchar(300) NULL DEFAULT NULL",
					'info' => "varchar(300) NULL DEFAULT NULL",
					'position' => "int(11) NULL DEFAULT 0",
				),
			),
			'sms' => array(
				'columns' => array(
					'id' => $id,
					'status' => "int(11) NOT NULL DEFAULT 0",
					'msg' => "text NOT NULL",
				),
			),
			'subscribers' => array(
				'columns' => array(
					'id' => $id,
					'phone' => "varchar(20) NOT NULL",
				),
			),
		);
	}

	/*
	| -------------------------------------------------------------------
	| State
	| -------------------------------------------------------------------
	*/

	/**
	 * TRUE when the database already holds a hobrtEcom store (any version).
	 */
	public function has_store()
	{
		return $this->table_exists('admins') && $this->table_exists('settings');
	}

	/**
	 * Schema version of the database: 0 empty, 1 = 2019, 2 = 2023, 3+ recorded.
	 */
	public function current_version()
	{
		if ($this->table_exists('hb_meta')) {
			$st = $this->db->prepare("SELECT v FROM hb_meta WHERE k = 'db_version'");
			$st->execute();
			$v = $st->fetchColumn();
			if ($v !== FALSE)
				return (int) $v;
		}

		if (!$this->has_store())
			return 0;

		$products = $this->columns('products');
		if (!isset($products['slug']) || isset($this->columns('reviews')['vote']))
			return 1;

		return 2;
	}

	public function is_pending()
	{
		return $this->current_version() < self::VERSION;
	}

	public function log()
	{
		return $this->log;
	}

	/*
	| -------------------------------------------------------------------
	| Install / upgrade
	| -------------------------------------------------------------------
	*/

	/**
	 * Fresh install into an empty database.
	 *
	 * @param array $store  title, store_lng
	 * @param array $admin  username, email, password (plain text)
	 */
	public function install(array $store, array $admin)
	{
		if ($this->has_store())
			throw new RuntimeException('This database already contains a store. Use the upgrade instead.');

		// creates every table and the single settings row
		$this->migrate();

		$this->run(
			"UPDATE settings SET title = ?, store_lng = ?, admin_lng = ?",
			array($store['title'], $store['store_lng'], $store['store_lng'] === 'arabic' ? 'arabic' : 'english')
		);

		$this->run(
			"INSERT INTO admins (username, email, password, device_id) VALUES (?, ?, ?, '')",
			array($admin['username'], $admin['email'], password_hash($admin['password'], PASSWORD_DEFAULT))
		);

		$this->note('Store and admin account created');
	}

	/**
	 * Brings any known version up to self::VERSION. Safe to run again.
	 */
	public function migrate()
	{
		$mode = $this->db->getAttribute(PDO::ATTR_ERRMODE);
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		try {
			$from = $this->current_version();

			foreach (self::schema() as $table => $def) {
				$this->ensure_table($table, $def);
			}

			$this->convert_order_products();
			$this->fill_slugs('products', 'title');
			$this->fill_slugs('cats', 'title');
			$this->fill_slugs('pages', 'title');
			$this->fill_slugs('collections', 'title');
			$this->fill_slugs('landing_pages', 'title');
			$this->ensure_settings_row();

			$this->run(
				"REPLACE INTO hb_meta (k, v) VALUES ('db_version', ?), ('db_upgraded_at', ?)",
				array((string) self::VERSION, date('c'))
			);

			$this->note("Database version $from -> " . self::VERSION);
		} finally {
			$this->db->setAttribute(PDO::ATTR_ERRMODE, $mode);
		}

		return $this->log;
	}

	/*
	| -------------------------------------------------------------------
	| Admin passwords
	| -------------------------------------------------------------------
	*/

	/**
	 * Checks a password against a stored hash, including the salted sha1
	 * hashes of the 2019 release. Returns TRUE when it matches.
	 */
	public static function password_matches($password, $hash)
	{
		$password = (string) $password;
		$hash = (string) $hash;

		if (password_verify($password, $hash))
			return TRUE;

		return self::is_legacy_hash($hash) && hash_equals($hash, self::legacy_hash($password));
	}

	public static function is_legacy_hash($hash)
	{
		return (bool) preg_match('/^[a-f0-9]{40}$/', (string) $hash);
	}

	/** 2019 release: sha1 with fixed salts (only used to verify, then re-hashed) */
	public static function legacy_hash($password)
	{
		return sha1('IttIhAdyHobrt' . $password . 'hobrt-programming.com');
	}

	/**
	 * Verifies an admin account directly in the database (used by the installer).
	 * A matching legacy hash is replaced by a modern one.
	 */
	public function verify_admin($username, $password)
	{
		$st = $this->db->prepare("SELECT id, password FROM admins WHERE username = ? LIMIT 1");
		$st->execute(array((string) $username));
		$row = $st->fetch(PDO::FETCH_ASSOC);

		if (!$row || !self::password_matches($password, $row['password']))
			return FALSE;

		if (self::is_legacy_hash($row['password']) || password_needs_rehash($row['password'], PASSWORD_DEFAULT)) {
			$up = $this->db->prepare("UPDATE admins SET password = ? WHERE id = ?");
			$up->execute(array(password_hash((string) $password, PASSWORD_DEFAULT), $row['id']));
		}

		return (int) $row['id'];
	}

	/*
	| -------------------------------------------------------------------
	| Steps
	| -------------------------------------------------------------------
	*/

	private function ensure_table($table, array $def)
	{
		$primary = $def['primary'] ?? 'id';

		if (!$this->table_exists($table)) {
			$cols = array();
			foreach ($def['columns'] as $name => $sql)
				$cols[] = $this->q($name) . ' ' . $sql;
			$cols[] = 'PRIMARY KEY (' . $this->q($primary) . ')';
			foreach ($def['indexes'] ?? array() as $name => $columns)
				$cols[] = 'KEY ' . $this->q($name) . ' (' . $this->index_columns($columns) . ')';

			$this->run('CREATE TABLE ' . $this->q($table) . " (\n  " . implode(",\n  ", $cols) . "\n) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");
			$this->note("Created table $table");
			return;
		}

		$existing = $this->columns($table);

		// renamed columns (2019 names)
		foreach ($def['renames'] ?? array() as $old => $new) {
			if (isset($existing[$old]) && !isset($existing[$new])) {
				$this->run('ALTER TABLE ' . $this->q($table) . ' CHANGE ' . $this->q($old) . ' ' . $this->q($new) . ' ' . $this->convertible_definition($def['columns'][$new], $existing[$old]));
				$this->note("$table: renamed $old to $new");
				$existing = $this->columns($table);
			}
		}

		$previous = NULL;
		foreach ($def['columns'] as $name => $sql) {
			if (!isset($existing[$name])) {
				if ($name === $primary && strpos($sql, 'AUTO_INCREMENT') !== FALSE) {
					// 2019 settings table had no id at all
					$this->run('ALTER TABLE ' . $this->q($table) . ' ADD ' . $this->q($name) . " $sql PRIMARY KEY FIRST");
				} else {
					$this->run('ALTER TABLE ' . $this->q($table) . ' ADD ' . $this->q($name) . " $sql" . ($previous ? ' AFTER ' . $this->q($previous) : ' FIRST'));
				}
				$this->note("$table: added column $name");
			} else {
				$this->upgrade_column($table, $name, $sql, $existing[$name]);
			}
			$previous = $name;
		}

		foreach ($def['indexes'] ?? array() as $name => $columns) {
			if (!$this->index_exists($table, $name)) {
				$this->run('ALTER TABLE ' . $this->q($table) . ' ADD INDEX ' . $this->q($name) . ' (' . $this->index_columns($columns) . ')');
				$this->note("$table: added index $name");
			}
		}
	}

	/**
	 * Changes an existing column only when nothing can be lost:
	 * unix time int -> timestamp (converted), wider types, NULL allowed, adding a default.
	 */
	private function upgrade_column($table, $name, $target, array $current)
	{
		$want = $this->parse_definition($target);
		$have_type = $this->normalize_type($current['COLUMN_TYPE']);
		$t = $this->q($table);
		$c = $this->q($name);

		// int unix time -> timestamp (2019 products.date / reviews.date)
		if ($want['type'] === 'timestamp' && in_array($current['DATA_TYPE'], array('int', 'bigint'), TRUE)) {
			$tmp = $this->q($name . '__hb_tmp');
			if (isset($this->columns($table)[$name . '__hb_tmp']))
				$this->run("ALTER TABLE $t DROP $tmp");
			$this->run("ALTER TABLE $t ADD $tmp timestamp NULL DEFAULT NULL");
			$this->run("UPDATE $t SET $tmp = FROM_UNIXTIME($c) WHERE $c > 0");
			$this->run("UPDATE $t SET $tmp = CURRENT_TIMESTAMP WHERE $tmp IS NULL");
			$this->run("ALTER TABLE $t DROP $c");
			$this->run("ALTER TABLE $t CHANGE $tmp $c $target");
			$this->note("$table: converted $name from unix time to timestamp");
			return;
		}

		$wider = $this->is_wider($have_type, $want['type']);
		$same = $have_type === $want['type'];
		$allow_null = $want['nullable'] && $current['IS_NULLABLE'] === 'NO';
		$add_default = $want['default'] && !$want['nullable'] && $current['IS_NULLABLE'] === 'NO' && $current['COLUMN_DEFAULT'] === NULL
			&& strpos($current['EXTRA'], 'auto_increment') === FALSE;

		if (($same || $wider) && ($wider || $allow_null || $add_default)) {
			$this->run("ALTER TABLE $t MODIFY $c $target");
			$this->note("$table: updated column $name");
		}
	}

	/**
	 * 2019 orders stored products as {"product id": qty}; the code now expects
	 * [{"id": .., "q": .., "options": "[]"}].
	 */
	private function convert_order_products()
	{
		$rows = $this->db->query("SELECT id, products FROM orders")->fetchAll(PDO::FETCH_ASSOC);
		$update = $this->db->prepare("UPDATE orders SET products = ? WHERE id = ?");
		$converted = 0;

		foreach ($rows as $row) {
			$items = json_decode((string) $row['products'], TRUE);
			if (!is_array($items) || $items === array())
				continue;

			$legacy = FALSE;
			foreach ($items as $value) {
				if (!is_array($value)) {
					$legacy = TRUE;
					break;
				}
			}
			if (!$legacy)
				continue;

			$list = array();
			foreach ($items as $product_id => $qty) {
				$list[] = array('id' => (string) $product_id, 'q' => (string) (int) $qty, 'options' => '[]');
			}
			$update->execute(array(json_encode($list, JSON_UNESCAPED_UNICODE), $row['id']));
			$converted++;
		}

		if ($converted)
			$this->note("orders: converted $converted orders to the new products format");
	}

	/**
	 * Gives every row without a slug a unique one (the store URLs use slugs).
	 */
	private function fill_slugs($table, $from)
	{
		$t = $this->q($table);
		$rows = $this->db->query("SELECT id, $from AS src FROM $t WHERE slug IS NULL OR slug = ''")->fetchAll(PDO::FETCH_ASSOC);
		if (!$rows)
			return;

		$taken = array_flip($this->db->query("SELECT slug FROM $t WHERE slug IS NOT NULL AND slug <> ''")->fetchAll(PDO::FETCH_COLUMN));
		$update = $this->db->prepare("UPDATE $t SET slug = ? WHERE id = ?");

		foreach ($rows as $row) {
			$base = self::slugify($row['src']);
			if ($base === '')
				$base = rtrim($table, 's') . '-' . $row['id'];
			$slug = $base;
			for ($i = 2; isset($taken[$slug]); $i++)
				$slug = $base . '-' . $i;
			$taken[$slug] = TRUE;
			$update->execute(array($slug, $row['id']));
		}

		$this->note("$table: generated " . count($rows) . " slugs");
	}

	/** Same shape as the slugs the admin panel creates (letters of any language, digits, dashes) */
	public static function slugify($text)
	{
		$text = strip_tags((string) $text);
		$text = preg_replace('/[^\p{L}\p{N}]+/u', '-', $text);
		$text = trim($text, '-');
		return function_exists('mb_strtolower') ? mb_strtolower($text, 'UTF-8') : strtolower($text);
	}

	private function ensure_settings_row()
	{
		if ((int) $this->db->query("SELECT COUNT(*) FROM settings")->fetchColumn() > 0)
			return;

		$this->run("INSERT INTO settings (title, googlea, fbpixel, tiktok_pixel, snap_pixel, descr, header, teles, whs, messangers)
			VALUES ('hobrtEcom', '', '', '', '', '', '', '', '', '')");
		$this->note('settings: created default row');
	}

	/*
	| -------------------------------------------------------------------
	| Helpers
	| -------------------------------------------------------------------
	*/

	private function run($sql, array $params = array())
	{
		if ($params) {
			$st = $this->db->prepare($sql);
			$st->execute($params);
			return $st;
		}
		return $this->db->exec($sql);
	}

	private function note($text)
	{
		$this->log[] = $text;
	}

	private function q($identifier)
	{
		return '`' . str_replace('`', '``', $identifier) . '`';
	}

	private function index_columns($columns)
	{
		$out = array();
		foreach (explode(',', $columns) as $col) {
			$col = trim($col);
			if (preg_match('/^(\w+)\((\d+)\)$/', $col, $m))
				$out[] = $this->q($m[1]) . '(' . $m[2] . ')';
			else
				$out[] = $this->q($col);
		}
		return implode(', ', $out);
	}

	private function table_exists($table)
	{
		$st = $this->db->prepare("SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ?");
		$st->execute(array($table));
		return (int) $st->fetchColumn() > 0;
	}

	private function index_exists($table, $index)
	{
		$st = $this->db->prepare("SELECT COUNT(*) FROM information_schema.STATISTICS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND INDEX_NAME = ?");
		$st->execute(array($table, $index));
		return (int) $st->fetchColumn() > 0;
	}

	private function columns($table)
	{
		$st = $this->db->prepare("SELECT COLUMN_NAME, DATA_TYPE, COLUMN_TYPE, IS_NULLABLE, COLUMN_DEFAULT, EXTRA
			FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? ORDER BY ORDINAL_POSITION");
		$st->execute(array($table));
		$cols = array();
		foreach ($st->fetchAll(PDO::FETCH_ASSOC) as $row)
			$cols[$row['COLUMN_NAME']] = $row;
		return $cols;
	}

	/** For a rename the old type is kept when the new one is not compatible */
	private function convertible_definition($target, array $current)
	{
		$want = $this->parse_definition($target);
		if ($want['type'] === 'timestamp' && in_array($current['DATA_TYPE'], array('int', 'bigint'), TRUE))
			return $current['COLUMN_TYPE'] . ' NOT NULL DEFAULT 0';
		return $target;
	}

	private function parse_definition($sql)
	{
		preg_match('/^(\w+(?:\([\d,]+\))?(?:\s+unsigned)?)/i', $sql, $m);
		return array(
			'type' => $this->normalize_type($m[1] ?? $sql),
			'nullable' => stripos($sql, 'NOT NULL') === FALSE,
			'default' => stripos($sql, 'DEFAULT') !== FALSE,
		);
	}

	/** int(11) and int are the same type (MySQL 8 hides the display width) */
	private function normalize_type($type)
	{
		$type = strtolower(trim($type));
		return preg_replace('/^(tinyint|smallint|mediumint|int|bigint)\(\d+\)/', '$1', $type);
	}

	private function is_wider($have, $want)
	{
		if (preg_match('/^varchar\((\d+)\)$/', $have, $a) && preg_match('/^varchar\((\d+)\)$/', $want, $b))
			return (int) $b[1] > (int) $a[1];

		$text = array('varchar' => 0, 'text' => 1, 'mediumtext' => 2, 'longtext' => 3);
		$h = preg_replace('/\(.*$/', '', $have);
		$w = preg_replace('/\(.*$/', '', $want);
		if (isset($text[$h], $text[$w]))
			return $text[$w] > $text[$h];

		$ints = array('tinyint' => 0, 'smallint' => 1, 'mediumint' => 2, 'int' => 3, 'bigint' => 4);
		if (isset($ints[$h], $ints[$w]))
			return $ints[$w] > $ints[$h] && strpos($have, 'unsigned') === strpos($want, 'unsigned');

		return FALSE;
	}
}
