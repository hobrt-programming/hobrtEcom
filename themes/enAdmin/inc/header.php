<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<base href="<?php echo base_url(); ?>themes/enAdmin/">
	<script type="text/javascript">
		<?php
		$fmt = numfmt_create('en_US', NumberFormatter::CURRENCY);
		$formatter = numfmt_create('en_US', NumberFormatter::CURRENCY);
		$currency = setting("currency");
		?>

		var base_url = "<?php echo base_url(); ?>";
		var Currency = "<?= $currency; ?>"
	</script>

	<title>SB Admin 2 - Dashboard</title>

	<!-- Custom fonts for this template-->
	<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

	<!-- Custom styles for this template-->
	<link href="css/sb-admin-2.min.css" rel="stylesheet">
	<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
	<link rel="stylesheet" href="vendor/dropzone/dropzone.css">
	<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.css" rel="stylesheet">
	<link href="css/hobrt.css" rel="stylesheet">
	<?php if (lang('admin_h55') == "rtl") : ?>
		<link href="css/rtl.css" rel="stylesheet">
	<?php endif; ?>
	<link href="css/admin.css?v=<?= filemtime(__DIR__ . "/../css/admin.css") ?>" rel="stylesheet">

	<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

	<?php $this->load->view('enAdmin/inc/csrf'); ?>

</head>

