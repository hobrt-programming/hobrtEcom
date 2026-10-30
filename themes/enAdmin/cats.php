<?php include_once 'inc/header.php'; ?>

<div id="content-wrapper" class="d-flex flex-column">

	<!-- Main Content -->
	<div id="content">

		<?php include_once 'inc/navbar.php'; ?>

			<div class="container-fluid">

				<?php if($tp == "add") { ?>

					
					<!-- Page Heading -->
					<div class="my-4">
				<h1 class="h3 mb-2 text-800"><span class="bg-primary rounded px-1 text-light"><i class="fa fa-cart-arrow-down"></i> <?php echo lang("admin_h114"); ?></span></h1>
				</div>
					<?php echo form_open_multipart("",array("class" => "form-horizontal")); ?>
					<!-- DataTales Example -->
					<div class="card shadow mb-4">
						<div class="card-header py-3">
							<h6 class="m-0 font-weight-bold text-primary"><?php echo lang("admin_h115"); ?></h6>
						</div>
						
						<div class="card-body">

							<?php if(isset($msg)){ ?>
								<div class="alert alert-success"><?php echo lang("admin_h51"); ?></div>
							<?php } ?>
							
							<fieldset>

								
								<div class="form-group">
									<label for="inp1"><?php echo lang("admin_h31") ?></label>
									<input type="text" name="title" class="form-control" id="inp1" aria-describedby="emailHelp" placeholder="<?php echo lang("admin_h49") ?>">
									<small id="emailHelp" class="form-text text-muted"><?php echo lang("admin_h50") ?></small>
								</div>


								<div class="form-group">
									<label for="inp1">Image </label>
									<input type="file" name="img" class="form-control-file">
									<small id="emailHelp" class="form-text text-muted">This is needed only in some of the themes .</small>
								</div>

							

							</fieldset>

						</div>
						
						<div class="card-footer">
							
							<div class="float-right">
								
								<button class="button btn btn-success" name="test" type="submit">Add</button>

							</div>

						</div>

						

					</div>

					<?php echo form_close(); ?>
					

				<?php }elseif($tp == "edit") { ?>
					<?php foreach($cat as $key){ ?>
						<!-- Page Heading -->
						<h1 class="h3 mb-2 text-gray-800"><?php echo lang("admin_h114"); ?></h1>

						<?php echo form_open_multipart("",array("class" => "form-horizontal")); ?>
						<!-- DataTales Example -->
						<div class="card shadow mb-4">
							<div class="card-header py-3">
								<h6 class="m-0 font-weight-bold text-primary">Edit category <?=$key->title;?></h6>
							</div>
							
							<div class="card-body">

								<?php if(isset($msg)){ ?>
									<div class="alert alert-success"><?php echo lang("admin_h51"); ?></div>
								<?php } ?>
								
								<fieldset>

									
									<div class="form-group">
										<label for="inp1"><?php echo lang("admin_h31") ?></label>
										<input type="text" name="title" class="form-control" id="inp1" aria-describedby="emailHelp" placeholder="<?php echo lang("admin_h49") ?>" value="<?php echo $key->title; ?>">
										<small id="emailHelp" class="form-text text-muted"><?php echo lang("admin_h50") ?></small>
									</div>


									<div class="form-group">
										<label for="inp1">Image </label>
										<input type="file" name="img" class="form-control-file">
										<small id="emailHelp" class="form-text text-muted">This is needed only in some of the themes .</small>
									</div>

								

								</fieldset>

							</div>
							
							<div class="card-footer">
								
								<div class="float-right">
									
									<button class="button btn btn-success" name="test" type="submit">Update</button>

								</div>

							</div>

							

						</div>

						<?php echo form_close(); ?>

					<?php } ?>

				<?php }else { ?>

					<!-- Page Heading -->
					<div class="my-4">
				<h1 class="h3 mb-2 text-800"><span class="bg-primary rounded px-1 text-light"><i class="fas fa-table"></i> <?php echo lang("admin_h114"); ?></span></h1>
				</div>

					<!-- DataTales Example -->
					<div class="card shadow mb-4">
						<div class="card-header py-3">
							<h6 class="m-0 font-weight-bold text-primary float-left"><?php echo lang("admin_h116"); ?></h6>
							<a href="<?php echo base_url("admin/add_cat"); ?>" class="btn btn-success btn-icon-split btn-sm float-right">
								<span class="icon text-white-50">
									<i class="fas fa-plus"></i>
								</span>
								<span class="text"><?php echo lang("admin_h13") ?></span>
							</a>
						</div>
						<div class="card-body">
							
							<ul id="sortable-list" class="list-group">
								<?php foreach($cat as $key) {  ?>

									<li  data-id="<?= $key->id ?>" class="list-group-item border-left-primary" style="margin-bottom: 10px;">
										<span> <img class="rounded-circle" src="<?= $key->img !== null && $key->img != "" ? base_url("images/$key->img") : "img/no_image.jpg" ?>" height="50" width="50"> <?php echo $key->title; ?></span>
										<div class="del_wrapper" style="float: right;">



											<a href="<?php echo base_url("admin/edit_cat/$key->id"); ?>" class="btn btn-primary btn-icon-split btn-sm">
												<span class="icon text-white-50">
													<i class="fas fa-edit"></i>
												</span>
												<span class="text"><?php echo lang("admin_h46") ?></span>
											</a>

											<a href="<?php echo csrf_url("admin/delt/cats/$key->id/cat"); ?>" class="btn btn-danger btn-icon-split btn-sm">
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
						<div class="card-footer">
							
							<div class="float-right">
								
								<button class="button btn btn-success"><?php echo lang("admin_h48") ?></button>

							</div>

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
				console.log("categories new order", itemOrder);
				$.ajax({
					data: {
						order: itemOrder,
						table: "cats"
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