<?php include_once 'inc/header.php'; ?>

<div id="content-wrapper" class="d-flex flex-column">

	<!-- Main Content -->
	<div id="content">

		<?php include_once 'inc/navbar.php'; ?>

		<?php if($tp == "add") { ?>

			<div class="container-fluid">

				<!-- Page Heading -->
				<div class="my-4">
			<h1 class="h3 mb-2 text-gray-800 my-2"><span class="bg-primary rounded px-2 text-white"><i class="fa fa-cart-plus"></i> <?php echo lang("admin_h3") ?></span></h1>
			</div>

				<!-- DataTales Example -->
				<div class="card shadow mb-4">
					<div class="card-header py-3 d-flex align-items-center justify-content-between flex-wrap">
						<h6 class="m-0 font-weight-bold text-primary"><?php echo lang("admin_h3") ?></h6>
						<?php $ai_fill_form = 'product'; include 'inc/ai_fill.php'; ?>
					</div>
					<div class="card-body">
					
					<?php if(isset($msg)){ ?>
						<div class="alert alert-success"><?php echo lang("admin_h54"); ?></div>
					<?php } ?>

						<fieldset>

							<?php echo form_open_multipart("",array("class" => "form-horizontal")); ?>
								<div class="form-group">
									<label for="inp1"><?php echo lang("admin_h31") ?></label>
									<input type="text" class="form-control" id="inp1" aria-describedby="emailHelp" placeholder="<?php echo lang("admin_h31") ?>" name="title">
									<small id="emailHelp" class="form-text text-muted"><?php echo lang("admin_h32") ?></small>
								</div>

								<div class="form-group">
									<label for="inp2"><?php echo lang("admin_h33") ?></label>
									<input type="text" class="form-control" id="inp2" aria-describedby="emailHelp" placeholder="<?php echo lang("admin_h33") ?>" name="price">
									<small id="emailHelp" class="form-text text-muted"><?php echo lang("admin_h33") ?></small>
								</div>

								<div class="form-group">
									<label for="inp3"><?php echo lang("admin_h34") ?></label>
									<input type="number" min="0" max="100" class="form-control" id="inp3" aria-describedby="emailHelp" placeholder="20" name="discount" value="0">
									<small id="emailHelp" class="form-text text-muted"><?php echo lang("admin_h34") ?></small>
								</div>

								<div class="form-group">
									<label for="inp8"><?php echo lang("admin_h35") ?></label>
									<input type="text" class="form-control" id="inp8" aria-describedby="emailHelp" placeholder="<?php echo lang("admin_h35") ?>" name="shipping">
									<small id="emailHelp" class="form-text text-muted"><?php echo lang("admin_h35") ?></small>
								</div>

								<div class="form-group">
									<label for="inp4"><?php echo lang("admin_h36") ?></label>
									<!-- <div id="editor"></div> -->

									<textarea id="summernote" name="descr"></textarea>

									<small id="emailHelp" class="form-text text-muted"><?php echo lang("admin_h36") ?></small>
								</div>

								<div class="form-group">
									<label for="inp5"><?php echo lang("admin_h37") ?></label>
									<select id="" class="form-control" name="cat">
										<?php foreach($cats as $c) { ?>
											<option value="<?php echo $c->id; ?>"><?php echo $c->title; ?></option>
										<?php } ?>
									</select>
									<small id="emailHelp" class="form-text text-muted"><?php echo lang("admin_h37") ?></small>
								</div>
								
								<div class="form-group">
									<label for="inp6"><?php echo lang("admin_h38") ?></label>
									<div class="dropzone dropzone-previews" id="my-awesome-dropzone"></div>
									<input type="hidden" name="images" class="images" value="">

								</div>

								<div class="form-group">

									<label for=""><?php echo lang("admin_h234") ?> : </label>
									
									<div class="row mb-2">

										<div class="col-5">
											<input type="text" class="form-control" placeholder="<?php echo lang("admin_h52"); ?>" name="tp[]">
										</div>
										<div class="col-5">
											<input type="text" class="form-control" placeholder="<?php echo lang("admin_h53"); ?>" name="info[]">
										</div>

										<div class="col-2">
											<a style="cursor: pointer; color: white;" class="btn btn-success btn-circle btn-sm" onclick="addOptions(this);"><i class="fas fa-plus"></i></a>
										</div>

									</div>

								</div>


								
								<div class="form-group">
									<label for="inp4"><?php echo lang("admin_h235") ?> </label>
									<!-- <div id="editor"></div> -->

									<select name="featured" id="" class="form-control">
										<option value="0"><?php echo lang("admin_h66") ?></option>
										<option value="1"><?php echo lang("admin_h65") ?></option>
									</select>

									<small id="emailHelp" class="form-text text-muted"><?php echo lang("admin_h232") ?></small>
								</div>

								<div class="form-group">
									
									<label for="inp8"><?php echo lang("admin_h236") ?></label>
									<textarea class="form-control" name="description"></textarea>

								</div>


								<button type="submit" class="btn btn-primary"><?php echo lang("admin_h237") ?></button>
							<?php echo form_close(); ?>

						</fieldset>


					</div>
				</div>

			</div>
			<!-- /.container-fluid -->


		<?php }elseif($tp == "edit"){ ?>
			
			<?php foreach($cat as $key) : ?>

			<div class="container-fluid">

				<!-- Page Heading -->
				<h1 class="h3 mb-2 text-gray-800">Products</h1>

				<!-- DataTales Example -->
				<div class="card shadow mb-4">
					<div class="card-header py-3 d-flex align-items-center justify-content-between flex-wrap">
						<h6 class="m-0 font-weight-bold text-primary"><?php echo lang("admin_h238") ?> (<?=$key->title;?>)</h6>
						<?php $ai_fill_form = 'product'; include 'inc/ai_fill.php'; ?>
					</div>
					<div class="card-body">
					
					<?php if(isset($msg)){ ?>
						<div class="alert alert-success"><?php echo lang("admin_h54"); ?></div>
					<?php } ?>

						<fieldset>

							<?php echo form_open_multipart("",array("class" => "form-horizontal")); ?>
								<div class="form-group">
									<label for="inp1"><?php echo lang("admin_h31") ?></label>
									<input type="text" class="form-control" id="inp1" aria-describedby="emailHelp" placeholder="<?php echo lang("admin_h31") ?>" name="title" value="<?php echo $key->title; ?>">
									<small id="emailHelp" class="form-text text-muted"><?php echo lang("admin_h32") ?></small>
								</div>

								<div class="form-group">
									<label for="inp2"><?php echo lang("admin_h33") ?></label>
									<input type="text" class="form-control" id="inp2" aria-describedby="emailHelp" placeholder="<?php echo lang("admin_h33") ?>" name="price" value="<?php echo $key->price; ?>">
									<small id="emailHelp" class="form-text text-muted"><?php echo lang("admin_h33") ?></small>
								</div>

								<div class="form-group">
									<label for="inp3"><?php echo lang("admin_h34") ?></label>
									<input type="text" class="form-control" id="inp3" aria-describedby="emailHelp" placeholder="20" name="discount" value="<?php echo $key->discount; ?>">
									<small id="emailHelp" class="form-text text-muted"><?php echo lang("admin_h34") ?></small>
								</div>

								<div class="form-group">
									<label for="inp8"><?php echo lang("admin_h35") ?></label>
									<input type="text" class="form-control" id="inp8" aria-describedby="emailHelp" placeholder="<?php echo lang("admin_h35") ?>" name="shipping" value="<?php echo $key->shipping; ?>">
									<small id="emailHelp" class="form-text text-muted"><?php echo lang("admin_h35") ?></small>
								</div>

								<div class="form-group">
									<label for="inp4"><?php echo lang("admin_h36") ?></label>
									<!-- <div id="editor"></div> -->

									<textarea id="summernote" name="descr"><?php echo $key->descr; ?></textarea>

									<small id="emailHelp" class="form-text text-muted"><?php echo lang("admin_h36") ?></small>
								</div>

								<div class="form-group">
									<label for="inp5"><?php echo lang("admin_h37") ?></label>
									<select id="" class="form-control" name="cat">
										<?php foreach($cats as $c) { ?>
											<option value="<?php echo $c->id; ?>" <?php echo $key->descr == $c->id ? "selected" : ""; ?>><?php echo $c->title; ?></option>
										<?php } ?>
									</select>
									<small id="emailHelp" class="form-text text-muted"><?php echo lang("admin_h37") ?></small>
								</div>
								
								<div class="form-group">
									<label for="inp6"><?php echo lang("admin_h38") ?></label>
									<div class="dropzone dropzone-previews" id="my-awesome-dropzone"></div>
									<input type="hidden" name="images" class="images" value="<?php echo $key->images; ?>">

								</div>

								<div class="form-group">

									<label for=""><?php echo lang("admin_h234") ?> : </label>

									<?php

									$info = json_decode($key->variants) ?? array();
									$i = 0;

									foreach($info as $in){

										?>
										<div class="row mb-2">
											<div class="col-5">
												<input type="text" name="tp[]" placeholder="<?php echo lang("admin_h52"); ?>" class="form-control" value="<?php echo $in->tp; ?>">
											</div>
											<div class="col-5">
												<input type="text" name="info[]" placeholder="<?php echo lang("admin_h53"); ?>" class="form-control" value="<?php echo $in->info; ?>">
											</div>
											<div class="col-2">
												<?php if($i == 0){ ?>
													<a style="cursor: pointer; color: white;" class="btn btn-success btn-circle btn-sm" onclick="addOptions(this);"><i class="fas fa-plus"></i></a>
												<?php }else{ ?>
													<a style="cursor: pointer; color: white;" class="deleteIt btn btn-danger btn-circle btn-sm"><i class="fas fa-minus"></i></a>
												<?php } ?>
											</div>
										</div>

										<?php $i++;} ?>

										<?php if($i == 0){ ?>
											<div class="row mb-2">

												<div class="col-5">
													<input type="text" class="form-control" placeholder="<?php echo lang("admin_h52"); ?>" name="tp[]">
												</div>
												<div class="col-5">
													<input type="text" class="form-control" placeholder="<?php echo lang("admin_h53"); ?>" name="info[]">
												</div>

												<div class="col-2">
													<a style="cursor: pointer; color: white;" class="btn btn-success btn-circle btn-sm" onclick="addOptions(this);"><i class="fas fa-plus"></i></a>
												</div>

											</div>
										<?php } ?>




								</div>


								<div class="form-group">
									<label for="inp4"><?php echo lang("admin_h235") ?> </label>
									<!-- <div id="editor"></div> -->

									<select name="featured" id="" class="form-control">
										<option value="0"><?php echo lang("admin_h66") ?></option>
										<option value="1" <?php if($key->featured == 1) echo "selected"; ?>><?php echo lang("admin_h65") ?></option>
									</select>

									<small id="emailHelp" class="form-text text-muted"><?php echo lang("admin_h232") ?></small>
								</div>

								<div class="form-group">
									
									<label for="inp8"><?php echo lang("admin_h236") ?></label>
									<textarea class="form-control" name="description"><?php echo $key->description; ?></textarea>

								</div>


								<button type="submit" class="btn btn-primary"><?php echo lang("admin_h237") ?></button>
							<?php echo form_close(); ?>

						</fieldset>


					</div>
				</div>

			</div>
			<!-- /.container-fluid -->

			<?php endforeach; ?>


		<?php }else { ?>




			<div class="container-fluid">

				<!-- Page Heading -->
				<div class="my-4">
				<h1 class="h3 mb-2 text-800"><span class="bg-primary rounded px-1 text-light"><i class="fa fa-cart-arrow-down"></i> <?php echo lang("admin_h1"); ?></span></h1>
				</div>
				<!-- DataTales Example -->
				<div class="card shadow mb-4">
					<div class="card-header py-3">
						<h6 class="m-0 font-weight-bold text-primary"><?php echo lang("admin_h112"); ?></h6>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>#</th>
										<th><?php echo lang("admin_h24"); ?></th>
										<th><?php echo lang("admin_h25"); ?></th>
										<th><?php echo lang("admin_h26"); ?></th>
										<th><?php echo lang("admin_h27"); ?></th>
										<th><?php echo lang("admin_h28"); ?></th>
										<th><?php echo lang("admin_h29"); ?></th>
										<th><?php echo lang("admin_h30"); ?></th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th>#</th>
										<th><?php echo lang("admin_h24"); ?></th>
										<th><?php echo lang("admin_h25"); ?></th>
										<th><?php echo lang("admin_h26"); ?></th>
										<th><?php echo lang("admin_h27"); ?></th>
										<th><?php echo lang("admin_h28"); ?></th>
										<th><?php echo lang("admin_h29"); ?></th>
										<th><?php echo lang("admin_h30"); ?></th>
									</tr>
								</tfoot>
								<tbody>
									<?php foreach($products as $key) {  ?>
									<tr>
										<td><?php echo $key->id; ?></td>
										<td><?php echo $key->title; ?></td>
										<td><?php echo numfmt_format_currency($fmt, $key->price, $currency); ?></td>
										<td><?php echo numfmt_format_currency($fmt, floor($key->price - ($key->price * $key->discount / 100)), $currency); ?></td>
										<td><?php echo $this->m_p->totalSales($key->id); ?></td>
										<td><a href="<?php echo base_url("admin/reviews/?product_id=$key->id"); ?>" target="_blanck"><?php echo $this->m_p->get_num("reviews", array("product_id" => $key->id)); ?></a></td>
										<td><a href="<?php echo base_url("admin/reviews/?product_id=$key->id&pending=1"); ?>" target="_blanck"><?php echo $this->m_p->get_num("reviews", array("product_id" => $key->id, "ac" => 0)); ?></a></td>
										<td>
											<a href="<?php echo base_url("admin/edit_product/$key->id"); ?>" class="btn btn-primary btn-circle btn-sm"><i class="fas fa-edit"></i></a>
											<a href="<?php echo csrf_url("admin/delt/products/$key->id/products"); ?>" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></a>
										</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

			</div>
			<!-- /.container-fluid -->



		<?php } ?>

</div>


<?php include_once 'inc/footer.php'; ?>


<script>

	$(document).ready(function() {

		$('#summernote').summernote();

		$('#dataTable').DataTable({
			"order": [[ 0, "desc" ]],
			"columns": [
			null,
			{ type: 'currency', targets: 0 },
			{ type: 'currency', targets: 0 },
			null,
			null,
			null,
			null,
			{ "orderable": false },
			],
		});
	});


	function arrayRemove(arr, value) {

		return arr.filter(function(ele){
			return ele != value;
		});

	}

	$(document).on("click", ".deleteIt", function() {


		$(this).parent().parent().remove();

	})
	
	function addOptions(th) {
		
		var newOption = '<div class="row mb-2">'
		+'<div class="col-5">'
		+'<input type="" name="tp[]" placeholder="<?php echo lang("admin_h52"); ?>" class="form-control">'
		+'</div>'
		+'<div class="col-5">'
		+'<input type="" name="info[]" placeholder="<?php echo lang("admin_h53"); ?>" class="form-control">'
		+'</div>'
		+'<div class="col-2">'
		+'<a style="cursor: pointer; color: white;" class="deleteIt btn btn-danger btn-circle btn-sm"><i class="fas fa-minus"></i></a>'
		+'</div>'
		+'</div>';

		$(th).parent().parent().after(newOption);

	}

	Dropzone.autoDiscover = false;
	jQuery(document).ready(function() {

		$("div#my-awesome-dropzone").dropzone({
			url: base_url + "/admin/upload",
			addRemoveLinks: true,
			acceptedFiles: 'image/*',
			dictCancelUpload: "cancel",
			dictRemoveFile: "remove",
			dictCancelUploadConfirmation : "are you sure",
			dictRemoveFileConfirmation: "do you want to delete this file ?",
			success : function(file, data) {

				file.serverName = data;

				var oldImages = $(".images").val() == "" ? [] : $(".images").val().split(",");

				oldImages.push(data);

				$(".images").val(oldImages.join(","));
			},
			init: function () {

				this.on("removedfile", function(file) {

					var oldImages = $(".images").val() == "" ? [] : $(".images").val().split(",");

					oldImages = arrayRemove(oldImages, file.name);
					oldImages = arrayRemove(oldImages, file.serverName);

					$(".images").val(oldImages.join(","));

				});

				var ref = this;

				var oldImages = $(".images").val() == "" ? [] : $(".images").val().split(",");

				oldImages.forEach(function(item) {

					var mockFile = {
						name: item,
						size : 1024000,
						isMock: true,
						serverImgUrl : base_url + "/uploads/" + item
					};

					// Call the default addedfile event handler
					ref.emit("addedfile", mockFile);
					ref.emit("complete", mockFile);

					// And optionally show the thumbnail of the file:
					ref.emit("thumbnail", mockFile, mockFile.serverImgUrl);

					ref.files.push(mockFile);


            })


			}
		});

	});

</script>