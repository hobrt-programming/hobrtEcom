<?php include_once 'inc/header.php'; ?>

<div id="content-wrapper" class="d-flex flex-column">

	<!-- Main Content -->
	<div id="content">

		<?php include_once 'inc/navbar.php'; ?>

		<div class="container-fluid">

			<?php if ($tp == "add" || $tp == "edit") { ?>
				<!-- Page Heading -->
				<h1 class="h3 mb-2 text-gray-800"><?php echo isset($page) ? lang("admin_h28") . $page->title : lang("admin_h21"); ?> </h1>
				<?php echo form_open("", array("class" => "form-horizontal")); ?>
				<!-- DataTales Example -->
				<div class="card shadow mb-4">

					<div class="card-body">

						<fieldset>

							<div class="form-group">
								<label for="inp1"><?php echo lang("admin_h63") ?> </label>
								<input type="text" name="title" class="form-control" id="inp1" aria-describedby="emailHelp" placeholder="<?php echo lang("admin_h63") ?>" value="<?php if (isset($page)) echo $page->title; ?>">
								<small id="emailHelp" class="form-text text-muted"><?php echo lang("admin_h63") ?> </small>
							</div>

							<div class="form-group">
								<label for="inp4"><?php echo lang("admin_h230") ?></label>
								<!-- <div id="editor"></div> -->

								<textarea id="summernote" name="content"><?php if (isset($page)) echo $page->content; ?></textarea>

								<small id="emailHelp" class="form-text text-muted"><?php echo lang("admin_h230") ?></small>
							</div>

							<div class="form-group">
								<label for="inp4"><?php echo lang("admin_h231") ?></label>
								<!-- <div id="editor"></div> -->

								<select name="header" id="" class="form-control">
									<option value="0">No</option>
									<option value="1" <?php if (isset($page) && $page->header == 1) echo "selected"; ?>>Yes</option>
								</select>

								<small id="emailHelp" class="form-text text-muted"><?php echo lang("admin_h231") ?></small>
							</div>

							<div class="form-group">
								<label for="inp4"><?php echo lang("admin_h232") ?></label>
								<!-- <div id="editor"></div> -->

								<select name="footer" id="" class="form-control">
									<option value="0"><?php echo lang("admin_h66") ?></option>
									<option value="1" <?php if (isset($page) && $page->footer == 1) echo "selected"; ?>><?php echo lang("admin_h65") ?></option>
								</select>

								<small id="emailHelp" class="form-text text-muted"><?php echo lang("admin_h232") ?></small>
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
				<h1 class="h3 mb-2 text-gray-800 my-2"><span class="bg-primary rounded px-2 text-white"><i class="fas fa-bars"></i> <?php echo lang("admin_h16") ?></span></h1>
				</div>

				<!-- DataTales Example -->
				<div class="card shadow mb-4">
					<div class="card-header py-3">
						<h6 class="m-0 font-weight-bold text-primary float-left"><?php echo lang("admin_h218") ?></h6>
						<a href="<?php echo base_url("admin/add_page"); ?>" class="btn btn-success btn-icon-split btn-sm float-right">
							<span class="icon text-white-50">
								<i class="fas fa-plus"></i>
							</span>
							<span class="text"><?php echo lang("admin_h21") ?></span>
						</a>
					</div>
					<div class="card-body">
						<ul id="sortable-list" class="list-group">
							<?php foreach ($pages as $page) { ?>

								<li data-id="<?= $page->id ?>" class="list-group-item border-left-primary d-flex align-items-center mb-2">

									<div style="flex:1 1 auto">
										<span class="d-block"> <?= $page->title; ?></span>
										<span><a href="<?= base_url("page/$page->slug"); ?>" class="mt-1 pl-2 pr-2 small border rounded" target="_blank"><?= base_url("page/$page->slug"); ?></a></span>

									</div>
									<div class="del_wrapper">
										<a href="<?php echo base_url("admin/edit_page/$page->id"); ?>" class="btn btn-primary btn-icon-split btn-sm">
											<span class="icon text-white-50">
												<i class="fas fa-edit"></i>
											</span>
											<span class="text"><?php echo lang("admin_h46") ?></span>
										</a>
										<a href="<?php echo csrf_url("admin/delt/pages/$page->id/pages"); ?>" class="btn btn-danger btn-icon-split btn-sm">
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
					console.log("pages new order", itemOrder);
					$.ajax({
						data: {
							order: itemOrder,
							table: "pages"
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
	<script>
		$(document).ready(function() {

			$('#summernote').summernote();
		});
	</script>