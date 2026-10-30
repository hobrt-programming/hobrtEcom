<?php $rtl = lang("lang_h40") === "ar"; ?>
<!DOCTYPE html>
<html lang="<?=lang("lang_h40");?>" dir="<?= $rtl ? "rtl" : "ltr" ?>">
	<head>
		<meta charset="utf-8">
		<title><?php echo setting("title"); ?> - <?php echo isset($title) ? $title : lang("lang_h110"); ?></title>

		<base href="<?php echo base_url(); ?>">

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
		<meta name="og:title" content="<?php echo setting("title"); ?> - <?php echo isset($title) ? $title : lang("lang_h110"); ?>"/>
		<meta name="og:type" content="e-commerce"/>
		<meta name="og:url" content="<?php echo base_url() ?>"/>
		<meta name="og:image" content="uploads/large_"/>
		<meta name="og:site_name" content="<?php echo setting("title"); ?>"/>
		<meta name="og:description" content="<?php echo setting("descr"); ?>"/>
		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

		<?php if ($rtl) : ?>
		<link rel="stylesheet" href="assets/hbtheme/assets/bootstrap/css/bootstrap.rtl.min.css?v=<?= filemtime(FCPATH . "assets/hbtheme/assets/bootstrap/css/bootstrap.rtl.min.css") ?>">
		<?php else : ?>
		<link rel="stylesheet" href="assets/hbtheme/assets/bootstrap/css/bootstrap.min.css?h=11cd6552f0cfd1243be7481c40111374">
		<?php endif; ?>
        <link rel="stylesheet" href="assets/hbtheme/assets/css/styles.min.css?h=80eab40d54a67261d69c3259e022e0dc">
        <link rel="stylesheet" href="assets/hbtheme/assets/css/img.css">
        <link rel="stylesheet" href="assets/hbtheme/assets/css/font.css">
        <link rel="stylesheet" href="assets/hbtheme/assets/css/card.css">
        <link rel="stylesheet" href="assets/hbtheme/assets/css/single-product.css">
        <link rel="stylesheet" href="assets/hbtheme/assets/css/swipe.css">
        <link rel="stylesheet" href="assets/hbtheme/assets/css/swipe-bundle.css">
        <link rel="stylesheet" href="assets/hbtheme/assets/css/select.css">
        <link rel="stylesheet" href="assets/hbtheme/assets/bootstrap/css/nav.min.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css">
		
		<?php if(isset($code_header)) : ?>

			<?php foreach($code_header as $code) : ?>

				<?php echo $code->content; ?>

			<?php endforeach; ?>

		<?php endif; ?>

		<?php echo setting("googlea"); ?>
		<?php $pixels = setting("fbpixel");
		if(!empty($pixels)) { ?>

		<script>
			!function(f,b,e,v,n,t,s)
			{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
			n.callMethod.apply(n,arguments):n.queue.push(arguments)};
			if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
			n.queue=[];t=b.createElement(e);t.async=!0;
			t.src=v;s=b.getElementsByTagName(e)[0];
			s.parentNode.insertBefore(t,s)}(window, document,'script',
			'https://connect.facebook.net/en_US/fbevents.js');

			<?php

			$pixels = trim($pixels);

			$pixels = explode(PHP_EOL, $pixels);

			foreach ($pixels as $pixel) { ?>

				fbq('init', '<?=$pixel;?>');

			<?php } ?>

			fbq('track', 'PageView');
		</script>

	<?php } ?>

	<style>
		
		.lx-purchase-btns a.lx-add-to-cart, .buy-now, .lx-contact-us > a, .hobrtNav, .lx-footer-bottom, .lx-purchase-btns-floating a, .lx-cart-next-step a, .lx-header-cart a > span {
			background-color: <?=setting('color');?> !important;
		}

	</style>


	</head>
	<body>


	<nav class="hobrtNav text-center py-2 text-light">
			<?php echo setting("header"); ?>
		</nav>
	<!-- Start: Navbar Centered Links -->
	<nav class="navbar navbar-light navbar-expand-md sticky-top navbar-shrink py-3" id="mainNav">
            <div class="container">
			<a class="navbar-brand d-flex align-items-center" href="<?= base_url("/") ?>"><img src="<?= store_logo() ?>" style="height:55px" alt="logo.png" class="logo"></a>
<button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1">
	<span class="visually-hidden">Toggle navigation</span>
	<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navcol-1">
	<ul class="navbar-nav mx-auto">
		<li class="nav-item">
		<a class="nav-link active" href="<?= base_url("/") ?>"><?= lang("lang_h53") ?></a>
	</li>
	<li class="nav-item">
		<a class="nav-link active" href="<?= base_url("home/products") ?>"><?= lang("lang_h65") ?></a>
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
	<li class="nav-item">
	<?php foreach (header_pages() as $header_page) : ?>
	<li class="nav-item">
		<a class="nav-link scroll" href="<?= base_url("/page/$header_page->slug"); ?>"><?= $header_page->title ?></a>
	</li>
	<?php endforeach; ?>
	</li>
</ul>

<div class="my-2" style="position: relative;">
<?php $cart = is_null(get_cookie("cart")) ? array() : json_decode(get_cookie("cart"), TRUE); ?>
<a href="<?php echo base_url('cart') ?>" class="cart"><button class="btn btn-light me-2" type="button">
	<svg class="bi bi-basket" xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1em" fill="currentColor" viewBox="0 0 16 16">
    <path d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1v4.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 13.5V9a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h1.217L5.07 1.243a.5.5 0 0 1 .686-.172zM2 9v4.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V9H2zM1 7v1h14V7H1zm3 3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 4 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 6 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 8 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5z"></path>
	</svg>
	</button><?php if (count($cart) > 0) { ?> <strong><span class="bg-secondary text-light px-1 rounded-pill" style="position: absolute; top:5%; right:5%"><?= count($cart); ?></span></strong><?php } ?></a>
    <!-- <button class="btn text-light" type="button" style="border-color:<?= setting("color") ?>;background:<?= setting("color") ?>">
	<svg class="bi bi-heart-fill" xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1em" fill="currentColor" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"></path>
    </svg>
	</button> -->
  </div>
</div>
</div>
</nav>


</div>