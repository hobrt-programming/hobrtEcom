<?php
/**
 * @author hobrt.me
 * @file seed.php
 * @package hobrtEcom
 *
 * Fills an installed store with demo data: categories, products (with
 * generated images), pages, slider, collections, reviews and a coupon.
 *
 * Command line only, run it as the web server user so it can read
 * application/config/local.php and write to images/ and uploads/:
 *
 *    sudo -u nginx php install/seed.php            # refuses if products exist
 *    sudo -u nginx php install/seed.php --force    # add demo data anyway
 */

if (PHP_SAPI !== 'cli') {
	http_response_code(404);
	exit;
}

define('HB_ROOT', dirname(__DIR__));
define('BASEPATH', HB_ROOT . '/system/');
define('APPPATH', HB_ROOT . '/application/');
define('IMAGES', HB_ROOT . '/images/');     // categories, slider, collections
define('UPLOADS', HB_ROOT . '/uploads/');   // product pictures

require APPPATH . 'libraries/Hb_migrator.php';

function fail($msg)
{
	fwrite(STDERR, $msg . "\n");
	exit(1);
}

$local = is_readable(APPPATH . 'config/local.php') ? (include APPPATH . 'config/local.php') : array();
if (empty($local['db']))
	fail('application/config/local.php is missing or unreadable: install the store first, and run this as the web server user.');

if (!function_exists('imagewebp'))
	fail('The GD extension with WebP support is required.');

foreach (array(IMAGES, UPLOADS) as $dir)
	if (!is_writable($dir))
		fail(basename($dir) . '/ is not writable by this user.');

$db = $local['db'];
$pdo = new PDO(
	'mysql:host=' . $db['hostname'] . ';port=' . $db['port'] . ';dbname=' . $db['database'] . ';charset=utf8mb4',
	$db['username'],
	$db['password'],
	array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
);

if (!(new Hb_migrator($pdo))->has_store())
	fail('The database has no store yet: run install/install.php first.');

if ((int) $pdo->query('SELECT COUNT(*) FROM products')->fetchColumn() > 0 && !in_array('--force', $argv, TRUE))
	fail('The store already has products. Use --force to add the demo data anyway.');

/*
| -------------------------------------------------------------------
| Helpers
| -------------------------------------------------------------------
*/

function insert(PDO $pdo, $table, array $row)
{
	$cols = array_keys($row);
	$sql = 'INSERT INTO `' . $table . '` (`' . implode('`, `', $cols) . '`) VALUES (' . rtrim(str_repeat('?, ', count($cols)), ', ') . ')';
	$pdo->prepare($sql)->execute(array_values($row));
	return (int) $pdo->lastInsertId();
}

/** A slug that is not used yet in $table */
function unique_slug(PDO $pdo, $table, $title)
{
	$base = Hb_migrator::slugify($title);
	$slug = $base;
	$st = $pdo->prepare('SELECT COUNT(*) FROM `' . $table . '` WHERE slug = ?');
	for ($i = 2; $st->execute(array($slug)) && $st->fetchColumn() > 0; $i++)
		$slug = $base . '-' . $i;
	return $slug;
}

function font()
{
	static $font = NULL;
	if ($font === NULL) {
		$font = '';
		foreach (array('/usr/share/fonts/dejavu-sans-fonts/DejaVuSans-Bold.ttf', '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf', '/usr/share/fonts/google-noto-vf/NotoSans[wght].ttf', '/usr/share/fonts/liberation-sans/LiberationSans-Bold.ttf') as $f)
			if (is_file($f)) {
				$font = $f;
				break;
			}
	}
	return $font;
}

/**
 * Draws a placeholder picture and saves it like the admin upload does:
 * name.jpg plus name_m.webp (400x400) and name_s.webp (100x100) for products,
 * which go to uploads/; the other pictures go to images/.
 */
function make_image($label, array $rgb, $w = 800, $h = 800, $thumbs = TRUE)
{
	$im = imagecreatetruecolor($w, $h);
	list($r, $g, $b) = $rgb;

	// vertical gradient from the colour to a lighter tint
	for ($y = 0; $y < $h; $y++) {
		$t = $y / $h;
		$c = imagecolorallocate($im, (int) ($r + (255 - $r) * $t * .6), (int) ($g + (255 - $g) * $t * .6), (int) ($b + (255 - $b) * $t * .6));
		imageline($im, 0, $y, $w, $y, $c);
	}

	// a few soft circles
	$white = imagecolorallocatealpha($im, 255, 255, 255, 95);
	for ($i = 0; $i < 4; $i++)
		imagefilledellipse($im, random_int(0, $w), random_int(0, $h), random_int(intdiv($w, 4), intdiv($w * 2, 3)), random_int(intdiv($w, 4), intdiv($w * 2, 3)), $white);

	$fg = imagecolorallocate($im, 255, 255, 255);
	if (font()) {
		$size = $w / 14;
		$box = imagettfbbox($size, 0, font(), $label);
		imagettftext($im, $size, 0, (int) (($w - ($box[2] - $box[0])) / 2), (int) ($h / 2 + $size / 2), $fg, font(), $label);
	} else {
		imagestring($im, 5, (int) ($w / 2 - strlen($label) * 4.5), (int) ($h / 2 - 8), $label, $fg);
	}

	$name = 'demo_' . bin2hex(random_bytes(8));
	$dir = $thumbs ? UPLOADS : IMAGES;
	imagejpeg($im, $dir . $name . '.jpg', 85);

	if ($thumbs)
		foreach (array('_m' => 400, '_s' => 100) as $suffix => $size) {
			$t = imagecreatetruecolor($size, $size);
			$side = min($w, $h);
			imagecopyresampled($t, $im, 0, 0, (int) (($w - $side) / 2), (int) (($h - $side) / 2), $size, $size, $side, $side);
			imagewebp($t, $dir . $name . $suffix . '.webp', 85);
			imagedestroy($t);
		}

	imagedestroy($im);
	return $name . '.jpg';
}

