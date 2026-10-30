<?php include_once 'inc/header.php'; ?>

<div id="content-wrapper" class="d-flex flex-column">

	<!-- Main Content -->
	<div id="content">

		<?php include_once 'inc/navbar.php'; ?>

			<div class="container-fluid">

				<?php if($tp == "add") { ?>

					<!-- Page Heading -->
					<div class="my-4">
				<h1 class="h3 mb-2 text-800"><span class="bg-primary rounded px-1 text-light"><i class="far fa-gem"></i> <?php echo lang("admin_h173") ?></span></h1>
				</div>
					<?php echo form_open_multipart("",array("class" => "form-horizontal")); ?>
					<!-- DataTales Example -->
					<div class="card shadow mb-4">
						<div class="card-header py-3">
							<h6 class="m-0 font-weight-bold text-primary"><?php echo lang("admin_h174") ?></h6>
						</div>
						
						<div class="card-body">

							<?php if(isset($msg)){ ?>
								<div class="alert alert-success"><?php echo lang("admin_h175") ?></div>
							<?php } ?>
							
							<fieldset>

								
								<div class="form-group">
									<label for="inp1"><?php echo lang("admin_h143") ?></label>
									<input type="text" name="title" class="form-control" placeholder="<?php echo lang("admin_h143") ?>">
								</div>

								<div class="form-group">
									<label for="inp1"><?php echo lang("admin_h144") ?></label>
									<input type="text" name="subtitle" class="form-control" placeholder="<?php echo lang("admin_h44") ?>">
								</div>

								<div class="form-group">
									<label for="inp1"><?php echo lang("admin_h146") ?></label>
									<input type="text" name="link" class="form-control" placeholder="<?php echo lang("admin_h146") ?>">
								</div>

								<div class="form-group">
									<label for="inp1"><?php echo lang("admin_h147") ?> </label>
									<input type="file" name="img" class="form-control-file">
								</div>

								<div class="form-group">
									<label for="inp1"><?php echo lang("admin_h180") ?> </label>
									
									<select class="form-control" name="tp">
										
										<option value="1"><?php echo lang("admin_h181") ?></option>
										<option value="2"><?php echo lang("admin_h176") ?></option>

									</select>

								</div>


							

							</fieldset>

						</div>
						
						<div class="card-footer">
							
							<div class="float-right">
								
								<button class="button btn btn-success" name="test" type="submit"><?php echo lang("admin_h182") ?></button>

							</div>

						</div>

						

					</div>

					<?php echo form_close(); ?>
					

				<?php }elseif($tp == "edit") { ?>
					<?php foreach($cat as $key){ ?>
						<!-- Page Heading -->
						<div class="my-4">
				<h1 class="h3 mb-2 text-800"><span class="bg-primary rounded px-1 text-light"><i class="far fa-gem"></i> <?php echo lang("admin_h173") ?></span></h1>
				</div>

						<?php echo form_open_multipart("",array("class" => "form-horizontal")); ?>
						<!-- DataTales Example -->
						<div class="card shadow mb-4">
							<div class="card-header py-3">
								<h6 class="m-0 font-weight-bold text-primary"><?php echo lang("admin_h177") ?> <?=$key->title;?></h6>
							</div>
							
							<div class="card-body">

								<?php if(isset($msg)){ ?>
									<div class="alert alert-success"><?php echo lang("admin_h178") ?></div>
								<?php } ?>
								
								<fieldset>

									
									<div class="form-group">
										<label for="inp1"><?php echo lang("admin_h143") ?></label>
										<input type="text" name="title" class="form-control" placeholder="<?php echo lang("admin_h143") ?>" value="<?php echo $key->title; ?>">
										<small id="emailHelp" class="form-text text-muted"><?php echo lang("admin_h50") ?></small>
									</div>


									<div class="form-group">
										<label for="inp1"><?php echo lang("admin_h144") ?></label>
										<input type="text" name="subtitle" class="form-control" placeholder="<?php echo lang("admin_h144") ?>" value="<?php echo $key->subtitle; ?>">
									</div>

									<div class="form-group">
										<label for="inp1"><?php echo lang("admin_h146") ?></label>
										<input type="text" name="link" class="form-control" placeholder="<?php echo lang("admin_h146") ?>" value="<?php echo $key->link; ?>">
									</div>

									<div class="form-group">
										<label for="inp1"><?php echo lang("admin_h147") ?> </label>
										<input type="file" name="img" class="form-control-file">
									</div>

									<div class="form-group">
										<label for="inp1"><?php echo lang("admin_h180") ?> </label>
										
										<select class="form-control" name="tp">
											
											<option value="1"><?php echo lang("admin_h181") ?></option>
											<option value="2" <?php if($key->tp == 2) echo "selected"; ?>><?php echo lang("admin_h176") ?></option>

										</select>

									</div>


								</fieldset>

							</div>
							
							<div class="card-footer">
								
								<div class="float-right">
									
									<button class="button btn btn-success" name="test" type="submit"><?php echo lang("admin_h183") ?></button>

								</div>

							</div>

							

						</div>

						<?php echo form_close(); ?>

					<?php } ?>

				<?php }else { ?>

					<!-- Page Heading -->
					<div class="my-4">
				<h1 class="h3 mb-2 text-800"><span class="bg-primary rounded px-1 text-light"><i class="far fa-gem"></i> <?php echo lang("admin_h173") ?></span></h1>
				</div>

					<!-- DataTales Example -->
					<div class="card shadow mb-4">
						<div class="card-header py-3">
							<h6 class="m-0 font-weight-bold text-primary float-left"><?php echo lang("admin_h179") ?></h6>
							<a href="<?php echo base_url("admin/add_promo"); ?>" class="btn btn-success btn-icon-split btn-sm float-right">
								<span class="icon text-white-50">
									<i class="fas fa-plus"></i>
								</span>
								<span class="text"><?php echo lang("admin_h174") ?> </span>
							</a>
						</div>
						<div class="card-body">
							
							<ul id="responds" class="list-group">
								<?php foreach($cat as $key) { $idcat = $key->id; ?>

									<li id="promo_<?php echo $idcat; ?>" class="list-group-item border-left-primary" style="margin-bottom: 10px;">
										<span> <img src="<?php echo base_url("images/$key->img"); ?>" width="50"> <?php echo $key->title; ?></span>
										<div class="del_wrapper" style="float: right;">



											<a href="<?php echo base_url("admin/edit_promo/$key->id"); ?>" class="btn btn-primary btn-icon-split btn-sm">
												<span class="icon text-white-50">
													<i class="fas fa-edit"></i>
												</span>
												<span class="text"><?php echo lang("admin_h46") ?></span>
											</a>

											<a href="<?php echo csrf_url("admin/delt/promo/$key->id/promo"); ?>" class="btn btn-danger btn-icon-split btn-sm">
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


	$(function () {
		$("#responds").sortable({
			update: function (event, ui) {
				var order = $(this).sortable('serialize');
            $(document).on("click", ".button", function () { //that doesn't work
            	$.ajax({
            		data: order,
            		type: 'POST',
            		url: '<?php echo base_url("admin/order_save"); ?>',
            		success : function(re) {
                      //alert(re);
                      if(re == "")
                      {
                      	alert("order saved .");
                      }else
                      {
                      	alert(re);
                      }
                  }
              });
            });
        }
    }).disableSelection();
		$('.button').on('click', function () {
			var r = $("#responds").sortable("toArray");
			var a = $("#responds").sortable("serialize", {
				attribute: "id"
			});
			console.log(r, a);
		});
	});

</script>