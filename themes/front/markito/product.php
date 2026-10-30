<?php include_once 'header.php'; ?>

<script>
	if (typeof fbq !== 'undefined')
		fbq('track', 'ViewContent');
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/css/lightslider.min.css" integrity="sha512-yJHCxhu8pTR7P2UgXFrHvLMniOAL5ET1f5Cj+/dzl+JIlGTh5Cz+IeklcXzMavKvXP8vXqKMQyZjscjf3ZDfGA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<?= $late_css("https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.10.0/css/lightgallery.min.css", ' integrity="sha512-gk6oCFFexhboh5r/6fov3zqTCA2plJ+uIoUx941tQSFg6TNYahuvh1esZVV0kkK+i5Kl74jPmNJTTaHAovWIhw==" crossorigin="anonymous" referrerpolicy="no-referrer"') ?>

<style>
	.px-4-5 {
		padding-right: 30px;
		padding-left: 30px;
	}

	.custom-variants-style input[type="radio"] {
		display: none;
	}

	.custom-variants-style input[type="radio"]+label {
		display: inline-block;
		background: #f1f2f6;
		min-width: 40px;
		padding: 0 10px;
		height: 40px;
		text-align: center;
		cursor: pointer;
		border-radius: 5px;
		line-height: 2.7;
		margin-right: 5px;
		transition: all 0.3s ease-in-out 0s;
		-moz-transition: all 0.3s ease-in-out 0s;
		-o-transition: all 0.3s ease-in-out 0s;
		-webkit-transition: all 0.3s ease-in-out 0s;
		-ms-transition: all 0.3s ease-in-out 0s;


	}

	.custom-variants-style input[type="radio"]:checked+label {
		color: #fff;
	}

	.swal2-styled.swal2-cancel {
		color: #000;
	}
</style>

<!---End-Main-section-->
<!---Start-Product-Detail-->
<section class="ws-section-spacing product-detail-page pt-0 pt-lg-5 pb-0">
	<div class="container border-bottom pb-5">
		<div class="row">
			<div class="col-lg-6 col-md-6 px-4-5">
				<!-- lightSlider only lays out left-to-right: keep the gallery LTR on Arabic pages -->
				<div class="row" dir="ltr">
					<ul id="imageGallery">
						<?php $images = explode(",", $product->images);
						if ($product->images !== null && $product->images != "" && sizeof($images) > 0)
							foreach ($images as $n => $img) { ?>
							<li data-thumb="<?php echo base_url("uploads") . "/" . add_thumb($img, "_s") ?>" data-src="<?php echo base_url("uploads/" . $img) ?>">
								<img src="<?php echo base_url("uploads") . "/" . add_thumb($img, "_m") ?>" width="400" height="400" alt="<?= html_escape($product->title) ?>" <?= $n === 0 ? 'fetchpriority="high"' : 'loading="lazy"' ?> />
							</li>

						<?php }
						else { ?>
							<li data-thumb="<?= base_url("assets/img/default_product.png") ?>" data-src="<?= base_url("assets/img/default_product.png") ?>">
								<img src="<?= base_url("assets/img/default_product.png") ?>" alt="<?= html_escape($product->title) ?>" />
							</li>
						<?php } ?>

					</ul>

				</div>
			</div>
			<!--product-detail-->
			<div class="col-lg-6 col-md-6">
				<div class="product-detail">
					<h1><?php echo $product->title; ?></h1>
					<p><?= lang("lang_h69") ?> - <?php echo get_info('cats', $product->cat, 'title'); ?></p>
					<div class="Start">
						<ul class="item-rating">
							<?php
							$rating = $product->review; // 3.5;

							// Calculate the number of filled, half-filled, and unfilled stars
							$filledStars = floor($rating);
							$hasHalfStar = ($rating - $filledStars) >= 0.5;
							$unfilledStars = 5 - $filledStars - ($hasHalfStar ? 1 : 0);
							?>
							<?php for ($i = 1; $i <= $filledStars; $i++) : ?>
								<li><i class="fas fa-star"></i></li>
							<?php endfor; ?>

							<?php if ($hasHalfStar) : ?>
								<li><i class="fas fa-star-half"></i></li>
							<?php endif; ?>

							<?php for ($i = 1; $i <= $unfilledStars; $i++) : ?>
								<li><i class="far fa-star"></i></li>
							<?php endfor; ?>
						</ul>
					</div>
					<div class="product-detail-price">
						<div class="h3"><?php echo format_money($product->price - ($product->price * $product->discount / 100)); ?> <?php if ($product->discount > 0) : ?><span><?php echo format_money($product->price); ?></span> <?php endif; ?> </div>
					</div>
					<div class="stock">
						<p><?= lang("lang_h70") ?> : <span><?= lang("lang_h71") ?></span></p>
					</div>

					<form id="productInfo">

						<input type="hidden" name="id" value="<?php echo $product->id; ?>">

						<?php

						$variants = json_decode($product->variants, TRUE) ?? [];

						if (count($variants) > 0) {

						?>

							<?php foreach ($variants as $key => $value) { ?>

								<div class="custom-variants-style">
									<span><b><?php echo $value['tp']; ?> : </b></span>

									<?php

									$opt = explode(",", $value['info']);

									foreach ($opt as $i => $k) :
									?>

										<input type="radio" id="for_<?= $key; ?>_<?= $i; ?>" name="option[<?php echo bin2hex(base64_encode($value['tp'])); ?>]" value="<?php echo $k; ?>">
										<label for="for_<?= $key; ?>_<?= $i; ?>"><?php echo $k; ?></label>

									<?php endforeach; ?>

								</div>
								<br>



							<?php } ?>

						<?php } ?>

						<p class="product-discription"><?php echo $product->description; ?></p>
						<div class="p-button mini-cart-item d-flex align-items-center ">

							<div class="product_quantity" style="margin-right: 20px;">
								<div class="quanty_form">
									<div class="product-quantity d-flex">
										<button type="button" class="sub subQty" aria-label="-1">-</button>
										<input type="text" value="1" name="qty" inputmode="numeric" aria-label="<?= $rtl ? "الكمية" : "Quantity" ?>" />
										<button type="button" class="add addQty" aria-label="+1">+</button>
									</div>
								</div>
							</div>

							<a href="javascript:;" onclick="addToCart(2);"><?= lang("lang_h51") ?></a>
							<a href="javascript:;" onclick="addToCart(1);" class="active"><?= lang("lang_h72") ?></a>
						</div>

					</form>

				</div>
			</div>
		</div>
	</div>
