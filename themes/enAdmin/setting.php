<?php include_once 'inc/header.php'; ?>

<div id="content-wrapper" class="d-flex flex-column">

	<!-- Main Content -->
	<div id="content">

		<?php include_once 'inc/navbar.php'; ?>
		<?php echo form_open_multipart("", array("class" => "form-horizontal")); ?>
		<?php foreach ($setting as $key) { ?>
			<div class="container-fluid">
			<div class="my-4">
				<h1 class="h3 mb-2 text-gray-800 my-2"><span class="bg-primary rounded px-2 text-white"><i class="fas fa-cogs"></i> <?php echo lang("admin_h15") ?></span></h1>
				</div>
				<div class="row">
					<div class="col-12 col-md-6">
						<div class="card shadow mb-3">
							<div class="card-header py-3">
								<p class="text-warning m-0 font-weight-bold"><?php echo lang("admin_h19") ?></p>
							</div>
							<div class="card-body">
								<div>
									<div class="form-row">
										<div class="col-12">
											<div class="form-group">
												<label for="title"><strong><?php echo lang("admin_h210") ?></strong></label>
												<input id="title" value="<?php echo $key->title; ?>" class="form-control" type="text" placeholder="<?php echo lang("admin_h210") ?>" name="title" />
											</div>
										</div>
										<div class="col">
											<div class="form-group">
												<label for="descr"><strong><?php echo lang("admin_h211") ?></strong></label>
												<textarea class="form-control" rows="4" name="descr" placeholder="<?php echo lang("admin_h211") ?>"><?php echo $key->descr; ?></textarea>
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col">
											<div class="form-group">
												<label for="logo"><strong><?php echo lang("admin_h212") ?> (150x50)</strong></label>
												<input type="file" accept=".jpg,.png,.gif" name="logo" class="form-control">
											</div>
										</div>
										<div class="col">
											<div class="form-group">
												<label for="color"><strong><?php echo lang("admin_h213") ?></strong></label>
												<input type="color" name="color" class="form-control" value="<?php echo $key->color; ?>">
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col-12">
											<div class="form-group">
												<label for="inp1"><?php echo lang("admin_h214") ?> </label>
												<input type="text" name="header" value="<?php echo $key->header; ?>" class="form-control" placeholder="<?php echo lang("admin_h214") ?>">
												<small class="form-text text-muted"><?php echo lang("admin_h214") ?> </small>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group"><label for="username"><strong><?php echo lang("admin_h215") ?></strong></label>
												<select class="form-control" name="store_lng">
													<option value="english" <?php echo $key->store_lng == "english" ?"selected":""; ?>><?php echo lang("admin_h216") ?></option>
													<option value="arabic" <?php echo $key->store_lng == "arabic" ?"selected":""; ?>><?php echo lang("admin_h217") ?></option>
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="currency"><strong><?php echo lang("admin_h345") ?></strong></label>
												<input type="text" id="currency" name="currency" value="<?php echo html_escape($key->currency); ?>" class="form-control" maxlength="3" pattern="[A-Za-z]{3}" required dir="ltr" placeholder="MAD">
												<small class="form-text text-muted"><?php echo lang("admin_h346") ?></small>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="currency_ar"><strong><?php echo lang("admin_h347") ?></strong></label>
												<input type="text" id="currency_ar" name="currency_ar" value="<?php echo html_escape($key->currency_ar ?? ''); ?>" class="form-control" maxlength="30" dir="rtl" placeholder="درهم">
												<small class="form-text text-muted"><?php echo lang("admin_h348") ?></small>
											</div>
										</div>
									</div>
									<div class="form-group"><button class="btn btn-warning btn-sm" name="test" type="submit"><?php echo lang("admin_h218") ?></button></div>
								</div>
							</div>
						</div>
						<div class="card shadow mb-3">
							<div class="card-header py-3">
								<p class="text-warning m-0 font-weight-bold"><?php echo lang("admin_h219") ?></p>
							</div>
							<div class="card-body">
								<div>
									<div class="form-row">
										<div class="col-12">
											<div class="form-group">
												<label for="inp1"><?php echo lang("admin_h220") ?></label>
												<input type="text" name="teles" value="<?php echo $key->teles; ?>" class="form-control" placeholder="<?php echo lang("admin_h220") ?>">
												<small class="form-text text-muted"><?php echo lang("admin_h220") ?></small>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group">
												<label for="inp1"><?php echo lang("admin_h221") ?> </label>
												<input type="text" name="whs" value="<?php echo $key->whs; ?>" class="form-control" placeholder="<?php echo lang("admin_h221") ?>">
												<small class="form-text text-muted"><?php echo lang("admin_h221") ?> </small>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group">
												<label for="inp1"><?php echo lang("admin_h222") ?> </label>
												<input type="text" name="messangers" value="<?php echo $key->messangers; ?>" class="form-control" placeholder="<?php echo lang("admin_h222") ?>">
												<small class="form-text text-muted"><?php echo lang("admin_h223") ?></small>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group">
												<label for="inp1"><?php echo lang("admin_h224") ?></label>
												<input type="text" name="fb" class="form-control" value="<?php echo $key->fb; ?>">
											</div>
										</div>
										<div class="col-12">
											<div class="form-group">
												<label for="inp1"><?php echo lang("admin_h225") ?> </label>
												<input type="text" name="tw" class="form-control" value="<?php echo $key->tw; ?>">
											</div>
										</div>
										<div class="col-12">
											<div class="form-group">
												<label for="inp1"><?php echo lang("admin_h226") ?> </label>
												<input type="text" name="yt" class="form-control" value="<?php echo $key->yt; ?>">
											</div>
										</div>
										<div class="col-12">
											<div class="form-group">
												<label for="inp1"><?php echo lang("admin_h227") ?> </label>
												<input type="text" name="ig" class="form-control" value="<?php echo $key->ig; ?>">
											</div>
										</div>
									</div>
									<div class="form-group"><button class="btn btn-warning btn-sm" name="test" type="submit"><?php echo lang("admin_h218") ?></button></div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-12 col-md-6">
						<!-- HBSMS -->
						<div class="card shadow mb-3">
							<div class="card-header py-3">
								<p class="text-primary m-0 font-weight-bold">HBSMS <?php echo lang("admin_h15") ?></p>
							</div>
							<div class="card-body">
								<div>
									<div class="form-row">
										<div class="col-12">
											<div class="form-group">
												<label for="inp1">Hbsms Token </label>
												<input type="text" name="hbsms_token" class="form-control" value="<?php echo $key->hbsms_token; ?>">
												<small class="form-text text-muted">Generate one from <a href="https://hbsms.net" target="_blank">Hbsms.net</a> </small>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group">
												<label for="inp1">Hbsms Device id </label>
												<input type="text" name="device_id" class="form-control" value="<?php echo $key->device_id; ?>">
												<small class="form-text text-muted">Get your device id from <a href="https://hbsms.net" target="_blank">Hbsms.net</a> </small>
											</div>
										</div>
									</div>
									<div class="form-group"><button class="btn btn-primary btn-sm" name="test" type="submit"><?php echo lang("admin_h218") ?></button></div>
								</div>
							</div>
						</div>
						<!-- SEO Settings -->
						<div class="card shadow mb-3">
							<div class="card-header py-3">
								<p class="text-primary m-0 font-weight-bold">SEO <?php echo lang("admin_h15") ?></p>
							</div>
							<div class="card-body">
									<div class="form-row">
										<div class="col-12">
											<div class="form-group">
												<label for="inp1">Facebook pixel ids one per line </label>
												<textarea rows="4" name="fbpixel" class="form-control" placeholder="xxxxxxxxxxxxxxxx &#10;xxxxxxxxxxxxxxxx"><?php echo $key->fbpixel; ?></textarea>
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col-12">
											<div class="form-group">
												<label for="inp1">TikTok pixel ids one per line </label>
												<textarea rows="4" name="tiktok_pixel" class="form-control" placeholder="xxxxxxxxxxxxxxxx &#10;xxxxxxxxxxxxxxxx"><?php echo $key->tiktok_pixel; ?></textarea>
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col-12">
											<div class="form-group">
												<label for="inp1">Snapchat pixel ids one per line </label>
												<textarea rows="4" name="snap_pixel" class="form-control" placeholder="xxxxxx-xxxxx-xxxxx &#10;xxxxxx-xxxxx-xxxxx"><?php echo $key->snap_pixel; ?></textarea>
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col-12">
											<div class="form-group">
												<label for="inp1">Google analytics code </label>
												<textarea rows="6" name="googlea" class="form-control"><?php echo $key->googlea; ?></textarea>
												<small class="form-text text-muted">Google analytics code </small>
											</div>
										</div>
									</div>
									<div class="form-group"><button class="btn btn-primary btn-sm" name="test" type="submit"><?php echo lang("admin_h218") ?></button></div>
							</div>
						</div>
					</div>
					<!-- end row -->
				</div>
			</div>
			<!-- /.container-fluid -->

		<?php } ?>
		<?php echo form_close(); ?>

		<!-- secret admin address: a separate form, it saves to admin/admin_path -->
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 col-md-6">
					<div class="card shadow mb-4" id="admin-address">
						<div class="card-header py-3">
							<p class="m-0 font-weight-bold"><i class="fas fa-user-secret"></i> <?= lang("admin_h305") ?></p>
						</div>
						<div class="card-body">
							<?php if ($this->session->flashdata('admin_path_saved')): ?>
								<div class="alert alert-success py-2"><?= lang("admin_h251") ?></div>
							<?php elseif ($this->session->flashdata('admin_path_error')): ?>
								<div class="alert alert-danger py-2"><?= lang("admin_h309") ?></div>
							<?php endif; ?>

							<p class="small text-muted"><?= lang("admin_h306") ?></p>

							<?php echo form_open("admin/admin_path"); ?>
								<div class="input-group mb-2" dir="ltr">
									<div class="input-group-prepend"><span class="input-group-text"><?= html_escape(rtrim(base_url(), '/')) ?>/</span></div>
									<input type="text" class="form-control" name="admin_path" id="admin_path" value="<?= html_escape(admin_path()) ?>" maxlength="64" pattern="[a-z0-9][a-z0-9-]{6,62}[a-z0-9]" autocomplete="off" spellcheck="false">
									<div class="input-group-append"><button type="button" class="btn btn-outline-secondary" id="admin_path_gen"><?= lang("admin_h310") ?></button></div>
								</div>
								<small class="form-text text-muted mb-3"><?= lang("admin_h309") ?></small>
								<button type="submit" class="btn btn-primary btn-sm"><?= lang("admin_h250") ?></button>
							<?php echo form_close(); ?>

							<?php if (admin_path() !== ''): ?>
								<div class="alert alert-info mt-3 mb-0">
									<?= lang("admin_h307") ?>:<br>
									<a href="<?= html_escape(base_url(admin_path())) ?>" dir="ltr"><strong><?= html_escape(base_url(admin_path())) ?></strong></a><br>
									<small><?= lang("admin_h308") ?></small>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<?php include_once 'inc/footer.php'; ?>

<script>
	// a random, hard to guess address
	$('#admin_path_gen').on('click', function () {
		var words = ['office', 'desk', 'panel', 'studio', 'manage'], bytes = new Uint8Array(5);
		crypto.getRandomValues(bytes);
		var hex = Array.prototype.map.call(bytes, function (b) { return ('0' + b.toString(16)).slice(-2); }).join('');
		$('#admin_path').val(words[bytes[0] % words.length] + '-' + hex);
	});
</script>
