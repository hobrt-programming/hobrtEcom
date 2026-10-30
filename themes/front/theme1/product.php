<?php include_once 'header.php'; ?>


<script>
	if(typeof fbq !== 'undefined')
		fbq('track', 'ViewContent');

</script>


<!--Start WEBSITE-DESCRIPTION -->
<div class="header-p">
	<div class="overly">
		<div class="container">
			<h1><?php echo $product->title; ?></h1>
		</div>
	</div>
	<!-- End WEBSITE DESCRIPTION -->
</header>

<section class="product-single">
	<div class="container">
		<div class="row">

			<div class="col-md-5">

				<div class="product-img">

				<!-- Start Slider -->
<div id="carousel-example-generic2" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <?php
        $images = explode(",", $product->images);

        if ($product->images !== null && $product->images != "" && sizeof($images) > 0) {
            foreach ($images as $k => $img) {
                $activeClass = ($k === 0) ? 'active' : '';
        ?>
                <li data-target="#carousel-example-generic2" data-slide-to="<?php echo $k; ?>" class="<?php echo $activeClass; ?>"></li>
        <?php
            }
        }
        ?>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
        <?php
        if ($product->images !== null && $product->images != "" && sizeof($images) > 0) {
            foreach ($images as $k => $img) {
                $activeClass = ($k === 0) ? 'active' : '';
        ?>
                <div class="item <?php echo $activeClass; ?>">
                    <!-- START ITEMS -->
                    <img src="<?php echo base_url("uploads/" . $img); ?>" class="img-responsive" alt="Product Image">
                    <!-- END ITEMS -->
                </div>
        <?php
            }
        } else {
        ?>
            <div class="item active">
                <!-- START ITEMS -->
                <img src="<?= base_url("assets/img/default_product.png") ?>" class="img-responsive" alt="Default Product Image">
                <!-- END ITEMS -->
            </div>
        <?php
        }
        ?>
    </div>

    <?php if (sizeof($images) > 1) { ?>
        <!-- Controls -->
        <a class="left carousel-control" href="#carousel-example-generic2" role="button" data-slide="prev">
            <span style="position: absolute; top: 50%; right: 50%; left: auto; margin-left: auto; margin-right: -10px; margin-top: -10px;" aria-hidden="true">
			<svg class="bi bi-chevron-right" xmlns="http://www.w3.org/2000/svg" width="2.5em" height="2.5em" fill="currentColor" viewBox="0 0 16 16">
			<path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"></path>
		</svg>
		</span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic2" role="button" data-slide="next">
            <span style="position: absolute;top: 50%;right: auto; left: 50%; margin-right: initial; margin-left: -10px;margin-top: -10px;" aria-hidden="true">
			<svg class="bi bi-chevron-left" xmlns="http://www.w3.org/2000/svg" width="2.5em" height="2.5em" fill="currentColor" viewBox="0 0 16 16">
			<path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"></path>
		</svg>
		</span>
        </a>
    <?php } ?>
</div><!-- End slider -->


				</div><!-- Product img -->
			</div><!--Col-md-6 -->
			<div class="col-md-7" id="tabs">

				<div>

					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#description" aria-controls="home" role="tab" data-toggle="tab"><?= lang("lang_h73") ?></a></li>
						<li role="presentation"><a href="#buy" aria-controls="buy" role="tab" data-toggle="tab"><?= lang("lang_h72") ?></a></li>
					</ul>

					<!-- Tab panes -->
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="description">
							<div>
								<h2><?php echo $product->title; ?></h2><br>
								<p><span class="bg-success rounded">
								<svg class="bi bi-tags-fill" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
								<path d="M2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586V2zm3.5 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"></path>
								<path d="M1.293 7.793A1 1 0 0 1 1 7.086V2a1 1 0 0 0-1 1v4.586a1 1 0 0 0 .293.707l7 7a1 1 0 0 0 1.414 0l.043-.043-7.457-7.457z"></path>
							    </svg>	
								<?= lang("lang_h69") ?> - <?php echo get_info('cats', $product->cat, 'title'); ?></span></p>
								<h3><span><?= lang("lang_h106") ?>: </span> <?php if($product->discount != 0){ ?>

							<span class="sale-price"><?php echo $product->price; ?> <?=$currency;?></span>
							<span><?php echo floor($product->price - ($product->price * $product->discount / 100)); ?> <?=$currency;?></span>

							<?php }else{ ?>
								<span><?php echo $product->price; ?> <?=$currency;?></span>
							<?php } ?> </h3>
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
								<p class="description">
									
									<?php echo $product->descr; ?>

								</p>
								<ul class="list-inline">
									<li style="color: #2fad4a;font-weight: bold;"><?= lang("lang_h107") ?>: </li>
									<li style="font-size: 18px;"><a href="#" style="color:#4267B2"><i class="fab fa-facebook"></i></a></li>
									<li style="font-size: 18px;"><a href="#" style="color:#33BBE2"><i class="fab fa-twitter-square"></i></a></li>
									<li style="font-size: 18px;"><a href="#" style="color:#0073B0"><i class="fab fa-whatsapp"></i></a></li>
								</ul>

								<br>

								<a class="btn" onclick="orderTab();"><?= lang("lang_h72") ?></a>

							</div>
						</div>
						<div role="tabpanel" class="tab-pane" id="buy">
							<div>


								<form action="<?php echo site_url("cart"); ?>" method="post" id="orderNow">
									<label for='name'><?= lang("lang_h22") ?>: </label>
									<input type="text" name="fullname" id="fullname" class="form-control" placeholder="<?= lang("lang_h60") ?>" >

									<label for='address'><?= lang("lang_h24") ?></label>
									<input type="text" name="address" id="address" class="form-control" placeholder="<?= lang("lang_h108") ?>" >

									<label for='tel'><?= lang("lang_h23") ?></label>
									<input type="text" name="phone" id="tel" class="form-control" placeholder="<?= lang("lang_h23") ?>" >

									<label for='city'><?= lang("lang_h25") ?></label>
									<input type="text" name="city" id="city" class="form-control" placeholder="<?= lang("lang_h109") ?>" >

									<label for='qte'><?= lang("lang_h7") ?></label>

								</form>
								<form id="formData">

									<input type="hidden" name="id" value="<?php echo $product->id ?>">

									<div class="qte">
										<span id="minus-qte"><i class="fas fa-minus"></i></span>
										<input type="text" value="1" min="1" max="100" id="qte" name="qty">
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

				</div>

			</div>


		</div><!--ROW-->
	</div><!-- container-->
