<?php include_once 'inc/header.php'; ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.16/css/bootstrap-multiselect.min.css" integrity="sha512-wHTuOcR1pyFeyXVkwg3fhfK46QulKXkLq1kxcEEpjnAPv63B/R49bBqkJHLvoGFq6lvAEKlln2rE1JfIPeQ+iw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
	#product_search_result i {
		display: none;
	}
</style>


<div id="content-wrapper" class="d-flex flex-column">

	<!-- Main Content -->
	<div id="content">

		<?php include_once 'inc/navbar.php'; ?>

		<div class="container-fluid">

			<?php if ($tp == "add") { ?>
				<div class="row">
					<div class="col-12 col-md-8">


						<!-- Page Heading -->
						<h1 class="h3 mb-2 text-gray-800"><?php echo lang("admin_h161") ?></h1>

						<?php echo form_open_multipart("", array("class" => "form-horizontal")); ?>
						<!-- DataTales Example -->
						<div class="card shadow-sm mb-4">

							<div class="card-body">

								<?php if (isset($msg)) { ?>
									<div class="alert alert-success"><?php echo lang("admin_h162") ?></div>
								<?php } ?>

								<fieldset>


									<div class="form-group">
										<label for="inp1"><?php echo lang("admin_h143") ?></label>
										<input type="text" name="title" class="form-control" placeholder="<?php echo lang("admin_h143") ?>">
									</div>

									<!--<div class="form-group">
										<label for="inp1">Slug</label>
										<input type="text" name="slug" class="form-control" placeholder="Slug">
									</div>-->

									<div class="form-group">
										<label for="inp1"><?php echo lang("admin_h36") ?> </label>
										<input type="text" name="description" class="form-control" placeholder="<?php echo lang("admin_h36") ?>">
									</div>

									<div class="form-group">
										<label for="inp1"><?php echo lang("admin_h147") ?> (100x100)</label>
										<input type="file" name="img" class="form-control-file" accept=".jpg,.jpeg,.png,.gif">
									</div>

									<div class="form-group">
										<label for="inp4"><?php echo lang("admin_h163") ?></label>
										<select name="visible_home" class="form-control">
											<option value="1"><?php echo lang("admin_h65") ?></option>
											<option value="0"><?php echo lang("admin_h66") ?></option>
										</select>
									</div>

								</fieldset>

							</div>



						</div>


						<div class="card shadow-sm mb-4">

							<div class="card-body">
								<div class="form-group mb-1">
									<label for="inp1"><?php echo lang("admin_h1") ?></label>
								</div>
								<input id="selected_products_input" type="hidden" name="products" value="">
								<div class="p-1 bg-light border rounded">
									<ul id="selected_products" class="list-group">
										<!-- Selected products will be added here by js -->
										<label class="ml-1 mt-1"><span id="number_of_products_selected">0</span> <?php echo lang("admin_h164") ?></label>
									</ul>
								</div>

								<div class="form-group mt-3 mb-1">
									<label for="inp1"><?php echo lang("admin_h97") ?></label>
								</div>
								<div class="p-1 bg-light border rounded">
									<label class="ml-1 mt-1"><?php echo lang("admin_h165") ?></label>
									<div class="input-group mb-2">
										<div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-search"></i></span></div>
										<input id="product_search_input" class="form-control" type="search" placeholder="<?php echo lang("admin_h165") ?> ..." />
									</div>
									<div id="product_search_result" style="height: 200px;overflow-y: scroll;">
										<!-- Searched products will be added here by js -->
									</div>
								</div>
							</div>
						</div>

						<div class="card shadow-sm mb-4">

							<div class="card-body text-center">
								<button class="button btn btn-success" name="test" type="submit"><?php echo lang("admin_h166") ?></button>
							</div>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>




			<?php } elseif ($tp == "edit") { ?>
				<div class="row">
					<div class="col-12 col-md-8">


						<!-- Page Heading -->
						<h1 class="h3 mb-2 text-gray-800"><?php echo lang("admin_h167") ?></h1>

						<?php echo form_open_multipart("", array("class" => "form-horizontal")); ?>
						<!-- DataTales Example -->
						<div class="card shadow-sm mb-4">

							<div class="card-body">

								<?php if (isset($msg)) { ?>
									<div class="alert alert-success"><?php echo lang("admin_h162") ?></div>
								<?php } ?>

								<fieldset>


									<div class="form-group">
										<label for="inp1"><?php echo lang("admin_h143") ?></label>
										<input type="text" name="title" value="<?= $collection->title ?>" class="form-control" placeholder="<?php echo lang("admin_h143") ?>">
									</div>

									<div class="form-group">
										<label for="inp1"><?php echo lang("admin_h168") ?></label>
										<input type="text" name="slug" value="<?= $collection->slug ?>" class="form-control" placeholder="<?php echo lang("admin_h168") ?>">
									</div>

									<div class="form-group">
										<label for="inp1"><?php echo lang("admin_h36") ?> </label>
										<input type="text" name="description" value="<?= $collection->description ?>" class="form-control" placeholder="<?php echo lang("admin_h36") ?>">
									</div>

									<div class="form-group">
										<label for="inp1"><?php echo lang("admin_h147") ?> (100x100)</label>
										<input type="file" name="img" class="form-control-file" accept=".jpg,.jpeg,.png,.gif">
									</div>

									<div class="form-group">
										<label for="inp4"><?php echo lang("admin_h163") ?></label>
										<select name="visible_home" class="form-control">
											<option value="1"><?php echo lang("admin_h65") ?></option>
											<option value="0"><?php echo lang("admin_h66") ?></option>
										</select>
									</div>

								</fieldset>

							</div>



						</div>


						<div class="card shadow-sm mb-4">

							<div class="card-body">
								<div class="form-group mb-1">
									<label for="inp1"><?php echo lang("admin_h1") ?></label>
								</div>
								<input id="selected_products_input" type="hidden" name="products" value="<?= $collection->products ?>">
								<div class="p-1 bg-light border rounded">
									<ul id="selected_products" class="list-group">
										<!-- Selected products will be added here by js -->
										<label class="ml-1 mt-1"><span id="number_of_products_selected">0</span><?php echo lang("admin_h164") ?> </label>
										<?php foreach ($collection->products_data as $product) : ?>
											<li class="list-group-item" data-product-id="<?= $product->id ?>" style="cursor:pointer">
												<img class="rounded mr-2" width="30" height="30" src="<?= base_url('uploads/' . add_thumb($product->images, "_s")); ?>" />
												<span><?= $product->title ?></span>
												<i class="fas fa-times text-danger" style="float: right;font-size: 25px;"></i>
											</li>
										<?php endforeach; ?>
									</ul>
								</div>

								<div class="form-group mt-3 mb-1">
									<label for="inp1"><?php echo lang("admin_h97") ?></label>
								</div>
								<div class="p-1 bg-light border rounded">
									<label class="ml-1 mt-1"><?php echo lang("admin_h165") ?></label>
									<div class="input-group mb-2">
										<div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-search"></i></span></div>
										<input id="product_search_input" class="form-control" type="search" placeholder="<?php echo lang("admin_h165") ?> ..." />
									</div>
									<div id="product_search_result" style="height: 200px;overflow-y: scroll;">
										<!-- Searched products will be added here by js -->
									</div>
								</div>
							</div>
						</div>

						<div class="card shadow-sm mb-4">

							<div class="card-body text-center">
								<button class="button btn btn-success" name="test" type="submit"><?php echo lang("admin_h166") ?></button>
							</div>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>

			<?php } else { ?>

				<!-- Page Heading -->
				<h1 class="h3 mb-2 text-gray-800"><?php echo lang("admin_h105") ?></h1>

				<!-- DataTales Example -->
				<div class="card shadow mb-4">
					<div class="card-header py-3">
						<h6 class="m-0 font-weight-bold text-primary float-left"><?php echo lang("admin_h169") ?></h6>
						<a href="<?php echo base_url("admin/add_collection"); ?>" class="btn btn-success btn-icon-split btn-sm float-right">
							<span class="icon text-white-50">
								<i class="fas fa-plus"></i>
							</span>
							<span class="text"><?php echo lang("admin_h170") ?></span>
						</a>
					</div>
					<div class="card-body">

						<div class="table-responsive">
							<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>#</th>
										<th><?php echo lang("admin_h147") ?></th>
										<th><?php echo lang("admin_h145") ?></th>
										<th><?php echo lang("admin_h1") ?></th>
										<th><?php echo lang("admin_h30"); ?></th>
									</tr>
								</thead>
								<tbody id="sortable-list">
									<?php foreach ($collections as $collection) {  ?>
										<tr data-id="<?= $collection->id ?>">
											<td><span class="badge"><?php echo $collection->id; ?></span></td>
											<td><img src="<?= $collection->image!==null && $collection->image != ""? base_url("images/$collection->image") : "img/no_image.jpg" ?>" width="100"></td>
											<td>
												<h6 class="font-weight-normal"><?php echo $collection->title; ?></h6>
												<a href="<?= base_url("collection/$collection->slug"); ?>" class="mb-2 d-block small border rounded" target="_blank"><?= base_url("collection/$collection->slug"); ?></a>
												<p class="font-weight-light text-muted font-italic small mb-0"><?php echo $collection->description; ?></p>
											</td>
											<td>
												<?php if ($collection->number_of_products > 0) { ?>
													<p class=" small mb-1"><?= $collection->number_of_products ?> <?php echo lang("admin_h1") ?></p>
												<?php } else { ?>
													<p class=" small mb-1"><?php echo lang("admin_h171") ?></p>
												<?php } ?>
											</td>
											<td>

												<a href="<?php echo base_url("admin/edit_collection/$collection->id"); ?>" class="btn btn-primary btn-circle btn-sm"><i class="fas fa-edit"></i></a>
												<a href="<?php echo csrf_url("admin/delt/collections/$collection->id/collections"); ?>" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></a>

											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
							<?php if (count($collections) == 0) { ?>
								<p><?php echo lang("admin_h172") ?></p>
							<?php } ?>
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
		// AJAX request for product search

		const search_products = (searchQuery) => {
			$.ajax({
				data: {
					searchQuery: searchQuery,
					not_in: $("#selected_products_input").val()
				},
				type: 'POST',
				url: '<?php echo base_url("admin/ajax_search_products"); ?>',
				success: function(data) {
					$("#product_search_result").html(data);
				}
			});
		}

		search_products("");
		$("#product_search_input").keyup(function() {
			const searchQuery = $(this).val();
			search_products(searchQuery)
		});
	</script>

	<script>
		$(document).ready(function() {
			// Handle click on a product in the search results
			$(document).on('click', '#product_search_result li', function() {
				const productId = $(this).data('product-id');
				console.log("clicked")
				// Check if the product is already selected
				if (!$(`#selected_products li[data-product-id="${productId}"]`).length) {
					console.log("selected product", productId)
					addToProductsInput(productId)
					//$("#selected_products_input").val(idArray.join(","))
					// Add the selected product to the list of selected products
					$('#selected_products').append($(this));
					search_products($("#product_search_input").val());
				}
			});

			// Handle click on a selected product to remove it
			$(document).on('click', '#selected_products li', function() {
				const productId = $(this).data('product-id');
				removeFromProductsInput(productId)
				$(this).remove();
				search_products($("#product_search_input").val());
			});
		});
	</script>

	<script>
		updateSelectedProductCount()

		function addToProductsInput(product_id) {
			var hiddenInput = $("#selected_products_input");
			var existingValue = hiddenInput.val();
			var existingArray = existingValue.split(",");
			existingArray.push(product_id.toString());
			var updatedValue = existingArray.join(",");
			if (updatedValue.startsWith(",")) {
				updatedValue = updatedValue.substring(1);
			}
			hiddenInput.val(updatedValue);
			updateSelectedProductCount()
		}

		function removeFromProductsInput(product_id) {
			var hiddenInput = $("#selected_products_input");
			var existingValue = hiddenInput.val();
			var existingArray = existingValue.split(",");

			// Use jQuery's .inArray() to find the index of the value to remove
			var indexToRemove = $.inArray(product_id.toString(), existingArray);

			// If the value is found, remove it from the array
			if (indexToRemove !== -1) {
				existingArray.splice(indexToRemove, 1);
			}

			var updatedValue = existingArray.join(",");

			// If the updated value starts with a comma, remove it
			if (updatedValue.startsWith(",")) {
				updatedValue = updatedValue.substring(1);
			}

			hiddenInput.val(updatedValue);
			updateSelectedProductCount()
		}

		function updateSelectedProductCount() {
			var hiddenInput = $("#selected_products_input");

			var selectedProductCount = !hiddenInput.val() ? 0 : hiddenInput.val().split(",").length;

			// Update the displayed count
			$("#number_of_products_selected").text(selectedProductCount);
		}
	</script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
	$(document).ready(function() {
		$("#sortable-list").sortable({
			update: function(event, ui) {
				var itemOrder = [];
				$("#sortable-list tr").each(function() {
					itemOrder.push($(this).data("id"));
				});
				console.log("collection new order", itemOrder);
				$.ajax({
					data: {
						order: itemOrder,
						table: "collections"
					},
					type: 'POST',
					url: '<?php echo base_url("admin/order_save"); ?>',
					success: function(res) {
						toastr.success("Order saved!");
					}
				});
			}
		});
		$("#sortable-list").disableSelection();
	});
</script>