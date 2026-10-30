<?php $rtl = lang("lang_h40") === "ar"; ?>
<!DOCTYPE html>
<html lang="<?= lang("lang_h40") ?>" dir="<?= $rtl ? "rtl" : "ltr" ?>">
<head>

	<base href="<?php echo base_url("themes/front/theme1/"); ?>">

	<meta charset="utf-8">
	<title><?php echo setting("title"); ?> - <?php echo isset($title) ? $title : lang("lang_h110"); ?></title>

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

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<?php if ($rtl) : ?><link rel="stylesheet" href="assets/css/bootstrap.rtl.min.css"><?php endif; ?>
	<link rel="stylesheet" href="assets/css/style.css?v=<?= filemtime(__DIR__ . "/assets/css/style.css") ?>">
	<link rel="stylesheet" href="assets/css/media.css">
	<link href="https://fonts.googleapis.com/css?family=Cairo" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/all.min.css">
	<link rel="stylesheet" href="assets/css/card.css">
	<link rel="stylesheet" href="assets/css/nav.css">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	     <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	     <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	 <![endif]-->

	 <?php echo setting("googlea"); ?>
	 <?php $pixels = trim(setting("fbpixel"));
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
	 			$pixels = explode(PHP_EOL, $pixels);

	 			foreach ($pixels as $pixel) { ?>

	 				fbq('init', '<?=$pixel;?>');

	 			<?php } ?>

	 			fbq('track', 'PageView');
	 		</script>
	 	<?php } ?>

	 </head>
	 <body>

	 		<header>

	 			<div class="topbar text-center">
	 				<ul class="list-inline">
	 					<?php echo setting("header"); ?>
	 				</ul>
	 			</div>

	 			<!-- Start NAVBAR -->
	 			<nav class="navbar navbar-default">
	 				<div class="container-fluid">
	 					<div class="row">
	 						<div class="col-md-4">
	 							<!-- Brand and toggle get grouped for better mobile display -->
	 							<div class="navbar-header">
	 								<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	 									<span class="sr-only">Toggle navigation</span>
	 									<span class="icon-bar"></span>
	 									<span class="icon-bar"></span>
	 									<span class="icon-bar"></span>
	 								</button>
	 								<a href="<?= base_url("/") ?>"><img src="<?= store_logo() ?>" style="height:55px" alt="logo.png" class="logo"></a>
	 							</div>
	 						</div>

	 						<div class="col-md-8">
							<!-- Collect the nav links, forms, and other content for toggling -->
							<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
								<ul class="nav navbar-nav">
								<li class="nav-item">
										<a class="nav-link scroll" href="<?= base_url("/") ?>"><?= lang("lang_h53") ?></a>
									</li>
									<li class="nav-item">
										<a class="nav-link scroll" href="<?= base_url("home/products") ?>"><?= lang("lang_h65") ?></a>
									</li>
								<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= lang("lang_h66") ?> <span class="caret"></span></a>
								<ul class="dropdown-menu">
								<?php foreach(all_categories() as $cat) : ?>
								<li><a href="<?php echo base_url("category/$cat->slug"); ?>" class=""><?php echo $cat->title; ?></a></li>
								<?php endforeach; ?>
								</ul>
								</li>
								<li><a href="<?php echo base_url("special"); ?>" class=""><?=lang("lang_h1");?></a></li>
								<?php foreach (header_pages() as $header_page) : ?>
										<li class="nav-item">
											<a class="nav-link scroll" href="<?= base_url("/page/$header_page->slug"); ?>"><?= $header_page->title ?></a>
										</li>
								<?php endforeach; ?>
								</ul>
							</div><!-- /.navbar-collapse -->
							</div>
	 					</div><!--. /.Row -->
	 				</div><!-- /.container-fluid -->
	 			</nav>
	 			<!-- End NAVBAR -->
