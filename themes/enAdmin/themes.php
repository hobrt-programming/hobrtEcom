<?php include_once 'inc/header.php'; ?>

<div id="content-wrapper" class="d-flex flex-column">

	<!-- Main Content -->
	<div id="content">

		<?php include_once 'inc/navbar.php'; ?>

			<div class="container-fluid">


					<!-- Page Heading -->
					<div class="my-4">
				<h1 class="h3 mb-2 text-gray-800 my-2"><span class="bg-primary rounded px-2 text-white"><i class="far fa-gem"></i> <?php echo lang("admin_h100") ?></span></h1>
				</div>
					<!-- DataTales Example -->
					<div class="card shadow mb-4">
						<div class="card-body row">

							<?php foreach($themes as $theme) :

								$info = json_decode(file_get_contents(realpath($theme)."/info.json")) ?? [];

							?>

							<div class="col-md-6 my-1">

								<div class="card h-100" style="position: relative;">
									<img src="<?php echo base_url("themes/front/".basename($theme)."/screenshot.png"); ?>" class="card-img-top" alt="">
									<div class="card-body">
										<h4><?php echo $info->name ?? "-"; ?></h4>
										<p class="card-text"><?php echo $info->description ?? ""; ?></p>
										<p style="position: absolute; top:5px; right:5px;">
										<?php if(setting('theme') == basename($theme)) { ?>
											<button class="btn btn-success py-1 m-0 rounded-pill border border-1"><i class="fa fa-toggle-on"></i></button>
										<?php }else { ?>
											<a href="<?php echo csrf_url('admin/activate_theme/'.basename($theme)); ?>" class="btn btn-light py-1 m-0 rounded-pill border border-1"><i class="fa fa-toggle-off"></i></a>
										<?php } ?></p>
									</div>
								</div>


							</div>

							<?php endforeach; ?>
							
						</div>
						
						<div class="card-footer">
							
							<!-- <div class="float-right">
								
								<button class="button btn btn-success" name="test" type="submit">add</button>

							</div> -->

						</div>

						

					</div>

					<?php echo form_close(); ?>
					


			</div>
			<!-- /.container-fluid -->


</div>


<?php include_once 'inc/footer.php'; ?>