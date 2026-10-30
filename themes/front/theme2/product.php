<?php include_once 'header.php'; ?>


</header>


<section class="product-single">

	<div class="container pb-2">

		<ol class="breadcrumb">
			<li class="active"><?php echo $product->title; ?></li>
		</ol>

		<div class="row">
			<div class="col-md-6">
				<div class="product-img">

					<div id="carousel-example-generic2" class="carousel slide" data-ride="carousel">
						<!-- Indicators -->
						<div class="carousel-indicators">
							<?php

							$images = explode(",", $product->images);

							foreach($images as $k => $img) {
							?>
								<img data-target="#carousel-example-generic2" data-slide-to="<?php echo $k; ?>" class="<?php if($k == 0) echo 'active'; ?>" src="<?php echo base_url("uploads")."/".add_thumb($img , "_m") ?>" width="50px" height="50px">
							<?php } ?>
						</div>


						<!-- Wrapper for slides -->
						<div class="carousel-inner" role="listbox">

							<?php foreach($images as $k => $img) { ?>

							<div class="item <?php if($k == 0) echo 'active'; ?>">
								<!-- START ITEMS -->
								<img src="<?php echo base_url("uploads/" . $img); ?>" class="img-responsive">
								<!-- END ITEMS -->

							</div>

							<?php } ?>

						</div>

					</div><!-- End slider -->
				</div><!-- Product img -->
			</div>

			<div class="col-md-6">
				<h2><?php echo $product->title; ?></h2>

				<p class="stars">
							<span><?= lang("lang_h14") ?>: </span>
							<?php
							$productId = $product->id; // Assuming $product->id is the product ID.
							
							// Fetch reviews for the product from your database
							$reviews = $this->db->where('product_id', $productId)->get('reviews')->result();
							
							// Calculate the average rating
							$totalRatings = count($reviews);
							$totalRatingSum = 0;
							
							foreach ($reviews as $review) {
								$totalRatingSum += $review->rating;
							}
							
							$averageRating = ($totalRatings > 0) ? ($totalRatingSum / $totalRatings) : 0;
							
							// Calculate the number of filled, half-filled, and unfilled stars
							$filledStars = floor($averageRating);
							$hasHalfStar = ($averageRating - $filledStars) >= 0.5;
							$unfilledStars = 5 - $filledStars - ($hasHalfStar ? 1 : 0);
							?>
							
							<?php for ($i = 1; $i <= $filledStars; $i++) : ?>
								<i class="fas fa-star" style="color: #fbbf00"></i>
							<?php endfor; ?>
							
							<?php if ($hasHalfStar) : ?>
								<i class="fas fa-star-half-alt" style="color: #fbbf00"></i>
							<?php endif; ?>
							
							<?php for ($i = 1; $i <= $unfilledStars; $i++) : ?>
								<i class="far fa-star" style="color: #fbbf00"></i>
							<?php endfor; ?>
						    </p>

				<h3>

					<?php if($product->discount != 0){ ?>
					<del class="text-muted" style="font-size:.8em;"><?php echo $product->price; ?> <?=$currency;?></del> <?php echo floor($product->price - ($product->price * $product->discount / 100)); ?> <?=$currency;?>
					<?php }else{ ?>
						<?php echo $product->price; ?> <?=$currency;?>
					<?php } ?>

				</h3>

				<div class="product-content">
					<?php echo $product->descr; ?>
				</div>
			</div>

		</div><!-- / .ROW -->

		<div class="product-single-description">
			<div class="row d-form" style="justify-content: center;">
				<div class="col-md-10">

					<!-- Tab panes -->
					<div class="">

						<div class="center m-3" id="sticker_stop">
						<a class="btn btn-success btn-xl js-scroll-trigger" role="button" id="toggleButton"><i class="fas fa-shopping-basket"></i> <?= lang("lang_h8") ?></a>
						</div>

						<div id="buy" style="display: none;">
							<div class="form">
								<form action="<?php echo site_url("cart"); ?>" method="post" id="orderNow">
									<label for='name'><?= lang("lang_h22") ?>: </label>
									<input type="text" name="fullname" id="name" class="form-control" placeholder="<?= lang("lang_h60") ?>" >

									<label for='address'><?= lang("lang_h24") ?></label>
									<input type="text" name="address" id="address" class="form-control" placeholder="<?= lang("lang_h108") ?>" >

									<label for='tel'><?= lang("lang_h23") ?></label>
									<input type="text" name="phone" id="tel" class="form-control" placeholder="<?= lang("lang_h23") ?>" >

									<label for='city'><?= lang("lang_h25") ?></label>
									<input type="text" name="city" id="city" class="form-control" placeholder="<?= lang("lang_h109") ?>" >

									
								</form>


								<form id="formData">

									<input type="hidden" name="id" value="<?php echo $product->id ?>">

									<label for='qte'><?= lang("lang_h7") ?></label>
									<div class="qte">
										<span id="minus-qte"><i class="fas fa-minus"></i></span>
										<input type="text" value="1" min="1" max="100" id="qte" name="qte">
										<span id="plus-qte"><i class="fas fa-plus"></i></span>
									</div>

									<?php

									$variants = json_decode($product->variants, TRUE) ?? [];

									if(count($variants) > 0){

									?>
									
									<?php foreach ($variants as $key => $value) { ?>

									<div class="abgne-menu-20140101-1">
										<span><b><?php echo $value['tp']; ?> : </b></span>

										<?php

										$opt = explode(",", $value['info']);

										foreach($opt as $i => $k) : 
										?>

										<input type="radio" id="for_<?=$key;?>_<?=$i;?>" name="option[<?php echo bin2hex(base64_encode($value['tp'])); ?>]" value="<?php echo $k; ?>">
										<label for="for_<?=$key;?>_<?=$i;?>"><?php echo $k; ?></label>

										<?php endforeach; ?>

									</div>
									<br>



									<?php } ?>
									

									<div class="clear"></div>

									<?php } ?>

									</form>



									<input type="submit" class="btn orderClick" value="<?= lang("lang_h61") ?>" >

							</div>
						</div>
					</div>

				</div> <!-- / .col-md-10 -->
			</div><!-- /.row -->
		</div><!-- / .product-single-description -->
	</div><!-- / .container -->