</section>

<section class="pt-4">
	<div class="container pb-4">
		<h4 class="bg-success p-1 rounded"><?= count(($reviews)) ?> <?= lang("lang_h74") ?></h4>
		<?php if (empty($reviews)) : ?>
			<div class="col-md-12">
				<div class="alert alert-info m-3" role="alert">
				<?= lang("lang_h75") ?>
				</div>
			</div>
		<?php else : ?>
			<div class="row">
				<?php foreach ($reviews as $review) : ?>
					<div class="col-12 col-sm-4 col-lg-3">
						<div class="card mb-3">
							<div class="card-image">
							<?php if($review->img !== null && $review->img != "") { ?>
									<img class="img-thumbnail" src="<?= base_url("images/" . rawurlencode((string) $review->img)) ?>" style="width: 100%; height:auto" />
								<?php } ?>
								<div class="card-content">
								<div class="card-title">
										<h5 class="card-title mb-0"><?= html_escape($review->name) ?></h5>
										<div>
											<span class="text-warning stars">
												<?php
												$rating = $review->rating;
												echo str_repeat("&#9733;", $rating) . str_repeat("&#9734;", 5 - $rating);
												?>
											</span>
										</div>
								</div>
								<p><?= $review->comment !== null && $review->comment != "" ? nl2br(html_escape($review->comment)) :lang("lang_h76") ?></p>
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

		<div class="container-fluid">
			<h3 class="text-left m-3"><span><?= lang("lang_h102") ?></span></h3>
			<div id="carousel-example-generic">

				<!-- Wrapper for slides -->
				<div role="listbox">
					<div class="item active">
						<!-- START ITEMS -->

						<?php foreach($related_products as $p) : ?>

						<div class="col-md-4 col-sm-6">
							<div class="product-img">
							<a href="<?php echo base_url("product/$p->slug"); ?>">
								<div class="box">
									<div class="box-information">
										<?php if($p->discount != 0){ ?><span class="sale"><?= lang("lang_h5") ?> <?php echo $p->discount; ?>%</span><?php } ?>
										
									</div>

									<img src="<?php echo base_url("uploads/".add_thumb($p->images , "_m")); ?>" class="img-responsive">
								</div>
								<h4><?php echo $p->title; ?></h4>
								<?php if($p->discount != 0){ ?>

								<span class="sale-price"><?php echo $p->price; ?> <?=$currency;?></span>
								<span><?php echo floor($p->price - ($p->price * $p->discount / 100)); ?> <?=$currency;?></span>

								<?php }else{ ?>
									<span><?php echo $p->price; ?> <?=$currency;?></span>
								<?php } ?>

								<hr>
								<a href="<?php echo base_url("product/$p->slug"); ?>" class="btn" ><?= lang("lang_h8") ?></a>
							</a>
						</div>
						</div>

						<?php endforeach; ?>

					</div>

				</div>
			</div>
		</section>
		<?php endif; ?>
		<div class="bottom-nav">
        <p><h4><?php echo $product->title; ?></h4><a class="btn" onclick="orderTab();"> <?= lang("lang_h8") ?> </a></p>
    </div>
<?php include_once 'footer.php'; ?>

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
	
	function orderTab() {
		$('a[href="#buy"]').tab('show');
		$("body,html").animate(
	      {
	        scrollTop: $("#tabs").offset().top - 100
	      },
	      800 //speed
	    );
	}

</script>