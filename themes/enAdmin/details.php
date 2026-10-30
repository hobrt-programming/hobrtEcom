<?php include_once 'inc/header.php'; ?>

<div id="content-wrapper" class="d-flex flex-column">

	<!-- Main Content -->
	<div id="content">

		<?php include_once 'inc/navbar.php'; ?>

		<!-- Begin Page Content -->
		<div class="container-fluid">

		<?php foreach($msg as $key){ $id = $key->id; ?>

			<!-- Page Heading -->
			<h1 class="h3 mb-4 page-title" style="direction: <?php echo lang("admin_h55") ?>;"><span><i class="fas fa-receipt"></i> <?php echo html_escape($key->name); ?> <?php echo lang("admin_h117") ?></span> <?php echo status_badge($key->status); ?></h1>

			<div class="row">

				<div class="col-lg-6">

					<!-- Circle Buttons -->
					<div class="card shadow mb-4">
						<div class="card-header py-3">
							<h6 class="m-0 font-weight-bold text-primary"><?= lang("admin_h254") ?></h6>
						</div>
						<div class="card-body order-info">
							<div class="bg-gray-100 p-3 mb-4">
								<ul class="list-inline m-0">
									<li class="list-inline-item"><?php echo lang("admin_h56") ?></li>
									<li class="list-inline-item"> : </li>
									<li class="list-inline-item"><?php echo html_escape($key->name); ?></li>
								</ul>
							</div>
							<div class="bg-gray-100 p-3 mb-4">
								<ul class="list-inline m-0">
									<li class="list-inline-item"><?php echo lang("admin_h57") ?></li>
									<li class="list-inline-item"> : </li>
									<li class="list-inline-item"><?php echo html_escape($key->tele); ?></li>
								</ul>
							</div>
							<div class="bg-gray-100 p-3 mb-4">
								<ul class="list-inline m-0">
									<li class="list-inline-item"><?php echo lang("admin_h58") ?></li>
									<li class="list-inline-item"> : </li>
									<li class="list-inline-item"><?php echo html_escape($key->address); ?></li>
								</ul>
							</div>
							<div class="bg-gray-100 p-3 mb-4">
								<ul class="list-inline m-0">
									<li class="list-inline-item"><?php echo lang("admin_h59") ?></li>
									<li class="list-inline-item"> : </li>
									<li class="list-inline-item"><?php echo html_escape($key->city); ?></li>
								</ul>
							</div>
							<div class="bg-gray-100 p-3 mb-4">
								<ul class="list-inline m-0">
									<li class="list-inline-item"><?php echo lang("admin_h60") ?></li>
									<li class="list-inline-item"> : </li>
									<li class="list-inline-item"><?php echo html_escape($key->coupon); ?></li>
								</ul>
							</div>
							<div class="bg-gray-100 p-3 mb-4">
								<ul class="list-inline m-0">
									<li class="list-inline-item"><?php echo lang("admin_h61") ?></li>
									<li class="list-inline-item"> : </li>
									<li class="list-inline-item"><?php echo numfmt_format_currency($fmt, $key->totalPrice, $currency); ?></li>
								</ul>
							</div>

							<div class="bg-gray-100 p-3 mb-4">
								<ul class="list-inline m-0">
									<li class="list-inline-item"><?php echo lang("admin_h62") ?></li>
									<li class="list-inline-item"> : </li>
									<li class="list-inline-item"><?php echo status_badge($key->status); ?></li>
								</ul>
							</div>



						</div>
					</div>

					<!-- Brand Buttons -->
					<div class="card shadow mb-4">
						<div class="card-header py-3">
							<h6 class="m-0 font-weight-bold text-primary float-left"><?= lang("admin_h255") ?></h6>
							<a class="btn btn-success btn-circle btn-sm float-right" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i></a>
						</div>
						<div class="card-body">
							<ul class="list-unstyled testProduct">
								<?php $pcs = json_decode($key->products, TRUE); foreach($pcs as $p) { ?>
								<li class="media mb-4">
									<img src="<?php echo base_url("uploads")."/".add_thumb(get_info("products", $p['id'], "images") ,'_s') ?>" class="mr-3 rounded-lg" alt="...">
									<div class="media-body">
										<a class="btn btn-danger btn-circle btn-sm float-right" onclick="deletePrd(<?=$p['id'];?>);"><i class="fas fa-trash"></i></a>
										<h5 class="mt-0 mb-1"><?php echo get_info("products", $p['id'], "title"); ?></h5>
										Qty: <b><?php echo $p['q']; ?></b> <br>

										<?php
										if(isset($p['options']) && $p['options'] != null)
										{
											$op = json_decode($p['options'], TRUE);
											if(!is_null($op)){
												foreach ($op as $key1 => $value1) {
													echo option_label($key1), " : ", html_escape($value1), "<br>";
												}
											}
										}
										?>
									</div>
								</li>
								<?php } ?>
							</ul>

						</div>
					</div>

				</div>

				<div class="col-lg-6">

					<?php echo form_open(""); ?>

					<div class="card shadow mb-4">
						<div class="card-header py-3">
							<h6 class="m-0 font-weight-bold text-primary"><?= lang("admin_h256") ?></h6>
						</div>

						<div class="card-body">

							<div class="form-group">
								
								<label for=""><?php echo lang("admin_h56") ?> </label>
								<input type="text" class="form-control" value="<?php echo html_escape($key->name); ?>" name="name">

							</div>

							<div class="form-group">
								
								<label for=""><?php echo lang("admin_h57") ?> </label>
								<input type="text" class="form-control" value="<?php echo html_escape($key->tele); ?>" name="tele">

							</div>

							<div class="form-group">
								
								<label for=""><?php echo lang("admin_h58") ?> </label>
								<input type="text" class="form-control" value="<?php echo html_escape($key->address); ?>" name="address">

							</div>

							<div class="form-group">
								
								<label for=""><?php echo lang("admin_h59") ?> </label>
								<input type="text" class="form-control" value="<?php echo html_escape($key->city); ?>" name="city">

							</div>

							<div class="form-group">
								
								<label for=""><?php echo lang("admin_h60") ?> </label>
								<input type="text" class="form-control" value="<?php echo html_escape($key->coupon); ?>" name="coupon">

							</div>

							<div class="form-group">
								
								<label for=""><?php echo lang("admin_h61") ?> </label>
								<input type="text" class="form-control" name="totalPrice" value="<?php echo $key->totalPrice; ?>">

							</div>

							<div class="form-group">
								
								<label for=""><?php echo lang("admin_h62") ?> </label>
								<select name="status" id="" class="form-control">
									<?php foreach(status() as $k => $s) : ?>
										<option value="<?php echo $k; ?>" <?php if($key->status == $k) echo "selected"; ?>> <?php echo $s; ?> </option>
									<?php endforeach; ?>
								</select>

							</div>
						</div>

						<div class="card-footer">
							<button class="float-right btn btn-success" name="test">Submit</button>
						</div>

					</div>
					<?php echo form_close(); ?>

				</div>

			</div>

		<?php } ?>

		</div>


		<!-- Modal -->
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Add new product to order</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row results">
							<form action="" class="col-md-12">
								<input type="text" class="form-control" style="width: 100%;" placeholder="type product name" class="tetddd" onkeyup="search(this);" style="border-bottom-right-radius: 0;border-bottom-left-radius: 0;">
							</form>
								
							<div class="list-group modelHb">

							</div>

						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" onclick="addProduct();">Save changes</button>
					</div>
				</div>
			</div>
		</div>


