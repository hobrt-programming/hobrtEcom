<?php
$rtl = lang("lang_h40") === "ar";

if (!function_exists('markito_readable')) {
	/**
	 * The store colour, darkened just enough for white text on it (and it as
	 * text on white) to reach the WCAG contrast ratio of 4.5:1.
	 */
	function markito_readable($hex)
	{
		if (!preg_match('/^#?([0-9a-f]{6})$/i', trim((string) $hex), $m))
			return '#c0392b';
		$rgb = array_map('hexdec', str_split($m[1], 2));
		$lum = function ($c) {
			$c = array_map(function ($v) {
				$v /= 255;
				return $v <= 0.03928 ? $v / 12.92 : pow(($v + 0.055) / 1.055, 2.4);
			}, $c);
			return 0.2126 * $c[0] + 0.7152 * $c[1] + 0.0722 * $c[2];
		};
		while (1.05 / ($lum($rgb) + 0.05) < 4.5)
			$rgb = array_map(function ($v) { return (int) floor($v * 0.92); }, $rgb);
		return vsprintf('#%02x%02x%02x', $rgb);
	}
}
$color = markito_readable(setting("color"));

$logo_file = FCPATH . (setting("logo") ? "images/" . setting("logo") : "assets/img/logo.png");
$logo_size = is_file($logo_file) && ($size = @getimagesize($logo_file)) ? 'width="' . round($size[0] * 55 / max(1, $size[1])) . '" height="55"' : '';

// the page's own title and summary for search results and link previews
$page_title = isset($title) ? $title : (isset($product) ? $product->title . " | " . setting("title") : setting("title"));
$page_descr = isset($product) ? ($product->description ?: $product->descr) : (isset($page) && isset($page->content) ? $page->content : setting("descr"));
$page_descr = trim(preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags((string) $page_descr), ENT_QUOTES, 'UTF-8')));
if ($page_descr === '')
	$page_descr = setting("title");
$page_descr = mb_strimwidth($page_descr, 0, 160, '…', 'UTF-8');
$page_image = isset($product) && $product->images ? base_url("uploads/" . add_thumb($product->images, "")) : store_logo();