</section>

<section class="pt-4">
	<div class="container pb-4 mt-3">
	<?php if (count($reviews) > 0) : ?>
	<div class="center m-3" id="sticker_stop">
		<h3 class="bg-success p-1 rounded"><?= count(($reviews)) ?> <?= lang("lang_h74") ?></h3>
		</div>
		<?php endif; ?>
		<?php if (empty($reviews)) : ?>
			<div class="col-md-12">
				<div class="alert alert-info m-3" role="alert">
				<?= lang("lang_h75") ?>
				</div>
			</div>
		<?php else : ?>
			<div class="row">
				<?php foreach ($reviews as $review) : ?>
					<div class="col-sm-6 col-md-4">
						<div  style="height: 100%;">
					<div class="thumbnail">
					<?php if($review->img !== null && $review->img != "") { ?>
					<img src="<?= base_url("images/" . rawurlencode((string) $review->img)) ?>" alt="<?= html_escape($review->name) ?>">
					<?php } ?>
					<div class="caption">
						<h3><i class="far fa-user-circle"></i> <?= html_escape($review->name) ?></h3>
						<p><?= $review->comment !== null && $review->comment != "" ? nl2br(html_escape($review->comment)) :lang("lang_h76") ?></p>
						<p><a class="btn btn-light" role="button">
							<span class="text-warning stars">
							<?php
							$rating = $review->rating;
							echo str_repeat("&#9733;", $rating) . str_repeat("&#9734;", 5 - $rating);?></span></a></p>
					</div>
					</div>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<div id="already-reviewed" style="display: none;">
		<div class="alert alert-warning" role="alert"><span>
		<svg class="bi bi-check2-circle" xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" fill="currentColor" viewBox="0 0 16 16">
		<path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"></path>
		<path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"></path>
	    </svg>	
		<strong><?= lang("lang_h77") ?></div>
		</div>
		<button id="review-action" type="button" class="btn mt-3 m-3" data-toggle="modal" data-target="#reviewModal" style="background-color: <?= setting("color") ?>;color:white">
			<i class="fas fa-plus-circle"></i> <?= lang("lang_h78") ?>
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
					<div class="spinner-border text-success" role="status">
						<span class="sr-only"><?= lang("lang_h83") ?></span>
					</div>
					<span><?= lang("lang_h83") ?></span>
				</div>
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><?= lang("lang_h84") ?></button>
				<button id="submit-review-button" type="submit" class="btn btn-success"><?= lang("lang_h85") ?></button>
			</div>
		</form>
	</div>
