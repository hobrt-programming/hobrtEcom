<?php include_once 'inc/header.php'; ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.16/css/bootstrap-multiselect.min.css" integrity="sha512-wHTuOcR1pyFeyXVkwg3fhfK46QulKXkLq1kxcEEpjnAPv63B/R49bBqkJHLvoGFq6lvAEKlln2rE1JfIPeQ+iw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
	
	.multiselect-native-select, .multiselect-native-select .btn-group {
		display: block !important;
		width: 100%;
		text-align: right;
	}

</style>

<div id="content-wrapper" class="d-flex flex-column">

	<!-- Main Content -->
	<div id="content">

		<?php include_once 'inc/navbar.php'; ?>

			<div class="container-fluid">

				<?php if($tp == "add") { ?>

					<!-- Page Heading -->
					<div class="my-4">
				<h1 class="h3 mb-2 text-gray-800 my-2"><span class="bg-primary rounded px-2 text-white"><i class="fas fa-code"></i> <?php echo lang("admin_h152") ?></span></h1>
				</div>

					<?php echo form_open_multipart("",array("class" => "form-horizontal")); ?>
					<!-- DataTales Example -->
					<div class="card shadow mb-4">
						<div class="card-header py-3">
							<h6 class="m-0 font-weight-bold text-primary"><?php echo lang("admin_h153") ?></h6>
						</div>
						
						<div class="card-body">

							<?php if(isset($msg)){ ?>
								<div class="alert alert-success"><?php echo lang("admin_h51"); ?></div>
							<?php } ?>
							
							<fieldset>

								
								<div class="form-group">
									<label for="inp1"><?php echo lang("admin_h154") ?></label>
									<input type="text" name="name" class="form-control" id="inp1" aria-describedby="emailHelp" placeholder="<?php echo lang("admin_h154") ?>">
								</div>

								
								<div class="form-group">
									<label for="inp1"><?php echo lang("admin_h155") ?></label>
									<textarea name="content" class="form-control"></textarea>
								</div>
							

								<div class="form-group">
									<label for="inp4"><?php echo lang("admin_h16") ?></label>
									<!-- <div id="editor"></div> -->

									<select name="pages[]" id="" class="form-control multiselect" multiple>
										<?php foreach(pages_codes() as $kp => $page) : ?>
											<option value="<?php echo $kp; ?>"><?php echo $page; ?></option>
										<?php endforeach; ?>
									</select>
								</div>



								<div class="form-group">
									<label for="inp4"><?php echo lang("admin_h156") ?></label>
									<!-- <div id="editor"></div> -->

									<select name="active" id="" class="form-control">
										<option value="1"><?php echo lang("admin_h65") ?></option>
										<option value="0"><?php echo lang("admin_h66") ?></option>
									</select>
								</div>

							</fieldset>

						</div>
						
						<div class="card-footer">
							
							<div class="float-right">
								
								<button class="button btn btn-success" name="test" type="submit"><?php echo lang("admin_h48") ?></button>

							</div>

						</div>

						

					</div>

					<?php echo form_close(); ?>
					

				<?php }elseif($tp == "edit") { ?>
					<?php foreach($cat as $key){ ?>
						<!-- Page Heading -->
						<h1 class="h3 mb-2 text-gray-800"><?php echo lang("admin_h157") ?></h1>

						<?php echo form_open_multipart("",array("class" => "form-horizontal")); ?>
						<!-- DataTales Example -->
						<div class="card shadow mb-4">
							<div class="card-header py-3">
								<h6 class="m-0 font-weight-bold text-primary"><?php echo lang("admin_h158") ?> <?=$key->name;?></h6>
							</div>
							
							<div class="card-body">

								<?php if(isset($msg)){ ?>
									<div class="alert alert-success"><?php echo lang("admin_h51"); ?></div>
								<?php } ?>
								
								<fieldset>

										<div class="form-group">
											<label for="inp1"><?php echo lang("admin_h31") ?></label>
											<input type="text" name="name" class="form-control" id="inp1" aria-describedby="emailHelp" placeholder="<?php echo lang("admin_h49") ?>" value="<?php echo $key->name; ?>">
										</div>

										
										<div class="form-group">
											<label for="inp1"><?php echo lang("admin_h155") ?></label>
											<textarea name="content" class="form-control"><?php echo $key->content; ?></textarea>
										</div>
									

										<div class="form-group">
											<label for="inp4"><?php echo lang("admin_h16") ?></label>
											<!-- <div id="editor"></div> -->

											<select name="pages[]" id="" class="form-control multiselect" multiple>
												<?php

												$pgs = explode(',', $key->pages);

												?>

												<?php foreach(pages_codes() as $kp => $page) : ?>
													<option value="<?php echo $kp; ?>" <?php if(in_array($kp, $pgs)) echo "selected"; ?>><?php echo $page; ?></option>
												<?php endforeach; ?>
											</select>
										</div>



										<div class="form-group">
											<label for="inp4"><?php echo lang("admin_h156") ?></label>
											<!-- <div id="editor"></div> -->

											<select name="active" id="" class="form-control">
												<option value="1"><?php echo lang("admin_h65") ?></option>
												<option value="0" <?php if($key->active == 0) echo "selected"; ?>><?php echo lang("admin_h66") ?></option>
											</select>
										</div>

									
									

								</fieldset>

							</div>
							
							<div class="card-footer">
								
								<div class="float-right">
									
									<button class="button btn btn-success" name="test" type="submit"><?php echo lang("admin_h48") ?></button>

								</div>

							</div>

							

						</div>

						<?php echo form_close(); ?>

					<?php } ?>

				<?php }else { ?>

					<!-- Page Heading -->
					<div class="my-4">
				<h1 class="h3 mb-2 text-gray-800 my-2"><span class="bg-primary rounded px-2 text-white"><i class="fas fa-code"></i> <?php echo lang("admin_h157") ?></span></h1>
				</div>

					<!-- DataTales Example -->
					<div class="card shadow mb-4">
						<div class="card-header py-3">
							<h6 class="m-0 font-weight-bold text-primary float-left"><?php echo lang("admin_h159") ?></h6>
							<a href="<?php echo base_url("admin/add_code"); ?>" class="btn btn-success btn-icon-split btn-sm float-right">
								<span class="icon text-white-50">
									<i class="fas fa-plus"></i>
								</span>
								<span class="text"><?php echo lang("admin_h153") ?></span>
							</a>
						</div>
						<div class="card-body">
							
							<ul id="responds" class="list-group">
								<?php foreach($cat as $key) { $idcat = $key->id; ?>

									<li id="html_codes_<?php echo $idcat; ?>" class="list-group-item border-left-primary" style="margin-bottom: 10px;">
										<span><?php echo $key->name; ?></span>
										<div class="del_wrapper float-right">



											<a href="<?php echo base_url("admin/edit_code/$key->id"); ?>" class="btn btn-primary btn-icon-split btn-sm">
												<span class="icon text-white-50">
													<i class="fas fa-edit"></i>
												</span>
												<span class="text"><?php echo lang("admin_h46") ?></span>
											</a>

											<a href="<?php echo csrf_url("admin/delt/html_codes/$key->id/html_codes"); ?>" class="btn btn-danger btn-icon-split btn-sm">
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


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.16/js/bootstrap-multiselect.min.js" integrity="sha512-ljeReA8Eplz6P7m1hwWa+XdPmhawNmo9I0/qyZANCCFvZ845anQE+35TuZl9+velym0TKanM2DXVLxSJLLpQWw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>

	$(document).ready(function() {

		$('.multiselect').multiselect();
	});
</script>

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