// loads a stylesheet without blocking the first paint (for styles of things below the fold or opened later)
$late_css = function ($href, $attrs = '') {
	return '<link rel="preload" as="style" href="' . $href . '"' . $attrs . ' onload="this.onload=null;this.rel=\'stylesheet\'"><noscript><link rel="stylesheet" href="' . $href . '"' . $attrs . '></noscript>';
};
?>
<!DOCTYPE html>
<html lang="<?= lang("lang_h40") ?>" dir="<?= $rtl ? "rtl" : "ltr" ?>">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= html_escape($page_title) ?></title>

	<base href="<?php echo base_url("themes/front/markito/"); ?>">

	<link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
	<!-- the text font (Changa, in style.css) for the store's language, before the CSS asks for it -->
	<link rel="preload" as="font" type="font/woff2" crossorigin href="fonts/changa-300-<?= $rtl ? "arabic" : "latin" ?>.woff2">

	<!-- Bootstrap 4.5.3 and slick 1.8.1 are served from the theme: no extra connections before the first paint -->
	<link rel="stylesheet" href="css/<?= $rtl ? "bootstrap-rtl.min.css" : "bootstrap.min.css" ?>">
	<!--fontawesome 5-->
	<link rel="stylesheet" href="css/all.min.css?v=<?= filemtime(__DIR__ . "/css/all.min.css") ?>">
	<!--slickslider.css-->
	<link rel="stylesheet" href="css/slick.min.css">
	<link rel="stylesheet" href="css/slick-theme.css?v=<?= filemtime(__DIR__ . "/css/slick-theme.css") ?>">
	<!-- animations, mobile menu, lightbox and icon font: not needed for the first paint -->
	<?= $late_css("css/animate.min.css") ?>
	<?= $late_css("css/slicknav.min.css") ?>
	<?= $late_css("css/lity.min.css") ?>
	<?= $late_css("fonts/flaticon.css") ?>
	<!--Fav-icon-->
	<link rel="shortcut icon" href="images/fav-icon.png" type="image/x-icon">
	<!-- Custom.css -->
	<link rel="stylesheet" href="css/style.css?v=<?= filemtime(__DIR__ . "/css/style.css") ?>">
	<link rel="stylesheet" href="css/responsive.css?v=<?= filemtime(__DIR__ . "/css/responsive.css") ?>">
	<link rel="stylesheet" href="css/hero.css?v=<?= filemtime(__DIR__ . "/css/hero.css") ?>">
	<?php if ($rtl) : ?><link rel="stylesheet" href="css/rtl.css?v=<?= filemtime(__DIR__ . "/css/rtl.css") ?>"><?php endif; ?>


	<script type="text/javascript">
		<?php
		$currency = currency_label();
		?>

		var base_url = "<?php echo base_url(); ?>";
		var Currency = <?= json_encode($currency, JSON_UNESCAPED_UNICODE) ?>;
	</script>

	<meta name="description" content="<?= html_escape($page_descr) ?>">
	<meta name="robots" content="index,follow">
	<meta name="author" content="hobrt, hobrt.me">
	<link rel="canonical" href="<?= html_escape(current_url()) ?>">
	<meta property="og:title" content="<?= html_escape($page_title) ?>">
	<meta property="og:type" content="<?= isset($product) ? "product" : "website" ?>">
	<meta property="og:url" content="<?= html_escape(current_url()) ?>">
	<meta property="og:image" content="<?= html_escape($page_image) ?>">
	<meta property="og:site_name" content="<?= html_escape(setting("title")) ?>">
	<meta property="og:description" content="<?= html_escape($page_descr) ?>">
	<meta name="twitter:card" content="summary_large_image">


	<?php if (isset($code_header)) : ?>

		<?php foreach ($code_header as $code) : ?>

			<?php echo $code->content; ?>

		<?php endforeach; ?>

	<?php endif; ?>

	<?php echo setting("googlea"); ?>
	<?php $pixels = setting("fbpixel");
	if (!empty($pixels)) { ?>

		<script>
			! function(f, b, e, v, n, t, s) {
				if (f.fbq) return;
				n = f.fbq = function() {
					n.callMethod ?
						n.callMethod.apply(n, arguments) : n.queue.push(arguments)
				};
				if (!f._fbq) f._fbq = n;
				n.push = n;
				n.loaded = !0;
				n.version = '2.0';
				n.queue = [];
				t = b.createElement(e);
				t.async = !0;
				t.src = v;
				s = b.getElementsByTagName(e)[0];
				s.parentNode.insertBefore(t, s)
			}(window, document, 'script',
				'https://connect.facebook.net/en_US/fbevents.js');

			<?php

			$pixels = trim($pixels);

			$pixels = explode(PHP_EOL, $pixels);

			foreach ($pixels as $pixel) { ?>

				fbq('init', '<?= $pixel; ?>');

			<?php } ?>

			fbq('track', 'PageView');
		</script>

	<?php } ?>

	<!-- color style -->
	<style>
		.slick-prev,
		.slick-next,
		a.buy-now,
		li.saprater-box,
		button.contact-btn,
		a.cart>span,
		.p-button a {
			background: <?= $color ?>
		}

		a.add-to-cart {
			background: <?= $color ?> !important;
			border-color: <?= $color ?> !important;
		}

		.navbar-light .navbar-nav .active>.nav-link,
		.navbar-light .navbar-nav .nav-link:focus,
		.navbar-light .navbar-nav .nav-link:hover {
			color: <?= $color ?>
		}

		.navbar-light .navbar-nav a.nav-link:after {
			border-bottom-color: <?= $color ?>
		}

		.offer-banner-content a, .product-detail-price .h3, .stock p span {
			color: <?= $color ?>
		}

		.custom-variants-style input[type="radio"]:checked+label {
			background: <?= $color ?>;
		}

		.price-discount {
			text-decoration: line-through;
			color: black !important;
			font-weight: 100 !important;
			font-size: 14px !important;
		}

		.new-collection-item-content ul li i, ul.item-rating li, .stars {
			color: #ffa41c
		}

		.new-collection-item-content span {
			color: black !important;
			font-size: 19px;
		}

		.page-item:last-child .page-link {
			background: <?= $color ?> !important;
		}
	</style>