</div>

<?php if (!empty($related_products)) : ?>
<section class="latest-product">

	<div class="container">
		<hr>

		<h3 class="text-center"><?= lang("lang_h102") ?></h3>

		<div class="row">

			<?php foreach($related_products as $p) : ?>

				<div class="col-sm-3 col-xs-6">
								<div class="box">
									<a href="<?php echo base_url("home/product/$p->slug"); ?>">
									<img src="<?php echo base_url("uploads/".add_thumb($p->images , "_m")); ?>" class="img-responsive">
									<?php if($p->discount != 0){ ?><span class="sale"><?php echo $p->discount; ?>%</span><?php } ?>
									<div class="box-information">

										<h4><?php echo $p->title; ?></h4>

										<?php if($p->discount != 0){ ?>

											<span class="sale-price"><?php echo $p->price; ?> <?=$currency;?></span>
											<span><?php echo floor($p->price - ($p->price * $p->discount / 100)); ?> <?=$currency;?></span>

										<?php }else{ ?>
											<span><?php echo $p->price; ?> <?=$currency;?></span>
										<?php } ?>
										
										<div class>
											<a href="<?php echo base_url("product/$p->slug"); ?>" class="btn"><?= lang("lang_h8") ?></a>
										</div>
									</div>
									</a>
								</div>
							</div>


			<?php endforeach; ?>

		</div><!-- / . row -->
	</div><!-- / .container -->
</section>
<?php endif; ?>

<?php include_once 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/sticksy@latest/dist/sticksy.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/js/lightslider.min.js" integrity="sha512-Gfrxsz93rxFuB7KSYlln3wFqBaXUc1jtt3dGCp+2jTb563qYvnUBM/GP2ZUtRC27STN/zUamFtVFAIsRFoT6/w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.10.0/js/lightgallery.min.js" integrity="sha512-gDBgGPXSeC2hx1W3S1CfSHbAValtLI8OArTGf0UVX7Fwb9Ak7HUE3LK9UEZxKGYVrIe0CJUVZDk9B2dIPwJ6VQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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

<script>


	function sticky_relocate() {
	    var window_top = $(window).scrollTop();
	    var footer_top = $("#sticker_stop").offset().top - 120;
	    var div_top = $('#nev-bar').offset().top;
	    var div_height = $("#sticky").height();
	    
	    var padding = 20;  // tweak here or get from margins etc
	    
	    if (window_top + div_height > footer_top - padding)
	        $('#sticky').css({top: (window_top + div_height - footer_top + padding) * -1})
	    else if (window_top > div_top) {
	        $('#sticky').addClass('stick');
	        $('#sticky').css({top: 100})
	    } else {
	        $('#sticky').removeClass('stick');
	    }
	}

	$(function () {
	    $(window).scroll(sticky_relocate);
	    sticky_relocate();
	});

</script>