</section>
<section class="pt-4 ">
	<div class="container border-bottom pb-4">
		<h2 class="section-title-sm"><?= lang("lang_h73") ?></h2>
		<?php echo $product->descr; ?>
	</div>
</section>
<section class="pt-4">
	<div class="container pb-4">
		<h2 class="section-title-sm"><?= count(($reviews)) ?> <?= lang("lang_h74") ?></h2>
		<?php if (empty($reviews)) : ?>
			<div class="col-md-12">
				<div class="alert alert-info" role="alert">
				<?= lang("lang_h75") ?>
				</div>
			</div>
		<?php else : ?>
			<div class="row">
				<?php foreach ($reviews as $review) : ?>
					<div class="col-12 col-md-6 col-lg-4">
						<div class="card mb-3">
							<div class="card-body">

								<div class="d-flex align-items-center">
									<div class="mr-3">
										<img src="images/person.png" style="width: 40px; height:40px" alt="" class="rounded-circle border" width="40" height="40" loading="lazy">
									</div>
									<div class="d-flex flex-column">
										<h3 class="h5 card-title mb-0"><?= html_escape($review->name) ?></h3>
										<div>
											<span class="text-warning stars">
												<?php
												$rating = $review->rating;
												echo str_repeat("&#9733;", $rating) . str_repeat("&#9734;", 5 - $rating);
												?>
											</span>
										</div>

									</div>
								</div>
								<p class="card-text"><?= $review->comment !== null && $review->comment != "" ? nl2br(html_escape($review->comment)) :lang("lang_h76") ?></p>
								<?php if($review->img !== null && $review->img != "") { ?>
									<img class="img-thumbnail" src="<?= base_url("images/" . rawurlencode((string) $review->img)) ?>" style="width: 100%; height:auto" loading="lazy" alt="<?= html_escape($review->name) ?>" />
								<?php } ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<div id="already-reviewed" class="container" style="display: none;">
		<div class="alert alert-warning" role="alert"><span><strong><?= lang("lang_h77") ?></div>
		</div>
		<button id="review-action" type="button" class="btn mt-3" data-toggle="modal" data-target="#reviewModal" style="background-color: <?= $color ?>;color:white">
			<i class="fas fa-plus-circle" aria-hidden="true"></i> <?= lang("lang_h78") ?>
		</button>
	</div>
</section>

