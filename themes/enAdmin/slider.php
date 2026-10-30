<?php include_once 'inc/header.php'; ?>

<div id="content-wrapper" class="d-flex flex-column">

	<!-- Main Content -->
	<div id="content">

		<?php include_once 'inc/navbar.php'; ?>

		<div class="container-fluid">
			<?php if ($tp == "add") { ?>
				<!-- Page Heading -->
				<div class="my-4">
				<h1 class="h3 mb-2 text-gray-800 my-2"><span class="bg-primary rounded px-2 text-white"><i class="fas fa-plus"></i> <?php echo lang("admin_h142") ?></span></h1>
				</div>
				<?php echo form_open_multipart("", array("class" => "form-horizontal")); ?>
				<!-- DataTales Example -->
				<div class="card shadow mb-4">

					<div class="card-body">

						<?php if (isset($msg)) { ?>
							<div class="alert alert-success"><?php echo lang("admin_h150") ?></div>
						<?php } ?>

						<fieldset>


							<div class="form-group">
								<label for="inp1"><?php echo lang("admin_h143") ?> </label>
								<input type="text" name="title" class="form-control" id="inp1" aria-describedby="emailHelp" placeholder="<?php echo lang("admin_h143") ?>">
							</div>

							<div class="form-group">
								<label for="inp1"><?php echo lang("admin_h144") ?> </label>
								<input type="text" name="Subtitle" class="form-control" id="inp1" aria-describedby="emailHelp" placeholder="<?php echo lang("admin_h144") ?>">
							</div>

							<div class="form-group">
								<label for="inp1"><?php echo lang("admin_h145") ?> </label>
								<input type="text" name="info" class="form-control" id="inp1" aria-describedby="emailHelp" placeholder="<?php echo lang("admin_h145") ?>">
							</div>

							<div class="form-group">
								<label for="inp1"><?php echo lang("admin_h146") ?> </label>
								<input type="text" name="link" class="form-control" id="inp1" aria-describedby="emailHelp" placeholder="<?php echo lang("admin_h146") ?>">
							</div>


							<div class="form-group">
								<label for="inp1"> <?php echo lang("admin_h147") ?> (500x500)</label>
								<input type="file" accept=".jpg,.png,.gif" name="img" class="form-control" id="inp1" aria-describedby="emailHelp">
							</div>



						</fieldset>

					</div>

					<div class="card-footer">

						<div class="float-right">

							<button class="button btn btn-success" name="test" type="submit"><?php echo lang("admin_h148") ?></button>

						</div>

					</div>



				</div>

				<?php echo form_close(); ?>

			<?php } elseif($tp == "edit") { ?>
				<!-- Page Heading -->
				<div class="my-4">
				<h1 class="h3 mb-2 text-gray-800 my-2"><span class="bg-primary rounded px-2 text-white"><i class="fas fa-retweet"></i> <?php echo lang("admin_h149") ?></span></h1>
				</div>
				<?php echo form_open_multipart("", array("class" => "form-horizontal")); ?>
				<!-- DataTales Example -->
				<div class="card shadow mb-4">

					<div class="card-body">

						<?php if (isset($msg)) { ?>
							<div class="alert alert-success"><?php echo lang("admin_h150") ?> </div>
						<?php } ?>

						<fieldset>


							<div class="form-group">
								<label for="inp1"><?php echo lang("admin_h143") ?> </label>
								<input type="text" name="title" value="<?= $slider->title ?>" class="form-control" id="inp1" aria-describedby="emailHelp" placeholder="<?php echo lang("admin_h143") ?>">
							</div>

							<div class="form-group">
								<label for="inp1"><?php echo lang("admin_h144") ?> </label>
								<input type="text" name="Subtitle" value="<?= $slider->subtitle ?>" class="form-control" id="inp1" aria-describedby="emailHelp" placeholder="<?php echo lang("admin_h144") ?>">
							</div>

							<div class="form-group">
								<label for="inp1"><?php echo lang("admin_h145") ?> </label>
								<input type="text" name="info" value="<?= $slider->info ?>" class="form-control" id="inp1" aria-describedby="emailHelp" placeholder="<?php echo lang("admin_h145") ?>">
							</div>

							<div class="form-group">
								<label for="inp1"><?php echo lang("admin_h146") ?> </label>
								<input type="text" name="link" value="<?= $slider->link ?>" class="form-control" id="inp1" aria-describedby="emailHelp" placeholder="<?php echo lang("admin_h146") ?>">
							</div>


							<div class="form-group">
								<label for="inp1"> <?php echo lang("admin_h147") ?> (500x500)</label>
								<input type="file" accept=".jpg,.png,.gif" name="img" class="form-control" id="inp1" aria-describedby="emailHelp">
							</div>



						</fieldset>

					</div>

					<div class="card-footer">

						<div class="float-right">

							<button class="button btn btn-success" name="test" type="submit"><?php echo lang("admin_h151") ?></button>

						</div>

					</div>



				</div>

				<?php echo form_close(); ?>

			<?php } else { ?>

				<!-- Page Heading -->
				<div class="my-4">
				<h1 class="h3 mb-2 text-gray-800 my-2"><span class="bg-primary rounded px-2 text-white"><i class="fas fa-th-large"></i> <?php echo lang("admin_h104") ?></span></h1>
				</div>

				<!-- DataTales Example -->
				<div class="card shadow mb-4">
					<div class="card-header py-3">
						<h6 class="m-0 font-weight-bold text-primary float-left"><?php echo lang("admin_h141") ?></h6>
						<a href="<?php echo base_url("admin/add_slider"); ?>" class="btn btn-success btn-icon-split btn-sm float-right">
							<span class="icon text-white-50">
								<i class="fas fa-plus"></i>
							</span>
							<span class="text"><?php echo lang("admin_h142") ?> </span>
						</a>
					</div>
					<div class="card-body">

						<ul id="sortable-list" class="list-group">
							<?php foreach ($sliders as $key) { ?>

								<li data-id="<?= $key->id ?>" class="list-group-item border-left-primary d-flex align-items-center mb-2">
									<img src="<?php echo base_url("images/$key->img"); ?>" width="100" class="mr-1">

									<div style="flex:1 1 auto">
										<span class="d-block"> <?= $key->title; ?></span>
										<span class="d-block"> <?= $key->subtitle; ?></span>
										<span class="d-block"> <?= $key->info; ?></span>
										<span class="d-block"> <?= $key->link; ?></span>
									</div>
									<div class="del_wrapper">
										<a href="<?php echo base_url("admin/edit_slider/$key->id"); ?>" class="btn btn-primary btn-icon-split btn-sm">
											<span class="icon text-white-50">
												<i class="fas fa-edit"></i>
											</span>
											<span class="text"><?php echo lang("admin_h46") ?></span>
										</a>
										<a href="<?php echo csrf_url("admin/delt/slider/$key->id/slider"); ?>" class="btn btn-danger btn-icon-split btn-sm">
											<span class="icon text-white-50">
												<i class="fas fa-trash"></i>
											</span>
											<span class="text"><?php echo lang("admin_h47") ?></span>
										</a>
									</div>
									<div class="clearfix"></div>
								</li>

							<?php } ?>
						</ul>

					</div>
				</div>
			<?php } ?>
		</div>
		<!-- /.container-fluid -->


	</div>


	<?php include_once 'inc/footer.php'; ?>


	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	<script>
		$(document).ready(function() {
			$("#sortable-list").sortable({
				update: function(event, ui) {
					var itemOrder = [];
					$("#sortable-list li").each(function() {
						itemOrder.push($(this).data("id"));
					});
					$.ajax({
						data: {
							order: itemOrder,
							table: "slider"
						},
						type: 'POST',
						url: '<?php echo base_url("admin/order_save"); ?>',
						success: function(res) {
							toastr.success("Order saved!");
						}
					});
				}
			});
			$("#sortable-list").disableSelection();
		});
	</script>