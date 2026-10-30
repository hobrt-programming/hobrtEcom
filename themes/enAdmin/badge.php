<?php include_once 'inc/header.php'; ?>

<div id="content-wrapper" class="d-flex flex-column">

	<!-- Main Content -->
	<div id="content">

		<?php include_once 'inc/navbar.php'; ?>

		<div class="container-fluid">

			<?php if ($tp == "add" || $tp == "edit") { ?>

				<!-- Page Heading -->
				<h1 class="h3 mb-2 text-gray-800"><?= isset($badge)? lang("admin_h46") .$badge->title:lang("admin_h186") ?></h1>

				<?php echo form_open_multipart("", array("class" => "form-horizontal")); ?>
				<!-- DataTales Example -->
				<div class="card shadow mb-4">

					<div class="card-body">

						<fieldset>


							<div class="form-group">
								<label for="inp1"><?php echo lang("admin_h143") ?></label>
								<input type="text" name="title" class="form-control" placeholder="<?php echo lang("admin_h143") ?>" value="<?= isset($badge)?$badge->title:"" ?>">
							</div>

							<div class="form-group">
								<label for="inp1"><?php echo lang("admin_h144") ?></label>
								<input type="text" name="subtitle" class="form-control" placeholder="<?php echo lang("admin_h144") ?>" value="<?= isset($badge)?$badge->subtitle:"" ?>">
							</div>

							<div class="form-group">
								<label for="inp1"><?php echo lang("admin_h147") ?> (100x100)</label>
								<input type="file" name="img" class="form-control-file">
							</div>

						</fieldset>

					</div>

					<div class="card-footer">

						<div class="float-right">

							<button class="button btn btn-success" name="test" type="submit"><?php echo lang("admin_h160") ?></button>

						</div>

					</div>
				</div>

				<?php echo form_close(); ?>

			<?php } else { ?>

				<!-- Page Heading -->
				<div class="my-4">
				<h1 class="h3 mb-2 text-800"><span class="bg-primary rounded px-1 text-light"><i class="far fa-newspaper"></i> <?php echo lang("admin_h184") ?></span></h1>
				</div>

				<!-- DataTales Example -->
				<div class="card shadow mb-4">
					<div class="card-header py-3">
						<h6 class="m-0 font-weight-bold text-primary float-left"><?php echo lang("admin_h185") ?></h6>
						<a href="<?php echo base_url("admin/add_badge"); ?>" class="btn btn-success btn-icon-split btn-sm float-right">
							<span class="icon text-white-50">
								<i class="fas fa-plus"></i>
							</span>
							<span class="text"><?php echo lang("admin_h186") ?> </span>
						</a>
					</div>
					<div class="card-body">

						<ul id="sortable-list" class="list-group">
							<?php foreach ($badges as $key) { ?>

								<li data-id="<?= $key->id ?>" class="list-group-item border-left-primary d-flex align-items-center mb-2">
									<img class="mr-2" src="<?= $key->img!==null && $key->img != ""? base_url("images/$key->img"):"img/no_image.jpg" ?>" height="50" width="50">

									<div style="flex:1 1 auto">
										<span class="d-block"> <?= $key->title; ?></span>
										<span class="d-block"> <?= $key->subtitle; ?></span>
									</div>
									<div class="del_wrapper">
										<a href="<?php echo base_url("admin/edit_badge/$key->id"); ?>" class="btn btn-primary btn-icon-split btn-sm">
											<span class="icon text-white-50">
												<i class="fas fa-edit"></i>
											</span>
											<span class="text"><?php echo lang("admin_h46") ?></span>
										</a>
										<a href="<?php echo csrf_url("admin/delt/badges/$key->id/badges"); ?>" class="btn btn-danger btn-icon-split btn-sm">
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
					console.log("badges new order", itemOrder);
					$.ajax({
						data: {
							order: itemOrder,
							table: "badges"
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