<!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form id="reviewForm" method="post" enctype="multipart/form-data" class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="reviewModalLabel"><?= lang("lang_h78") ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
			<div id="messageContainer"></div>
				<div id="form-body">
					
					<div class="form-group">
						<label for="name"><?= lang("lang_h22") ?></label>
						<input name="name" type="text" class="form-control" id="name" required>
					</div>
					<div class="form-group">
						<label for="email"><?= lang("lang_h79") ?></label>
						<input name="email" type="email" class="form-control" id="email" required>
					</div>
					<div class="form-group">
						<label for="rating"><?= lang("lang_h80") ?></label>
						<select name="rating" class="form-control" id="rating" required>
							<option value="5">&#9733; &#9733; &#9733; &#9733; &#9733;</option>
							<option value="4">&#9733; &#9733; &#9733; &#9733;</option>
							<option value="3">&#9733; &#9733; &#9733;</option>
							<option value="2">&#9733; &#9733;</option>
							<option value="1">&#9733;</option>
						</select>
					</div>
					<div class="form-group">
						<label for="comment"><?= lang("lang_h81") ?></label>
						<textarea name="comment" class="form-control" id="comment" rows="3"></textarea>
					</div>
					<div class="form-group">
						<label for="image"><?= lang("lang_h82") ?></label>
						<input name="img" type="file" class="form-control-file" id="image">
					</div>
					<input type="hidden" name="product_id" value="<?= $product->id ?>">
				</div>
			</div>
			<div class="modal-footer">
				<div class="loading-spinner" style="display: none;">
					<div class="spinner-border text-primary" role="status">
						<span class="sr-only"><?= lang("lang_h83") ?></span>
					</div>
					<span><?= lang("lang_h83") ?></span>
				</div>
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><?= lang("lang_h84") ?></button>
				<button id="submit-review-button" type="submit" class="btn btn-primary"><?= lang("lang_h85") ?></button>
			</div>
		</form>
	</div>
</div>


<?php $p_count = sizeof($related_products);
if ($p_count > 0) { ?>
	<!---Start-Trending products-Section-->
	<section class="ws-section-spacing">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<h2 class="title"><?= lang("lang_h10"); ?></h2>
					<div class="saprater title-bottom-spacing">
						<ul>
							<li class="saprater-box"></li>
							<li class="saprater-box"></li>
							<li class="saprater-box"></li>
						</ul>
					</div>
				</div>
			</div>

			<!--item-->
			<div class="container">
				<div class="product-slider">

					<?php foreach ($related_products as $p) { ?>

						<?php include "article.php"; ?>

					<?php } ?>
					<?php if ($p_count < 5) { ?>
						<?php for ($i = 0; $i < 5 - $p_count; $i++) { ?>
							<div></div>
						<?php } ?>
					<?php } ?>

				</div>
			</div>
		</div>
	</section>
<?php } ?>

<?php include_once 'footer.php'; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/js/lightslider.min.js" integrity="sha512-Gfrxsz93rxFuB7KSYlln3wFqBaXUc1jtt3dGCp+2jTb563qYvnUBM/GP2ZUtRC27STN/zUamFtVFAIsRFoT6/w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.10.0/js/lightgallery-all.js" integrity="sha512-+CEHuu5sJGrNiVDC5xQw3PiATr/eWP6I+iga0idvaNriG6jzaKY0U/t7DXAUWfJKDF1/vPfAy5KwV3RUd2vbsQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
	var is_reviewed = localStorage.getItem('reviewed_product_<?= $product->id ?>');
	if (is_reviewed) {
		$("#review-action").hide()
		$("#already-reviewed").show()
	}
</script>
<script>
	$("#reviewForm").submit(function(event) {
		event.preventDefault(); // Prevent default form submission

		// Display loading spinner
		$(".loading-spinner").show();
		$("#messageContainer").html("")
		// Serialize form data
		var formData = new FormData(this);

		// AJAX POST request
		$.ajax({
			type: "POST",
			url: "<?php echo base_url('ajax/submit_review'); ?>", // Replace with your controller's URL
			data: formData,
			processData: false,
			contentType: false,
			success: function(response) {
				const review_id = response.review_id
				localStorage.setItem('reviewed_product_<?= $product->id ?>', "true");
				// Handle success response
				$(".loading-spinner").hide();
				// Clear form fields
				$("#reviewForm")[0].reset();
				$("#form-body").hide()
				$("#submit-review-button").hide()
				$("#messageContainer").html('<div class="alert alert-success"><?php echo lang("lang_h17"); ?></div>');
			},
			error: function(response) {
				// Handle error
				$(".loading-spinner").hide();
				// Show error message or perform other error handling
				console.log(response.responseJSON)
				$("#messageContainer").html('<div class="alert alert-danger">' + response.responseJSON.errors + '</div>');
			}
		});
	});
</script>