</head>

<body class="<?= $rtl ? "rtl" : "ltr" ?>" dir="<?= $rtl ? "rtl" : "ltr" ?>">
	<!-- Start-Header-Section -->
	<!-- Menu-start-area -->
	<header>
		<!--Nav-Bar-->
		<?php if (setting("header") !== null && setting("header") != "") { ?>
			<div class="topbar" style="background:<?= $color ?>!important">
				<div class="container">
					<div class="row">
						<div class="top-content text-center">
							<p class="h6 text-white mb-0"><?= setting("header"); ?></p>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<!--Nav-Bar-->
		<div class="header-fixed header-one border-bottom">
			<div class="container">
				<div class="row">
					<div class="d-none col-lg-2 col-md-12 col-sm-12 d-lg-flex align-items-center">
						<div class="nav-brand">
							<a href="<?= base_url("/") ?>"><img src="<?= store_logo() ?>" style="height:55px;width:auto" <?= $logo_size ?> alt="<?= html_escape(setting("title")) ?>" class="logo"></a>
						</div>
					</div>
					<div class="col-lg-8">
						<nav class="navbar navbar-expand-lg navbar-light">
							<div class="collapse navbar-collapse my-lg-0" id="navbarNav">
								<ul class="navbar-nav mr-auto text-left">
									<li class="nav-item active">
										<a class="nav-link scroll" href="<?= base_url("/") ?>"><?= lang("lang_h53") ?></a>
									</li>
									<li class="nav-item">
										<a class="nav-link scroll" href="<?= base_url("home/products") ?>"><?= lang("lang_h65") ?></a>
									</li>
									<li class="nav-item">
										<a class="nav-link scroll" href="<?= base_url("home/products") ?>"><?= lang("lang_h66") ?></a>
										<ul class="dropdown">
											<?php foreach (all_categories() as $all_category) : ?>
												<li class="nav-item">
													<a class="nav-link scroll" href="<?= base_url("/category/$all_category->slug"); ?>"><?= $all_category->title ?></a>
												</li>
											<?php endforeach; ?>
										</ul>
									</li>
									<?php foreach (header_pages() as $header_page) : ?>
										<li class="nav-item">
											<a class="nav-link scroll" href="<?= base_url("/page/$header_page->slug"); ?>"><?= $header_page->title ?></a>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>
						</nav>
					</div>
					<div class="d-none d-lg-block col-lg-2">
						<div class="login-cart" style="line-height: 76px;">
							<div class="cart-popup">
								<?php $cart = is_null(get_cookie("cart")) ? array() : json_decode(get_cookie("cart"), TRUE); ?>
								<a href="<?php echo base_url('cart') ?>" class="cart" aria-label="<?= html_escape(lang("lang_h52")) ?>"><i class="fab fa-opencart" aria-hidden="true"></i><?php if (count($cart) > 0) { ?> <span><?= count($cart); ?></span><?php } ?></a>

							</div>
						</div>
					</div>
					<div class="col-12 mt-2 d-lg-none">
						<div class="container">
							<div class="d-flex align-items-center justify-space-between">
								<button type="button" class="btn btn-lg mobile-menu-button" aria-label="<?= $rtl ? "القائمة" : "Menu" ?>"><i class="fas fa-align-justify" aria-hidden="true"></i></button>
								<div class="text-center" style="flex:1 1 auto">
									<img src="<?= store_logo() ?>" alt="<?= html_escape(setting("title")) ?>" width="90" height="30" style="width: 90px; height:30px;object-fit:contain">
								</div>
								<div class="cart-popup">
									<?php $cart = is_null(get_cookie("cart")) ? array() : json_decode(get_cookie("cart"), TRUE); ?>
									<a href="<?php echo base_url('cart') ?>" class="cart" aria-label="<?= html_escape(lang("lang_h52")) ?>"><i class="fab fa-opencart" aria-hidden="true"></i><?php if (count($cart) > 0) { ?> <span><?= count($cart); ?></span><?php } ?></a>
								</div>
							</div>
						</div>
					</div>
					<div class="mobile-menu"></div>
				</div>
			</div>
		</div>
	</header>
	<main id="main">