<?php include_once 'inc/header.php'; ?>

<div id="content-wrapper" class="d-flex flex-column">

	<!-- Main Content -->
	<div id="content">

		<?php include_once 'inc/navbar.php'; ?>

			<div class="container-fluid">


					<!-- Page Heading -->
					<div class="my-4">
				<h1 class="h3 mb-2 text-gray-800 my-2"><span class="bg-primary rounded px-2 text-white"><i class="fas fa-user-circle"></i> <?php echo lang("admin_h18") ?></span></h1>
				</div>
					<?php echo form_open_multipart("",array("class" => "form-horizontal")); ?>
					<!-- DataTales Example -->
					<div class="card shadow mb-4">
						<div class="card-header py-3">
							<h6 class="m-0 font-weight-bold text-primary"><?php echo lang("admin_h23") ?> </h6>
						</div>
						
						<div class="card-body">

							<?php if(isset($msg)){ ?>
								<div class="alert alert-success"><?php echo lang("admin_h208") ?> </div>
							<?php } ?>
							
							<fieldset>

								
								<div class="form-group">
									<label for="inp1"><?php echo lang("admin_h207") ?>  </label>
									<input type="text" name="username" class="form-control" id="inp1" aria-describedby="emailHelp" placeholder="<?php echo lang("admin_h207") ?> ">
									<small id="emailHelp" class="form-text text-muted"><?php echo lang("admin_h207") ?>  </small>
								</div>

								
								<div class="form-group">
									<label for="inp1"><?php echo lang("admin_h123") ?>  </label>
									<input type="email" name="email" class="form-control" id="inp1" aria-describedby="emailHelp" placeholder="<?php echo lang("admin_h123") ?>">
									<small id="emailHelp" class="form-text text-muted"><?php echo lang("admin_h123") ?> </small>
								</div>

								
								<div class="form-group">
									<label for="inp1"><?php echo lang("admin_h209") ?> </label>
									<input type="password" name="password" class="form-control" id="inp1" aria-describedby="emailHelp" placeholder="<?php echo lang("admin_h209") ?>">
									<small id="emailHelp" class="form-text text-muted"><?php echo lang("admin_h209") ?> </small>
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
					


			</div>
			<!-- /.container-fluid -->


</div>


<?php include_once 'inc/footer.php'; ?>