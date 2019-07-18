<!DOCTYPE html>
<html lang="ar">
	<head>
		<meta charset="utf-8">
		<title><?php echo setting("title"); ?> - <?php echo isset($title) ? $title : "بيع جميع أنواع السلع"; ?></title>

		<base href="<?php echo base_url(); ?>">

		<script type="text/javascript">
			var base_url = "<?php echo base_url(); ?>";
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
		<meta name="og:title" content="<?php echo setting("title"); ?> - <?php echo isset($title) ? $title : "بيع جميع أنواع السلع"; ?>"/>
		<meta name="og:type" content="e-commerce"/>
		<meta name="og:url" content="<?php echo base_url() ?>"/>
		<meta name="og:image" content="uploads/large_"/>
		<meta name="og:site_name" content="<?php echo setting("title"); ?>"/>
		<meta name="og:description" content="<?php echo setting("descr"); ?>"/>
		<!-- General CSS Settings -->
		<link rel="stylesheet" href="assets/css/general_style.css">
		<!-- Main Style of the template -->
		<link rel="stylesheet" href="assets/css/main_style.css">
		<!-- Landing Page Style -->
		<link rel="stylesheet" href="assets/css/reset_style.css">
		<!-- Awesomefont -->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
		<!-- Fav Icon -->
		<link rel="shortcut icon" href="favicon.ico">

		<?php echo setting("googlea"); ?>
		<?php echo setting("fbpixel"); ?>

	</head>
	<body>

		<nav class="hobrtNav">
			<?php echo setting("header"); ?>
		</nav>
		<!-- Wrapper -->
		<div class="lx-wrapper" dir="rtl">
			<!-- Header -->
			<div class="lx-header">
				<!-- Header Bottom -->
				<div class="lx-header-bottom">
					<div class="lx-header-bottom-content">
						<div class="lx-header-logo">
							<a href=""><img src="logo/<?php echo setting('logo'); ?>"></span></a>
						</div>
						<div class="lx-mobile-menu">
							<a href="javascript:;"><i class="fa fa-bars"></i></a>
						</div>
						<div class="lx-main-menu">
							<ul>
								<?php foreach($cats as $cat) : ?>
									<li><a href="category/<?php echo $cat->id; ?>" class=""><?php echo $cat->title; ?></a></li>
								<?php endforeach; ?>
								<li><a href="special/تخفيضات" class="">تخفيضات</a></li>
							</ul>
							<div class="lx-clear-fix"></div>
						</div>
						<div class="lx-header-cart">
							<a href="<?php echo base_url("home/cart"); ?>">
							<i class="fa fa-shopping-basket"></i>

							<?php $cart = is_null(get_cookie("cart")) ? array() : json_decode(get_cookie("cart"), TRUE) ; echo count($cart) == 0 ? "" : "<span>".count($cart)."</span>"; ?>

							</a>
						</div>
						<div class="lx-clear-fix"></div>
					</div>
				</div>
				<div class="lx-clear-fix"></div>
				<div class="lx-contact-us">
					<a href="javascript:;"><i class="fa fa-phone"></i></a>
					<div class="lx-contact-us-content">
						<ul>
							<?php $teles = explode(";", setting("teles")); foreach($teles as $t) : ?>
								<li><a href="tel:<?php echo $t; ?>" class="lx-color1"><i class="fa fa-phone"></i> <?php echo $t; ?></a></li>
							<?php endforeach; ?>
							<?php $teles = explode(";", setting("whs")); foreach($teles as $t) : ?>
								<li><a href="https://wa.me/212<?php echo $t; ?>" class="lx-color3"><i class="fab fa-whatsapp"></i> <?php echo $t; ?></a></li>
							<?php endforeach; ?>
							<?php $teles = explode(";", setting("messangers")); foreach($teles as $t) : ?>
								<li><a href="https://www.messenger.com/t/<?php echo $t; ?>" target="_blank" class="lx-color4"><i class="fab fa-facebook-messenger"></i> Messenger</a></li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</div>