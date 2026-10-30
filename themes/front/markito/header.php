<?php $rtl = lang("lang_h40") === "ar"; ?>
<!DOCTYPE html>
<html lang="<?= lang("lang_h40") ?>" dir="<?= $rtl ? "rtl" : "ltr" ?>">

<!-- Mirrored from weblizar.com/demo/html/markito/ by HTTraQt Website Copier/1.x [Karbofos 2012-2017] Fri, 11 Mar 2022 01:30:20 GMT -->

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?php echo isset($title) ? $title : setting("title"); ?></title>

	<base href="<?php echo base_url("themes/front/markito/"); ?>">

	<!--bootstrap.min.css-->
	<?php if ($rtl) : ?>
		<link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.5.3/css/bootstrap.min.css" integrity="sha384-JvExCACAZcHNJEc7156QaHXTnQL3hQBixvj5RV5buE7vgnNEzzskDtx9NQ4p6BJe" crossorigin="anonymous">
	<?php else : ?>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
	<?php endif; ?>
	<!--animate.css-->
	<link rel="stylesheet" href="css/animate.min.css">
	<!--fontawesome 5-->
	<link rel="stylesheet" href="css/all.min.css">
	<!--slicknav.css-->
	<link rel="stylesheet" href="css/slicknav.min.css">
	<!--slickslider.css-->


	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" />

	<link rel="stylesheet" href="css/slick-theme.css?v=<?= filemtime(__DIR__ . "/css/slick-theme.css") ?>">

	<!-- lity.css -->
	<link rel="stylesheet" href="css/lity.min.css">
	<!-- flaticon.css -->
	<link rel="stylesheet" href="fonts/flaticon.css">
	<!--Fav-icon-->
	<link rel="shortcut icon" href="images/fav-icon.png" type="image/x-icon">
	<!-- Custom.css -->
	<link rel="stylesheet" href="css/style.css?v=<?= filemtime(__DIR__ . "/css/style.css") ?>">
	<link rel="stylesheet" href="css/responsive.css?v=<?= filemtime(__DIR__ . "/css/responsive.css") ?>">
	<link rel="stylesheet" href="css/hero.css?v=<?= filemtime(__DIR__ . "/css/hero.css") ?>">
	<?php if ($rtl) : ?><link rel="stylesheet" href="css/rtl.css?v=<?= filemtime(__DIR__ . "/css/rtl.css") ?>"><?php endif; ?>
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->


	<script type="text/javascript">
		<?php
		$currency = currency_label();
		?>

		var base_url = "<?php echo base_url(); ?>";
		var Currency = <?= json_encode($currency, JSON_UNESCAPED_UNICODE) ?>;
	</script>

	<meta name="description" content="<?php echo setting("descr"); ?>">
	<meta name="keywords" content="xmall,hmizat,avito,jumia,online shopping,">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="subject" content="e-commerce">
	<meta name="language" content="AR">
	<meta name="robots" content="index,follow" />
	<meta name="Classification" content="Business">
	<meta name="author" content="hobrt, hobrt.me">
	<meta name="designer" content="hobrt lhbib">
	<meta name="reply-to" content="hobrtme@gmail.com">
	<meta name="owner" content="hobrt.me">
	<meta name="url" content="<?php echo base_url(); ?>">
	<meta name="identifier-URL" content="<?php echo base_url(); ?>">
	<meta name="og:title" content="<?php echo isset($title) ? $title : setting("title"); ?>" />
	<meta name="og:type" content="e-commerce" />
	<meta name="og:url" content="<?php echo base_url() ?>" />
	<meta name="og:image" content="uploads/large_" />
	<meta name="og:site_name" content="<?php echo setting("title"); ?>" />
	<meta name="og:description" content="<?php echo setting("descr"); ?>" />


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
			background: <?= setting("color") ?>
		}

		a.add-to-cart {
			background: <?= setting("color") ?> !important;
			border-color: <?= setting("color") ?> !important;
		}

		.navbar-light .navbar-nav .active>.nav-link,
		.navbar-light .navbar-nav .nav-link:focus,
		.navbar-light .navbar-nav .nav-link:hover {
			color: <?= setting("color") ?>
		}

		.navbar-light .navbar-nav a.nav-link:after {
			border-bottom-color: <?= setting("color") ?>
		}

		.offer-banner-content a, .product-detail-price h3, .stock p span {
			color: <?= setting("color") ?>
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
			background: <?= setting("color") ?> !important;
		}

		#preloader {
			background: <?= setting("color") ?>;
		}
	</style>
</head>

<body class="<?= $rtl ? "rtl" : "ltr" ?>" dir="<?= $rtl ? "rtl" : "ltr" ?>">
	<!-- Preloader -->
	<div id="preloader" style="display: flex;" class="align-items-center justify-content-center">
		<img class="pulse animated infinite" style="height: 50px; width:auto!important" src="<?= store_logo() ?>" />
	</div>
	<!-- Start-Header-Section -->
	<!-- Menu-start-area -->
	<header>
		<!--Nav-Bar-->
		<?php if (setting("header") !== null && setting("header") != "") { ?>
			<div class="topbar" style="background:<?= setting("color") ?>!important">
				<div class="container">
					<div class="row">
						<div class="top-content text-center">
							<h6 class="text-white"><?= setting("header"); ?></h6>
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
							<a href="<?= base_url("/") ?>"><img src="<?= store_logo() ?>" style="height:55px" alt="logo.png" class="logo"></a>
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
										<a class="nav-link scroll"><?= lang("lang_h66") ?></a>
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
								<a href="<?php echo base_url('cart') ?>" class="cart"><i class="fab fa-opencart"></i><?php if (count($cart) > 0) { ?> <span><?= count($cart); ?></span><?php } ?></a>

							</div>
						</div>
					</div>
					<div class="col-12 mt-2 d-lg-none">
						<div class="container">
							<div class="d-flex align-items-center justify-space-between">
								<button class="btn btn-lg mobile-menu-button"><i class="fas fa-align-justify"></i></button>
								<div class="text-center" style="flex:1 1 auto">
									<img src="<?= store_logo() ?>" alt="logo" style="width: 90px; height:30px">
								</div>
								<div class="cart-popup">
									<?php $cart = is_null(get_cookie("cart")) ? array() : json_decode(get_cookie("cart"), TRUE); ?>
									<a href="<?php echo base_url('cart') ?>" class="cart"><i class="fab fa-opencart"></i><?php if (count($cart) > 0) { ?> <span><?= count($cart); ?></span><?php } ?></a>
								</div>
							</div>
						</div>
					</div>
					<div class="mobile-menu"></div>
				</div>
			</div>
		</div>
	</header>