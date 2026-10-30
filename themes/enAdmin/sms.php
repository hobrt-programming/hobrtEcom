<?php include_once 'inc/header.php'; ?>

<div id="content-wrapper" class="d-flex flex-column">

	<!-- Main Content -->
	<div id="content">

		<?php include_once 'inc/navbar.php'; ?>

			<div class="container-fluid">

				<?php if($tp == "add") { ?>

					<!-- Page Heading -->
					<div class="my-4">
				<h1 class="h3 mb-2 text-gray-800 my-2"><span class="bg-primary rounded px-2 text-white"><i class="fas fa-envelope"></i> <?php echo lang("admin_h195") ?></span></h1>
				</div>

					<?php echo form_open_multipart("",array("class" => "form-horizontal")); ?>
					<!-- DataTales Example -->
					<div class="card shadow mb-4">
						<div class="card-header py-3">
							<h6 class="m-0 font-weight-bold text-primary"><?php echo lang("admin_h196") ?></h6>
						</div>
						
						<div class="card-body">

							<?php if(isset($msg)){ ?>
								<div class="alert alert-success"><?php echo lang("admin_h197") ?></div>
							<?php } ?>
							
							<fieldset>

								
								<div class="form-group">
									<label for="inp1"><?php echo lang("admin_h198") ?></label>
									<input type="text" name="msg" class="form-control" id="inp1" aria-describedby="emailHelp" placeholder="<?php echo lang("admin_h198") ?>">
								</div>

								<div class="form-group">
									<label for="inp1"><?php echo lang("admin_h44") ?></label>
									
									<select name="status" id="" class="form-control">
										<?php foreach(status() as $k => $s) : ?>
											<option value="<?php echo $k; ?>"> <?php echo $s; ?> </option>
										<?php endforeach; ?>
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
						<div class="my-4">
				<h1 class="h3 mb-2 text-gray-800 my-2"><span class="bg-primary rounded px-2 text-white"><i class="fas fa-envelope"></i> <?php echo lang("admin_h195") ?></span></h1>
				</div>

						<?php echo form_open_multipart("",array("class" => "form-horizontal")); ?>
						<!-- DataTales Example -->
						<div class="card shadow mb-4">
							<div class="card-header py-3">
								<h6 class="m-0 font-weight-bold text-primary"><?php echo lang("admin_h199") ?> </h6>
							</div>
							
							<div class="card-body">

								<?php if(isset($msg)){ ?>
									<div class="alert alert-success"><?php echo lang("admin_h51"); ?></div>
								<?php } ?>
								
								<fieldset>

										
									<div class="form-group">
										<label for="inp1"><?php echo lang("admin_h198") ?></label>
										<input type="text" name="msg" class="form-control" id="inp1" aria-describedby="emailHelp" placeholder="<?php echo lang("admin_h198") ?>" value="<?php echo $key->msg; ?>">
									</div>

									<div class="form-group">
										<label for="inp1"><?php echo lang("admin_h44") ?></label>
										
										<select name="status" id="" class="form-control">
											<?php foreach(status() as $k => $s) : ?>
												<option value="<?php echo $k; ?>" <?php if($k == $key->status) echo "selected"; ?>> <?php echo $s; ?> </option>
											<?php endforeach; ?>
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
				<h1 class="h3 mb-2 text-gray-800 my-2"><span class="bg-primary rounded px-2 text-white"><i class="fas fa-envelope"></i> <?php echo lang("admin_h195") ?></span></h1>
				</div>
					<!-- DataTales Example -->
					<div class="card shadow mb-4">
						<div class="card-header py-3">
							<h6 class="m-0 font-weight-bold text-primary float-left"><?php echo lang("admin_h201") ?></h6>
							<a href="<?php echo base_url("admin/add_sms"); ?>" class="btn btn-success btn-icon-split btn-sm float-right">
								<span class="icon text-white-50">
									<i class="fas fa-plus"></i>
								</span>
								<span class="text"><?php echo lang("admin_h196") ?></span>
							</a>
						</div>
						<div class="card-body">
							
							<div class="table-responsive">
								<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
									<thead>
										<tr>
											<th>#</th>
											<th><?php echo lang("admin_h44") ?></th>
											<th><?php echo lang("admin_h198") ?></th>
											<th><?php echo lang("admin_h30"); ?></th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>#</th>
											<th><?php echo lang("admin_h44") ?></th>
											<th><?php echo lang("admin_h198") ?></th>
											<th><?php echo lang("admin_h30"); ?></th>
										</tr>
									</tfoot>
									<tbody>
										<?php foreach($cat as $key) {  ?>
										<tr>
											<td><span class="badge"><?php echo $key->id; ?></span></td>
											<td><?php echo status_badge($key->status); ?></td>
											<td><?php echo $key->msg; ?></td>
											<td>
												
												<a href="<?php echo base_url("admin/edit_sms/$key->id"); ?>" class="btn btn-primary btn-circle btn-sm"><i class="fas fa-edit"></i></a>
												<a href="<?php echo csrf_url("admin/delt/sms/$key->id/sms"); ?>" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></a>

											</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>

							<p>
							<?php echo lang("admin_h202") ?> <br>
								1) <?php echo lang("admin_h203") ?> <a href="https://hbsms.net" target="_blank">Hbsms.net</a> <?php echo lang("admin_h204") ?> <br>
								2) <?php echo lang("admin_h205") ?>



							</p>

						</div>
					</div>

				<?php } ?>

			</div>
			<!-- /.container-fluid -->


</div>


<?php include_once 'inc/footer.php'; ?>