<?php include_once 'inc/header.php'; ?>

<div id="content-wrapper" class="d-flex flex-column">

	<!-- Main Content -->
	<div id="content">

		<?php include_once 'inc/navbar.php'; ?>

		<div class="container-fluid">

			<?php if($tp == "add") { ?>

				<!-- Page Heading -->
				<div class="my-4">
				<h1 class="h3 mb-2 text-gray-800 my-2"><span class="bg-primary rounded px-2 text-white"><i class="fas fa-percent"></i> <?php echo lang("admin_h132") ?></span></h1>
				</div>

				<?php echo form_open_multipart("",array("class" => "form-horizontal")); ?>
				<!-- DataTales Example -->
				<div class="card shadow mb-4">
					<div class="card-header py-3">
						<h6 class="m-0 font-weight-bold text-primary"><?php echo lang("admin_h133") ?></h6>
					</div>

					<div class="card-body">

						<?php if(isset($msg)){ ?>
							<div class="alert alert-success"><?php echo lang("admin_h134") ?></div>
						<?php } ?>

						<fieldset>


							<div class="form-group">
								<label for="inp1"><?php echo lang("admin_h135") ?></label>
								<input type="text" name="coupon" class="form-control" id="inp1" aria-describedby="emailHelp" placeholder="<?php echo lang("admin_h135") ?>">
							</div>

							
							<div class="form-group">
								<label for="inp1"><?php echo lang("admin_h136") ?></label>
								<input type="date" name="date" class="form-control" id="inp1" aria-describedby="emailHelp" placeholder="<?php echo lang("admin_h136") ?>">
							</div>


							<div class="form-group">
								<label for="inp1"><?php echo lang("admin_h140") ?> </label>
								<input type="text" name="num" class="form-control" id="inp1" aria-describedby="emailHelp" placeholder="<?php echo lang("admin_h140") ?>">
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
					<h1 class="h3 mb-2 text-gray-800"><?php echo lang("admin_h132") ?></h1>

					<?php echo form_open_multipart("",array("class" => "form-horizontal")); ?>
					<!-- DataTales Example -->
					<div class="card shadow mb-4">
						<div class="card-header py-3">
							<h6 class="m-0 font-weight-bold text-primary"><?php echo lang("admin_h139") ?> <?=$key->coupon;?></h6>
						</div>

						<div class="card-body">

							<?php if(isset($msg)){ ?>
								<div class="alert alert-success"><?php echo lang("admin_h51"); ?></div>
							<?php } ?>

							<fieldset>


								<div class="form-group">
									<label for="inp1"><?php echo lang("admin_h135") ?></label>
									<input type="text" name="coupon" value="<?php echo $key->coupon; ?>" class="form-control" id="inp1" aria-describedby="emailHelp" placeholder="<?php echo lang("admin_h135") ?>">
								</div>

								
								<div class="form-group">
									<label for="inp1"><?php echo lang("admin_h136") ?></label>
									<input type="date" name="date" value="<?php echo $key->date; ?>" class="form-control" id="inp1" aria-describedby="emailHelp" placeholder="<?php echo lang("admin_h136") ?>">
								</div>


								<div class="form-group">
									<label for="inp1"><?php echo lang("admin_h140") ?> </label>
									<input type="text" name="num" value="<?php echo $key->num; ?>" class="form-control" id="inp1" aria-describedby="emailHelp" placeholder="<?php echo lang("admin_h140") ?>">
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
				<h1 class="h3 mb-2 text-gray-800"><?php echo lang("admin_h132") ?></h1>

				<!-- DataTales Example -->
				<div class="card shadow mb-4">
					<div class="card-header py-3">
						<h6 class="m-0 font-weight-bold text-primary float-left"><?php echo lang("admin_h137") ?></h6>
						<a href="<?php echo base_url("admin/add_discount"); ?>" class="btn btn-success btn-icon-split btn-sm float-right">
							<span class="icon text-white-50">
								<i class="fas fa-plus"></i>
							</span>
							<span class="text"><?php echo lang("admin_h133") ?></span>
						</a>
					</div>
					<div class="card-body">

						<div class="table-responsive">
							<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>#</th>
										<th><?php echo lang("admin_h135") ?></th>
										<th><?php echo lang("admin_h138") ?></th>
										<th><?php echo lang("admin_h136") ?></th>
										<th><?php echo lang("admin_h30"); ?></th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th>#</th>
										<th><?php echo lang("admin_h135") ?></th>
										<th><?php echo lang("admin_h138") ?></th>
										<th><?php echo lang("admin_h136") ?></th>
										<th><?php echo lang("admin_h30"); ?></th>
									</tr>
								</tfoot>
								<tbody>
									<?php foreach($cat as $key) {  ?>
										<tr>
											<td><span class="badge"><?php echo $key->id; ?></span></td>
											<td><?php echo $key->coupon; ?></td>
											<td><?php echo $key->num; ?>% </td>
											<td><?php echo $key->date; ?></td>
											<td>

												<a href="<?php echo base_url("admin/edit_discount/$key->id"); ?>" class="btn btn-primary btn-circle btn-sm"><i class="fas fa-edit"></i></a>
												<a href="<?php echo csrf_url("admin/delt/discounts/$key->id/discounts"); ?>" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></a>

											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>

					</div>
				</div>

			<?php } ?>

		</div>
		<!-- /.container-fluid -->


	</div>


	<?php include_once 'inc/footer.php'; ?>