<body id="page-top" dir="<?php echo lang('admin_h55'); ?>" class="<?php echo lang('admin_h55'); ?>">

	<!-- Page Wrapper -->
	<div id="wrapper">

		<!-- Sidebar -->
		<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

			<!-- Sidebar - Brand -->
			<a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo base_url("admin"); ?>">
				<div class="sidebar-brand-icon rotate-n-15">
					<i class="fas fa-laugh-wink"></i>
				</div>
				<div class="sidebar-brand-text mx-3">HB Admin <sup>+</sup></div>
			</a>

			<!-- Divider -->
			<hr class="sidebar-divider my-0">

			<!-- HOME -->
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url("admin"); ?>">
					<i class="fas fa-home"></i>
					<span><?= lang("admin_h109") ?></span></a>
			</li>

			<!-- ORDERS -->
			<li class="nav-item">
				<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
					<i class="fas fa-shopping-cart"></i>
					<span><?php echo lang("admin_h4"); ?></span>
				</a>
				<div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
					<div class="bg-white py-2 collapse-inner rounded">
						<a class="collapse-item" href="<?php echo base_url("admin/orders"); ?>"> <?php echo lang("admin_h5"); ?></a>
						<a class="collapse-item" href="<?php echo base_url("admin/orders/1"); ?>"> <?php echo lang("admin_h6"); ?></a>
						<a class="collapse-item" href="<?php echo base_url("admin/orders/2"); ?>"> <?php echo lang("admin_h7"); ?></a>
						<a class="collapse-item" href="<?php echo base_url("admin/orders/3"); ?>"> <?php echo lang("admin_h8"); ?></a>
						<a class="collapse-item" href="<?php echo base_url("admin/orders/5"); ?>"> <?php echo lang("admin_h9"); ?></a>
						<a class="collapse-item" href="<?php echo base_url("admin/orders/0"); ?>"> <?php echo lang("admin_h10"); ?></a>
					</div>
				</div>
			</li>

			<!-- PRODUCTS -->
			<li class="nav-item">
				<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities2" aria-expanded="true" aria-controls="collapseUtilities">
				<i class="fas fa-box"></i>
					<span><?= lang("admin_h1") ?></span>
				</a>
				<div id="collapseUtilities2" class="collapse" aria-labelledby="headingUtilities" data-parent="#collapseUtilities">
					<div class="bg-white py-2 collapse-inner rounded">
						<a class="collapse-item" href="<?php echo base_url("admin/products"); ?>"> <?= lang("admin_h96") ?></a>
						<a class="collapse-item" href="<?php echo base_url("admin/add_product"); ?>"> <?= lang("admin_h97") ?></a>
					</div>
				</div>
			</li>

			<!-- Landing page -->
			<li class="nav-item">
				<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilitiesLanding" aria-expanded="true" aria-controls="collapseUtilities">
				<i class="fas fa-scroll"></i>
					<span><?= lang("admin_h239") ?></span>
				</a>
				<div id="collapseUtilitiesLanding" class="collapse" aria-labelledby="headingUtilities" data-parent="#collapseUtilities">
					<div class="bg-white py-2 collapse-inner rounded">
						<a class="collapse-item" href="<?php echo base_url("admin/landing_pages"); ?>"> <?= lang("admin_h239") ?></a>
						<a class="collapse-item" href="<?php echo base_url("admin/add_landing_page"); ?>"> <?= lang("admin_h240") ?></a>
					</div>
				</div>
			</li>

			<!-- CATEGORIES -->
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url("admin/cat"); ?>">
					<i class="fas fa-list-alt"></i>
					<span><?= lang("admin_h11") ?></span></a>
			</li>

			<!-- REVIEWS -->
			<li class="nav-item">
				<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
					<i class="fas fa-star"></i>
					<span><?= lang("admin_h28") ?></span>
				</a>
				<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
					<div class="bg-white py-2 collapse-inner rounded">
						<a class="collapse-item" href="<?php echo base_url("admin/reviews?pending=1") ?>"><?= lang("admin_h29") ?></a>
						<a class="collapse-item" href="<?php echo base_url("admin/reviews") ?>"><?= lang("admin_h98") ?></a>
					</div>
				</div>
			</li>

			<!-- DISCOUNTS -->
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url("admin/discounts"); ?>">
					<i class="fas fa-percent"></i>
					<span><?= lang("admin_h108") ?></span></a>
			</li>

			<!-- NEWSLETTER -->
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url("admin/newsletter"); ?>">
					<i class="fas fa-envelope-open-text"></i>
					<span><?= lang("admin_h241") ?></span></a>
			</li>

			<!-- SETTINGS -->
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url("admin/setting"); ?>">
					<i class="fas fa-cog"></i>
					<span><?php echo lang("admin_h19"); ?></span>
				</a>
			</li>

			<!-- PAGES -->
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url("admin/pages"); ?>">
					<i class="fas fa-file"></i>
					<span><?php echo lang("admin_h16"); ?></span>
				</a>
			</li>

			<!-- THEMES -->
			<li class="nav-item">
				<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages_themee" aria-expanded="true" aria-controls="collapsePages">
					<i class="fas fa-paint-brush"></i>
					<span><?= lang("admin_h100") ?></span>
				</a>
				<div id="collapsePages_themee" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
					<div class="bg-white py-2 collapse-inner rounded">
						<a class="collapse-item" href="<?php echo base_url("admin/themes"); ?>"><?= lang("admin_h101") ?></a>
						<a class="collapse-item" href="<?php echo base_url("admin/template_editor"); ?>"><?= lang("admin_h102") ?></a>
						<a class="collapse-item" href="<?php echo base_url("admin/html_codes"); ?>"><?= lang("admin_h103") ?></a>
						<a class="collapse-item" href="<?php echo base_url("admin/slider"); ?>"><?= lang("admin_h104") ?></a>
						<a class="collapse-item" href="<?php echo base_url("admin/collections"); ?>"><?= lang("admin_h105") ?></a>
						<a class="collapse-item" href="<?php echo base_url("admin/promo"); ?>"><?= lang("admin_h106") ?></a>
						<a class="collapse-item" href="<?php echo base_url("admin/badge"); ?>"><?= lang("admin_h107") ?></a>
					</div>
				</div>
			</li>


			<!-- PLUGINS -->
			<li class="nav-item">
				<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages_apps" aria-expanded="true" aria-controls="collapsePages">
					<i class="fas fa-plug"></i>
					<span><?= lang("admin_h110") ?></span>
				</a>
				<div id="collapsePages_apps" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
					<div class="bg-white py-2 collapse-inner rounded">
						<a class="collapse-item" href="<?php echo base_url("admin/gsheets"); ?>">Google Sheet</a>
						<a class="collapse-item" href="<?php echo base_url("admin/sms"); ?>">Hbsms</a>
						<a class="collapse-item" href="<?php echo base_url("admin/ai_settings"); ?>"><?= lang("admin_h258") ?></a>
					</div>
				</div>
			</li>

			<!-- Nav Item - Pages Collapse Menu -->
			<li class="nav-item">
				<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePagesa" aria-expanded="true" aria-controls="collapsePagesa">
					<i class="fas fa-users"></i>
					<span><?php echo lang("admin_h18"); ?></span>
				</a>
				<div id="collapsePagesa" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
					<div class="bg-white py-2 collapse-inner rounded">
						<a class="collapse-item" href="<?php echo base_url("admin/admins"); ?>"><?php echo lang("admin_h22"); ?></a>
						<a class="collapse-item" href="<?php echo base_url("admin/add_admin"); ?>"><?php echo lang("admin_h23"); ?></a>
					</div>
				</div>
			</li>

			<!-- SUPPORT -->
			<li class="nav-item">
				<a class="nav-link" href="<?php echo base_url("admin/support"); ?>">
					<i class="fas fa-life-ring"></i>
					<span><?php echo lang("admin_h17"); ?></span>
				</a>
			</li>


			<!-- Divider -->
			<hr class="sidebar-divider d-none d-md-block">

			<!-- Sidebar Toggler (Sidebar) -->
			<div class="text-center d-none d-md-inline">
				<button class="rounded-circle border-0" id="sidebarToggle"></button>
			</div>

		</ul>
		<!-- End of Sidebar -->