/*
| -------------------------------------------------------------------
| Demo data
| -------------------------------------------------------------------
*/

$palette = array(
	array(231, 76, 60), array(52, 152, 219), array(46, 204, 113), array(155, 89, 182),
	array(241, 196, 15), array(230, 126, 34), array(26, 188, 156), array(52, 73, 94),
);

// category => [english label for images, products: [title, price, discount]]
$catalog = array(
	'ملابس رجالية' => array('Men', array(
		array('قميص قطني كلاسيكي', 199, 0), array('سروال جينز مريح', 279, 10), array('سترة شتوية دافئة', 549, 20), array('تيشيرت رياضي', 119, 0),
	)),
	'ملابس نسائية' => array('Women', array(
		array('فستان صيفي مزهر', 329, 15), array('عباية أنيقة', 459, 0), array('كنزة صوفية', 249, 0), array('تنورة طويلة', 189, 25),
	)),
	'أحذية' => array('Shoes', array(
		array('حذاء رياضي للجري', 399, 10), array('حذاء جلدي رسمي', 599, 0), array('صندل صيفي', 149, 0), array('حذاء شتوي مقاوم للماء', 489, 30),
	)),
	'إلكترونيات' => array('Tech', array(
		array('سماعات لاسلكية', 349, 20), array('ساعة ذكية', 799, 10), array('شاحن سريع 65 واط', 179, 0), array('مكبر صوت بلوتوث', 299, 0),
	)),
	'المنزل والمطبخ' => array('Home', array(
		array('طقم أواني طهي', 899, 15), array('خلاط كهربائي', 459, 0), array('مصباح مكتب LED', 159, 0), array('وسادة قطنية', 99, 0),
	)),
	'التجميل والعناية' => array('Beauty', array(
		array('عطر رجالي فاخر', 499, 10), array('كريم مرطب للبشرة', 129, 0), array('زيت أرغان طبيعي', 189, 0), array('مجفف شعر', 349, 20),
	)),
	'الرياضة' => array('Sport', array(
		array('حصيرة يوغا', 149, 0), array('دمبل قابل للتعديل', 649, 10), array('قنينة ماء رياضية', 69, 0), array('حقيبة رياضية', 229, 15),
	)),
	'الأطفال' => array('Kids', array(
		array('لعبة تركيب تعليمية', 179, 0), array('حقيبة مدرسية', 199, 10), array('ملابس أطفال قطنية', 139, 0), array('دراجة أطفال', 899, 20),
	)),
);

$variants_by_cat = array(
	'Men' => array(array('tp' => 'المقاس', 'info' => 'S,M,L,XL'), array('tp' => 'اللون', 'info' => 'أسود,أزرق,رمادي')),
	'Women' => array(array('tp' => 'المقاس', 'info' => 'S,M,L'), array('tp' => 'اللون', 'info' => 'أحمر,أسود,بيج')),
	'Shoes' => array(array('tp' => 'المقاس', 'info' => '40,41,42,43,44')),
	'Kids' => array(array('tp' => 'العمر', 'info' => '3-5,6-8,9-12')),
);

$names = array('أحمد', 'فاطمة', 'يوسف', 'مريم', 'خالد', 'سارة', 'عمر', 'نادية', 'كريم', 'ليلى');
$comments = array(
	'منتج رائع وجودة ممتازة، أنصح به.',
	'التوصيل كان سريعاً والمنتج مطابق للوصف.',
	'جيد مقابل السعر.',
	'أعجبني كثيراً، سأطلب مرة أخرى.',
	'الجودة أفضل مما توقعت.',
	'خدمة عملاء ممتازة.',
);

$pdo->beginTransaction();