</div>


<script id="modalInfo"  type="text/x-handlebars-template">

	<div class="col-md-12">

		<form id="formPrd">

			<div class="form-group">
				
				<input type="number" class="form-control qty" style="width: 100%;" placeholder="Quantity" name="qty">
				<input type="hidden" name="id" value="{{ id }}">
				
			</div>

			{{#each variants}}

				<label> {{ tp }}</label>

				<select name="option[{{encode tp }}]" id="" class="form-control">

					{{#each (split info) }}

						<option value="{{ this }}">{{ this }}</option>



					{{/each }}

				</select>

			{{/each}}

		</form>

	</div>


</script>

<script id="default" type="text/x-handlebars-template">
	
	<form action="" class="col-md-12">
		<input type="text" class="form-control" style="width: 100%;" placeholder="type product name" class="tetddd" onkeyup="search(this);" style="border-bottom-right-radius: 0;border-bottom-left-radius: 0;">
	</form>
		
	<div class="list-group modelHb">

	</div>

</script>

<?php include_once 'inc/footer.php'; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.7.3/handlebars.min.js"></script>


<script>

	var info = [];

	var i;

	var template = $('#modalInfo').html();

	var defaultTemp = $('#default').html();

	var templateScript = Handlebars.compile(template);

	$(document).on("click", ".clicked-product", function() {

		i = $(this).data("index");

		var product = info[i];

		var variants = (product.variants != "") ? JSON.parse(product.variants) : [];

		var html = templateScript({variants : variants, id: product.id});

		$(".results").html(html);


	})

	function addProduct() {

		var data = $("#formPrd").serialize();

		$.ajax({

			data: data,
			dataType: "html",
			url: base_url + "admin/addProductToOrder/<?=$id;?>",
			method: "POST",

			success: function(data) {
				$(".testProduct").html(data);
				$(".results").html(defaultTemp);
			}

		});

		//$(".testProduct").append(html);
	}

	function deletePrd(id) {

		var yes = confirm("are you sure ? this action can't be undo ");

		if(!yes)
			return false;

		$.ajax({

			data: {id: id},
			dataType: "html",
			url: base_url + "admin/addProductToOrder/<?=$id;?>",
			method: "POST",

			success: function(data) {
				$(".testProduct").html(data);
			}

		});

		return false;

		//$(".testProduct").append(html);
	}

	function bin2hex(s) {
		var i
		var l
		var o = ''
		var n

		s += ''

		for (i = 0, l = s.length; i < l; i++) {
			n = s.charCodeAt(i)
			.toString(16)
			o += n.length < 2 ? '0' + n : n
		}

		return o
	}

	function base64(s) {
		if (typeof btoa !== 'function') {
			alert("there is a problem with your browser please use the last version");
		}

		return btoa( unescape ( encodeURIComponent(s)));
	}


	Handlebars.registerHelper("encode", function (index){
	    return bin2hex(base64(index));
	});

	Handlebars.registerHelper("split", function (index){
	    return (index != null && index != undefined && index != "") ? index.split(",") : [];
	});
	
	function search(t) {

		var v = $(t).val();

		$.ajax({
			method: "POST",
			url: base_url + "admin/search",
			dataType: "JSON",
			data: {q: v},
			success : function(data) {
				if(data.success === false) {
					alert("0");
				}else {

					console.log(data);

					info = data;

					$(".modelHb").html("");

					$.each(data, function(i, item) {
						console.log(item);
						$(".modelHb").append("<a class=\"list-group-item list-group-item-action clicked-product\" data-index='"+i+"'>"+ item.title +"</a>");
					})

				}
			}
		})

	}

</script>