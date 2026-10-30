<?php include_once 'inc/header.php'; ?>

<!-- the landing page blocks, so the editor shows the page as visitors see it -->
<link rel="stylesheet" href="<?= base_url('assets/landing/blocks.css') ?>">

<div id="content-wrapper" class="d-flex flex-column">

<style>
	
	.h3, h3 {
	    font-size: 1rem;
	}
	
.btn-file {
    position: relative;
    overflow: hidden;
    display: inline-block;
    margin-bottom: 20px;
}
.w300ma {
    width: 300px;
    margin: auto;
}

.dddzsdqd {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}

.inline {
  display: inline;
}

.multiselect-native-select, .multiselect-native-select .btn-group {
	display: block !important;
	width: 100%;
}

</style>

	<!-- Main Content -->
	<div id="content">

		<?php include_once 'inc/navbar.php'; ?>

		<?php if($tp == "add") { ?>

			<div class="container-fluid">

				<!-- Page Heading -->
				<div class="my-4">
			<h1 class="h3 mb-2 text-gray-800 my-2"><span class="bg-primary rounded px-2 text-white"><i class="fa fa-cart-plus"></i> <?php echo lang("admin_h240") ?></span></h1>
			</div>

				<!-- DataTales Example -->
				<div class="card shadow mb-4">
					<div class="card-header py-3 d-flex align-items-center justify-content-between flex-wrap">
						<h6 class="m-0 font-weight-bold text-primary"><?php echo lang("admin_h240") ?></h6>
						<?php $ai_fill_form = 'landing'; include 'inc/ai_fill.php'; ?>
					</div>
					<div class="card-body">
					
					<?php if(isset($msg)){ ?>
						<div class="alert alert-success"><?php echo lang("admin_h54"); ?></div>
					<?php } ?>

						<fieldset>

							<?php echo form_open("", array("class" => "form-horizontal")); ?>
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
                                    <label for="inp3">Old price</label>
                                    <input type="text" class="form-control" id="inp3" aria-describedby="emailHelp" placeholder="20" name="old_price">
                                </div>

								<div class="form-group">
									<label for="inp3">Product</label>
									<select name="product_id" id="" class="form-control">
										<?php foreach($products as $key) { ?>
											<option value="<?php echo $key->id; ?>"><?php echo $key->title; ?></option>	
										<?php } ?>
									</select>
								</div>

								<div class="form-group">
									<label for="inp4"><?php echo lang("admin_h36") ?></label>
									<!-- <div id="editor"></div> -->

									<textarea id="summernote" name="content"></textarea>

									<small id="emailHelp" class="form-text text-muted"><?php echo lang("admin_h36") ?></small>
								</div>

                                <div class="form-group">
                                    <label for="inp4">Pixels, 1 per line.</label>
                                    <textarea class="form-control" name="pixel"></textarea>
                                </div>

								
								<div class="row">
									<div class="col-md-12 mb-3">
										<h3 class="font-weight-medium f-16">عرض خاص</h3>
										<div class="py-1 mb-0" style="border-bottom:1px dashed #00000042;"></div>
									</div>


									<div class="form-group col-md-6">
										<label for="inputName">سعر 2</label>
										<div class="input-group input-group-alternative mb-2">
											<input class="form-control form-control-alternative" type="text" name="price2" placeholder="0">
										</div>
									</div>

									<div class="form-group col-md-6">
										<label for="inputName">سعر 3 + 1 مجانا</label>
										<div class="input-group input-group-alternative mb-2">
											<input class="form-control form-control-alternative"  type="text" name="price3" placeholder="0">
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-12 mb-3">
										<h3 class="font-weight-medium f-16">Colors</h3>
										<div class="py-1 mb-0" style="border-bottom:1px dashed #00000042;"></div>
									</div>


									<div class="form-group col-md-6">
										<label for="inputName">Background</label>
										<div class="input-group input-group-alternative mb-2">
											<input class="form-control form-control-alternative" type="color" name="header_color" value="#aaee55" required>
										</div>
									</div>

									<div class="form-group col-md-6">
										<label for="inputName"> Color </label>
										<div class="input-group input-group-alternative mb-2">
											<input class="form-control form-control-alternative"  type="color" name="btn_color" value="#111111" required>
										</div>
									</div>
								</div>

<div class="card shadow border-0 mb-3">
	<div class="card-body">
		<div class="form-row">

			<div class="col-md-12 mb-3">
				<h3 class="font-weight-medium f-16"> تقييمات المنتوج </h3>
				<h3 class="font-weight-medium f-15 mb-2" style="line-height: 26px;">اضف تقييمات المنتوج الخاص بك <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addnew">اضف تقييم جديدة</a></h3>
				<div class="py-1 mb-0" style="border-bottom:1px dashed #00000042;"></div>
			</div>

			<div class="table-responsive">
				<table class="table table-hover table-striped table-bordered" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th class="f-14">العضو  </th>
							<th class="f-14" width="50%">النص  </th>
							<th class="f-14">التحكم</th>
						</tr>
					</thead>
					<tbody class="trTable">

					</tbody>
				</table>
			</div>


			</div>
		</div>
	</div>




								<button type="submit" class="btn btn-primary" name="test"><?php echo lang("admin_h237") ?></button>
							<?php echo form_close(); ?>

						</fieldset>


					</div>
				</div>

			</div>
			<!-- /.container-fluid -->


		<?php }elseif($tp == "edit"){ ?>
			

			<div class="container-fluid">

				<!-- Page Heading -->
				<h1 class="h3 mb-2 text-gray-800">Products</h1>

				<!-- DataTales Example -->
				<div class="card shadow mb-4">
					<div class="card-header py-3 d-flex align-items-center justify-content-between flex-wrap">
						<h6 class="m-0 font-weight-bold text-primary"><?php echo lang("admin_h238") ?> (<?=$landing_page->title;?>)</h6>
						<?php $ai_fill_form = 'landing'; include 'inc/ai_fill.php'; ?>
					</div>
					<div class="card-body">
					
					<?php if(isset($msg)){ ?>
						<div class="alert alert-success"><?php echo lang("admin_h54"); ?></div>
					<?php } ?>

						<fieldset>

							<?php echo form_open_multipart("",array("class" => "form-horizontal")); ?>
								<div class="form-group">
									<label for="inp1"><?php echo lang("admin_h31") ?></label>
									<input type="text" class="form-control" id="inp1" aria-describedby="emailHelp" placeholder="<?php echo lang("admin_h31") ?>" name="title" value="<?php echo $landing_page->title; ?>">
									<small id="emailHelp" class="form-text text-muted"><?php echo lang("admin_h32") ?></small>
								</div>

								<div class="form-group">
									<label for="inp2"><?php echo lang("admin_h33") ?></label>
									<input type="text" class="form-control" id="inp2" aria-describedby="emailHelp" placeholder="<?php echo lang("admin_h33") ?>" name="price" value="<?php echo $landing_page->price; ?>">
									<small id="emailHelp" class="form-text text-muted"><?php echo lang("admin_h33") ?></small>
								</div>

								<div class="form-group">
									<label for="inp3">Old price</label>
									<input type="text" class="form-control" id="inp3" aria-describedby="emailHelp" placeholder="20" name="old_price" value="<?php echo $landing_page->old_price; ?>">
								</div>

								<div class="form-group">
									<label for="inp3">Product</label>
									<select name="product_id" id="" class="form-control">
										<?php foreach($products as $key) { ?>
											<option value="<?php echo $key->id; ?>" <?php if($key->id == $landing_page->product_id) echo "selected"; ?>><?php echo $key->title; ?></option>	
										<?php } ?>
									</select>
								</div>

								<div class="form-group">
									<label for="inp4"><?php echo lang("admin_h36") ?></label>
									<!-- <div id="editor"></div> -->

									<textarea id="summernote" name="content"><?php echo $landing_page->content; ?></textarea>

									<small id="emailHelp" class="form-text text-muted"><?php echo lang("admin_h36") ?></small>
								</div>

								<div class="form-group">
									<label for="inp4">Pixels, 1 per line.</label>
									<textarea class="form-control" name="pixel"><?php echo $landing_page->pixel; ?></textarea>
								</div>


								<div class="row">
									<div class="col-md-12 mb-3">
										<h3 class="font-weight-medium f-16">عرض خاص</h3>
										<div class="py-1 mb-0" style="border-bottom:1px dashed #00000042;"></div>
									</div>


									<div class="form-group col-md-6">
										<label for="inputName">سعر 2</label>
										<div class="input-group input-group-alternative mb-2">
											<input class="form-control form-control-alternative" type="text" name="price2" value="<?php echo $landing_page->price2; ?>">
										</div>
									</div>

									<div class="form-group col-md-6">
										<label for="inputName">سعر 3 + 1 مجانا</label>
										<div class="input-group input-group-alternative mb-2">
											<input class="form-control form-control-alternative"  type="text" name="price3" value="<?php echo $landing_page->price3; ?>">
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-12 mb-3">
										<h3 class="font-weight-medium f-16">Colors</h3>
										<div class="py-1 mb-0" style="border-bottom:1px dashed #00000042;"></div>
									</div>


									<div class="form-group col-md-6">
										<label for="inputName">Background</label>
										<div class="input-group input-group-alternative mb-2">
											<input class="form-control form-control-alternative" type="color" name="header_color" value="<?php echo $landing_page->header_color; ?>">
										</div>
									</div>

									<div class="form-group col-md-6">
										<label for="inputName"> Color </label>
										<div class="input-group input-group-alternative mb-2">
											<input class="form-control form-control-alternative"  type="color" name="btn_color" value="<?php echo $landing_page->btn_color; ?>">
										</div>
									</div>
								</div>

<div class="card shadow border-0 mb-3">
	<div class="card-body">
		<div class="form-row">

			<div class="col-md-12 mb-3">
				<h3 class="font-weight-medium f-16"> تقييمات المنتوج </h3>
				<h3 class="font-weight-medium f-15 mb-2" style="line-height: 26px;">اضف تقييمات المنتوج الخاص بك <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addnew">اضف تقييم جديدة</a></h3>
				<div class="py-1 mb-0" style="border-bottom:1px dashed #00000042;"></div>
			</div>

			<div class="table-responsive">
				<table class="table table-hover table-striped table-bordered" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th class="f-14">العضو  </th>
							<th class="f-14" width="50%">النص  </th>
							<th class="f-14">التحكم</th>
						</tr>
					</thead>
					<tbody class="trTable">

						<?php if(!empty($landing_page->reviews)) : ?>

						<?php foreach(json_decode($landing_page->reviews) as $var) : ?>
						
						<tr>
							<td class="pt-3 f-15">
								<input type="hidden" value="<?php echo html_escape($var->image ?? ''); ?>" name="image[]" />
								<input type="hidden" value="<?php echo html_escape($var->name ?? ''); ?>" name="name[]" />
								<input type="hidden" value="<?php echo html_escape($var->text ?? ''); ?>" name="text[]" />
								<input type="hidden" value="<?php echo html_escape($var->city ?? ''); ?>" name="city[]" />
								<span>
									<?php if (!empty($var->image)): ?><img src="<?php echo base_url("uploads/" . html_escape(add_thumb($var->image, "_s"))); ?>" width="50" class="float-left mr-2"><?php else: ?><i class="fas fa-user-circle fa-2x float-left mr-2 text-gray-400"></i><?php endif; ?>
									<?php echo html_escape($var->name ?? ''); ?> <br> <?php echo html_escape($var->city ?? ''); ?>
								</span>
							</td>
							<td dir="auto"><?php echo html_escape($var->text ?? ''); ?></td>
							<td class="pt-3 f-15"> <button class="btn btn-primary deleteVar btn-sm"><i class="fas fa-trash-alt ml-1"></i>حذف</button> </td>
						</tr>

						<?php endforeach; ?>

						<?php endif; ?>

					</tbody>
				</table>
			</div>


			</div>
		</div>
	</div>

								<button type="submit" class="btn btn-primary" name="test"><?php echo lang("admin_h237") ?></button>
							<?php echo form_close(); ?>

						</fieldset>


					</div>
				</div>

			</div>
			<!-- /.container-fluid -->


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
										<th>Title</th>
										<th>Old price</th>
										<th>New price</th>
										<th>Total sales</th>
										<th><?php echo lang("admin_h30"); ?></th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th>#</th>
										<th>Title</th>
										<th>Old price</th>
										<th>New price</th>
										<th>Total sales</th>
										<th><?php echo lang("admin_h30"); ?></th>
									</tr>
								</tfoot>
								<tbody>
									<?php foreach($landing_pages as $key) {  ?>
									<tr>
										<td><?php echo $key->id; ?></td>
										<td><?php echo $key->title; ?></td>
										<td><?php echo numfmt_format_currency($fmt, $key->old_price, $currency); ?></td>
										<td><?php echo numfmt_format_currency($fmt, $key->price, $currency); ?></td>
										<td><?php echo $this->m_p->totalSales($key->id); ?></td>
										<td>
											<a href="<?php echo base_url("l/$key->slug"); ?>" target="_blank" class="btn btn-info btn-circle btn-sm"><i class="fas fa-eye"></i></a>
											<a href="<?php echo base_url("admin/edit_landing_page/$key->id"); ?>" class="btn btn-primary btn-circle btn-sm"><i class="fas fa-edit"></i></a>
											<a href="<?php echo csrf_url("admin/delt/landing_pages/$key->id/landing_pages"); ?>" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></a>
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


		<!-- Add new varients -->
		<div class="modal fade" id="addnew" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
			<div class="modal-dialog modal-xl" role="document">
				<div class="modal-content">
					<div class="modal-body">

						<div class="form-row">

							<div class="col-md-12 mb-3">
								<h3 class="font-weight-medium f-16">Review </h3>
								<h3 class="font-weight-medium f-15 mb-2" style="line-height: 26px;">Add new review 
									<div class="py-1 mb-0" style="border-bottom:1px dashed #00000042;"></div>
								</div>

								<div class="form-group col-md-2">
									<label for="inputName">Image</label>
									<br>
									<div class="btn-file" >
									 	<img id="wst_bc_sld" src="<?php echo base_url(); ?>/logo/4ba6814e26a47e6e8e349de75eaace85.png" style='width:100px'>
										<input type="file" class="dddzsdqd" accept="image/*" id="exampleInputFile " name="logo" onchange="loadFile_lcasldr(event, this)">
									</div>
								</div>

								<div class="form-group col-md-2">
									<label for="inputName">Name</label>
									<div class="input-group input-group-alternative mb-2">
										<input class="form-control form-control-alternative valueOption" placeholder="Lahbib ..." type="text">
									</div>
								</div>

								<div class="form-group col-md-4">
									<label for="inputName">City </label>
									<div class="input-group input-group-alternative mb-2">
										<input class="form-control form-control-alternative valueOption1" placeholder="Agadir ..." type="text">
									</div>
								</div>
								<div class="form-group col-md-4">
									<label for="inputName">Text</label>
									<div class="input-group input-group-alternative mb-2">
										<input class="form-control form-control-alternative textValue" placeholder="it made you look cool ..." type="text">
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer"><button class="btn btn-primary" type="button" data-dismiss="modal">إلغاء</button><button class="btn btn-primary" type="button" onclick="addToList(this);">اضف</button></div>

					</div>
				</div>
			</div>


<?php include_once 'inc/footer.php'; ?>


<script>

	$(document).on("click", ".deleteVar", function() {

		var yes = confirm("are you sure ?");

		if(yes) {

			$(this).parent().parent().remove();

		}

		return false;

	})

	/* one review row in the form: {image (file name in uploads/ or ''), name, city, text} */
	function addReviewRow(r) {
		var hidden = function (name, value) { return $('<input type="hidden">').attr('name', name + '[]').val(value || ''); };
		var $who = $('<span>');
		if (r.image) $who.append($('<img width="50" class="float-left mr-2">').attr('src', base_url + 'uploads/' + r.image));
		else $who.append('<i class="fas fa-user-circle fa-2x float-left mr-2 text-gray-400"></i>');
		$who.append(document.createTextNode(' ' + (r.name || '')), '<br>', document.createTextNode(r.city || ''));
		var $tr = $('<tr>').append(
			$('<td class="pt-3 f-15">').append(hidden('image', r.image), hidden('name', r.name), hidden('text', r.text), hidden('city', r.city), $who),
			$('<td dir="auto">').text(r.text || ''),
			$('<td class="pt-3 f-15"><button class="btn btn-primary deleteVar btn-sm"><i class="fas fa-trash-alt ml-1"></i>حذف</button></td>')
		);
		$(".trTable").first().append($tr);
		return $tr;
	}

	function addToList(t) {
		var hada = $(t);
		var src = hada.parent().prev().find("#wst_bc_sld").attr("src") || '';
		var image = /\/logo\//.test(src) ? '' : src.split("/").pop();   // the placeholder picture means no photo

		addReviewRow({
			image: image,
			name: hada.parent().prev().find(".valueOption").val(),
			city: hada.parent().prev().find(".valueOption1").val(),
			text: hada.parent().prev().find(".textValue").val()
		});

		hada.parent().prev().find(".nameOption").val("");

		hada.parent().prev().find(".valueOption").val("");

		$("#addnew").modal("hide");

		return false;

	}

	$(document).ready(function() {

		// $('#summernote').summernote();

        var summernote = $('#summernote').summernote({

            height: 600,
            toolbar:[
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                // ['insert', ['link', 'picture', 'video', 'audio']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']],
            ],
            popover: {
            image: [
                    ['custom', ['imageAttributes']],
                    ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
                    ['float', ['floatLeft', 'floatRight', 'floatNone']],
                    ['remove', ['removeMedia']]
                ],
            },
            lang: 'en-US', // Change to your chosen language
            imageAttributes:{
                icon:'<i class="note-icon-pencil"/>',
                removeEmpty:true, // true = remove attributes | false = leave empty if present
                disableUpload: true // true = don't display Upload Options | Display Upload Options
            },
            callbacks: {
                onImageUpload: function(files) {
                    alert('onImageUpload')
                    sendFile(files[0], $(this));
                },
                onAudioUpload: function(files) {
                    sendFile(files[0], $(this), 'audio');
                }
            }
        });

		$('#dataTable').DataTable({
			"order": [[ 0, "desc" ]],
			// one entry per column: #, title, old price, new price, total sales, actions
			"columns": [
			null,
			null,
			{ type: 'currency' },
			{ type: 'currency' },
			null,
			{ "orderable": false },
			],
		});
	});

	
	function loadFile_lcasldr(event, h) {

		var output = $(h).parent().find("img");

		var fd = new FormData();

		fd.append('file', event.target.files[0]);

			$.ajax({

				url: base_url + "/admin/upload",
				data: fd,
				dataType: "text",
				type: "post",
				contentType: false,
			processData: false,
			success: function(data) {
					output.attr('src', base_url + "/uploads/" + data);
				},
				error: function(data) {
					alert('image not uploaded please refresh the page and try again .');
				}

			});

		
	};

    function sendFile(file, that, type = 'image') {
        filedata = new FormData();
        filedata.append("file", file);
        $.ajax({
        data: filedata,
        type: "POST",
        url: base_url + "/admin/upload",
        cache: false,
        contentType: false,
        processData: false,
        success: function(url) {

            if(type == 'audio'){
                elem = document.createElement("audio");
                elem.setAttribute("src", base_url + "/uploads/"+url);
                elem.setAttribute("controls", "controls");
                elem.setAttribute("preload", "metadata");
                $(that).summernote('editor.insertNode', elem);
            }
            else
                $(that).summernote('insertImage',  base_url + "/uploads/"+url, '');

        }
        });
    }

</script>