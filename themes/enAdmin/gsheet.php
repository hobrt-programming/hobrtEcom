<?php include_once 'inc/header.php'; ?>

<div id="content-wrapper" class="d-flex flex-column">

	<!-- Main Content -->
	<div id="content">

		<?php include_once 'inc/navbar.php'; ?>

			<div class="container-fluid">


					<!-- Page Heading -->
					<div class="my-4">
				<h1 class="h3 mb-2 text-800"><span class="bg-primary rounded px-1 text-light"><i class="fas fa-server"></i> <?php echo lang("admin_h187") ?></span></h1>
				</div>
					
					<?php

		if(count($gsheet) > 0) {

			foreach ($gsheet as $key) {
				# code...
			}

		}

		?>

		<div class="card shadow">
			
			<div class="card-body">
				
				<li><?php echo lang("admin_h188") ?> <a href="https://console.developers.google.com/?pli=1">https://console.developers.google.com </a> <?php echo lang("admin_h189") ?></li>
				<li><?php echo lang("admin_h190") ?></li>
				<li><?php echo lang("admin_h191") ?> <b> <?php echo base_url("admin/sheet_connect"); ?> </b> <?php echo lang("admin_h192") ?> </li>
				<li><?php echo lang("admin_h193") ?></li>

			</div>

		</div>


		<?php echo form_open_multipart("",array("class" => "form-horizontal")); ?>
		<!-- DataTales Example -->
		<div class="card shadow mb-4">
			
			<div class="card-body">

				<?php if(isset($msg)){ ?>
					<div class="alert alert-success"><?php echo lang("admin_h194") ?></div>
				<?php } ?>
				
				<fieldset>

					<div class="form-group">
						<label for="inp1"> App ID </label>
						<input type="text" name="client_id" class="form-control" id="inp1" aria-describedby="emailHelp" placeholder="App ID" value="<?= isset($key)? $key->client_id : "" ?>">
					</div>

					<div class="form-group">
						<label for="inp1"> App Secret </label>
						<input type="text" name="client_secret" class="form-control" id="inp1" aria-describedby="emailHelp" placeholder="App Secret" value="<?= isset($key)? $key->client_secret : "" ?>">
					</div>

					<div class="form-group">
						<label for="inp1"> Sheet ID </label>
						<input type="text" name="sheetId" class="form-control" id="inp1" aria-describedby="emailHelp" placeholder="Sheet ID" value="<?= isset($key)? $key->sheetId : "" ?>">
					</div>

					<div class="form-group">
						<label for="inp1"> Connected Email </label>
						<input type="text" readonly="" class="form-control" id="inp1" aria-describedby="emailHelp" placeholder="Not Connected" value="<?= isset($key)? $key->email : "" ?>">
					</div>

				</fieldset>

			</div>
			
			<div class="card-footer">
				
				<div class="float-right">
					
					<button class="button btn btn-success" name="test" type="submit">ربط</button>
					<?php if(isset($key)) { ?>
					<a href="<?php echo csrf_url("admin/delt/google_sheets/$key->id/gsheets"); ?>" class="button btn btn-warning">Delete</a>
					<?php } ?>

				</div>

			</div>

			

		</div>

		<?php echo form_close(); ?>


			</div>
			<!-- /.container-fluid -->


</div>


<?php include_once 'inc/footer.php'; ?>