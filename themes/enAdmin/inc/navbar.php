<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

	<!-- Sidebar Toggle (Topbar) -->
	<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
		<i class="fa fa-bars"></i>
	</button>

	<form class="form-inline" method="post" action="<?= base_url("admin/admin_lang_setting") ?>">
		<div class="form-group mx-sm-3 mb-2">
			<label for="languageSelect" class="d-none d-md-block mr-1"><span class="badge badge-light my-1"><?= lang("admin_h93") ?></span></label>
			<select class="form-control" id="languageSelect" name="admin_lng" onchange="this.form.submit()">
				<option value="english" <?php echo setting('admin_lng') == "english" ? "selected" : ""; ?>>English</option>
				<option value="arabic" <?php echo setting('admin_lng') == "arabic" ? "selected" : ""; ?>>العربية</option>
			</select>
		</div>
	</form>
	<!-- Topbar Navbar -->
	<ul class="navbar-nav ml-auto">

		<!-- Nav Item - Search Dropdown (Visible Only XS) -->
		<li class="nav-item dropdown no-arrow d-sm-none">
			<a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fas fa-search fa-fw"></i>
			</a>
			<!-- Dropdown - Messages -->
			<div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
				<form class="form-inline mr-auto w-100 navbar-search" style="position: relative;">
					<div class="input-group">
						<input type="text" class="form-control bg-light border-0 small searchTopMobile" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
						<div class="input-group-append">
							<button class="btn btn-primary" type="button">
								<i class="fas fa-search fa-sm"></i>
							</button>
						</div>
					</div>

					<div class="list-group dropStyle">


					</div>



				</form>
			</div>
		</li>

		<div class="topbar-divider d-none d-sm-block"></div>

		<!-- Nav Item - User Information -->
		<li class="nav-item dropdown no-arrow">
			<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo get_info("admins", is_login("admin_login"), "username"); ?></span>
				<img class="img-profile rounded-circle" src="<?php echo get_gravatar(get_info("admins", is_login("admin_login"), "email"), 60) ?>">
			</a>
			<!-- Dropdown - User Information -->
			<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
				<a class="dropdown-item" href="<?php echo base_url("/"); ?>" target="_blank">
					<i class="fas fa-globe fa-sm fa-fw mr-2 text-gray-400"></i>
					<?= lang("admin_h94") ?>
				</a>
				<a class="dropdown-item" href="<?php echo base_url("user/logout"); ?>" data-toggle="modal" data-target="#logoutModal">
					<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
					<?= lang("admin_h111") ?>
				</a>
			</div>
		</li>

	</ul>

</nav>
<!-- End of Topbar -->
<?php if (db_upgrade_pending() && $this->router->method !== 'upgrade'): ?>
<div class="container-fluid">
	<div class="alert alert-warning d-flex justify-content-between align-items-center">
		<span><i class="fas fa-database"></i> The database needs an update for this version of hobrtEcom.</span>
		<a class="btn btn-sm btn-warning" href="<?php echo base_url("admin/upgrade"); ?>">Update now</a>
	</div>
</div>
<?php endif; ?>