try {
	$product_ids = array();
	$cat_position = (int) $pdo->query('SELECT COALESCE(MAX(position), 0) FROM cats')->fetchColumn();
	$i = 0;

	foreach ($catalog as $cat_title => list($label, $products)) {
		$color = $palette[$i % count($palette)];
		$cat_id = insert($pdo, 'cats', array(
			'title' => $cat_title,
			'slug' => unique_slug($pdo, 'cats', $cat_title),
			'img' => make_image($label, $color, 500, 500, FALSE),
			'position' => ++$cat_position,
		));
		echo "category  $cat_title\n";

		foreach ($products as $n => list($title, $price, $discount)) {
			$images = array();
			for ($k = 1, $count = random_int(2, 3); $k <= $count; $k++)
				$images[] = make_image("$label " . ($n + 1) . " - $k", $palette[($i + $k) % count($palette)]);

			$descr = "<p>$title بجودة عالية وتصميم عصري يناسب الاستعمال اليومي.</p>"
				. '<ul><li>خامات مختارة بعناية</li><li>ضمان لمدة سنة</li><li>توصيل لجميع المدن</li></ul>';

			$id = insert($pdo, 'products', array(
				'title' => $title,
				'slug' => unique_slug($pdo, 'products', $title),
				'descr' => $descr,
				'description' => "$title بأفضل سعر مع توصيل سريع.",
				'price' => $price,
				'discount' => $discount,
				'shipping' => $price >= 300 ? 0 : 30,
				'images' => implode(',', $images),
				'cat' => $cat_id,
				'info' => '',
				'variants' => json_encode($variants_by_cat[$label] ?? array(), JSON_UNESCAPED_UNICODE),
				'featured' => $discount >= 15 ? 1 : 0,
			));
			$product_ids[] = $id;

			// a few approved reviews per product
			$sum = 0;
			$reviews = random_int(1, 4);
			for ($r = 0; $r < $reviews; $r++) {
				$rating = random_int(3, 5);
				$sum += $rating;
				insert($pdo, 'reviews', array(
					'rating' => $rating,
					'name' => $names[array_rand($names)],
					'email' => '',
					'comment' => $comments[array_rand($comments)],
					'product_id' => $id,
					'ac' => 1,
				));
			}
			$pdo->prepare('UPDATE products SET review = ?, nbr_review = ? WHERE id = ?')->execute(array(round($sum / $reviews, 1), $reviews, $id));

			echo "  product $title\n";
		}
		$i++;
	}

	$pages = array(
		array('من نحن', '<p>متجرنا يقدم أفضل المنتجات بأسعار مناسبة مع توصيل سريع إلى جميع المدن.</p>', 1, 1),
		array('اتصل بنا', '<p>الهاتف: 0600000000<br>البريد: contact@example.com</p>', 1, 1),
		array('سياسة الإرجاع', '<p>يمكنكم إرجاع المنتج خلال 7 أيام من تاريخ الاستلام إذا كان في حالته الأصلية.</p>', 0, 1),
		array('الشحن والتوصيل', '<p>التوصيل خلال 24 إلى 72 ساعة، والدفع عند الاستلام.</p>', 0, 1),
		array('الأسئلة الشائعة', '<p><b>كيف أطلب؟</b> اختر المنتج واملأ استمارة الطلب.</p><p><b>هل الدفع عند الاستلام؟</b> نعم.</p>', 1, 0),
		array('سياسة الخصوصية', '<p>نحترم خصوصيتكم ولا نشارك بياناتكم مع أي طرف ثالث.</p>', 0, 1),
	);
	foreach ($pages as $p => list($title, $content, $header, $footer)) {
		insert($pdo, 'pages', array(
			'title' => $title,
			'slug' => unique_slug($pdo, 'pages', $title),
			'content' => $content,
			'header' => $header,
			'footer' => $footer,
			'position' => $p + 1,
		));
		echo "page      $title\n";
	}

	$slides = array(
		array('تخفيضات الموسم', 'خصومات تصل إلى 30%', 'Sale'),
		array('وصل حديثاً', 'اكتشف أحدث المنتجات', 'New'),
		array('توصيل مجاني', 'لكل الطلبات فوق 300 درهم', 'Free shipping'),
	);
	foreach ($slides as $s => list($title, $subtitle, $label)) {
		insert($pdo, 'slider', array(
			'title' => $title,
			'subtitle' => $subtitle,
			'info' => '',
			'link' => 'home/products',
			'img' => make_image($label, $palette[$s + 2], 1200, 500, FALSE),
			'position' => $s + 1,
		));
		echo "slide     $title\n";
	}

	$collections = array('الأكثر مبيعاً', 'عروض اليوم', 'اختيارات المحرر');
	foreach ($collections as $c => $title) {
		shuffle($product_ids);
		insert($pdo, 'collections', array(
			'title' => $title,
			'slug' => unique_slug($pdo, 'collections', $title),
			'description' => "مجموعة $title",
			'image' => make_image('Collection ' . ($c + 1), $palette[$c + 4], 500, 500, FALSE),
			'products' => implode(',', array_slice($product_ids, 0, 8)),
			'visible_home' => 1,
			'position' => $c + 1,
		));
		echo "collection $title\n";
	}

	insert($pdo, 'discounts', array('coupon' => 'DEMO10', 'num' => 10, 'date' => date('Y-m-d', strtotime('+1 year'))));
	echo "coupon    DEMO10 (10%)\n";

	$pdo->commit();
} catch (Throwable $e) {
	$pdo->rollBack();
	fail('Nothing was saved: ' . $e->getMessage());
}

echo "\nDone: " . count($catalog) . ' categories, ' . count($product_ids) . ' products, ' . count($pages) . " pages, 3 slides, 3 collections.\n";
