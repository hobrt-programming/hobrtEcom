<?php include_once 'header.php'; ?>

<style>
	.gallery-thumbnails { padding: 0 34px; }
	.gallery-thumbnails .swiper-slide { opacity: .6; cursor: pointer; }
	.gallery-thumbnails .swiper-slide-thumb-active { opacity: 1; }
	.gallery-thumbnails .swiper-button-next, .gallery-thumbnails .swiper-button-prev { width: 24px; margin-top: -14px; }
	.gallery-thumbnails .swiper-button-next:after, .gallery-thumbnails .swiper-button-prev:after { font-size: 20px; }
	.review-card .review-image { max-width: 100%; max-height: 160px; border-radius: .25rem; margin-top: .5rem; }
</style>

<script>
	if(typeof fbq !== 'undefined')
		fbq('track', 'ViewContent');

</script>
			<!-- Main -->
			<section>
			<div class="container mt-5">
    <div class="row d-flex">
	<div class="col-12 col-md-12 col-lg-5 col-xl-5">
    <div class="main-offer">
        <div class="offer-top border rounded">
            <div class="swiper-container gallery-top-thumbnails">
                <div class="swiper-wrapper">
                    <!-- Slide 1 -->
					<?php $images = explode(",", $product->images);
						if ($product->images !== null && $product->images != "" && sizeof($images) > 0)
							foreach ($images as $img) { ?>
                    <div class="swiper-slide">
                        <img src="<?php echo base_url("uploads") . "/" . add_thumb($img, "_m") ?>" class="img-thumbnail swiper-img-thumbnail" width="100%" alt="img">
                    </div>
					<?php }
						else { ?>
						<div class="swiper-slide">
                        <img src="assets/hbtheme/assets/img/no-image.png" class="img-thumbnail swiper-img-thumbnail" width="100%" alt="img">
                    </div>
					<?php } ?>
                </div>
            </div>
        </div>
        <div class="swiper-container gallery-thumbnails mt-2">
            <div class="swiper-wrapper">
                <!-- Thumbnail -->
				<?php $images = explode(",", $product->images);
						if ($product->images !== null && $product->images != "" && sizeof($images) > 0)
							foreach ($images as $img) { ?>
                <div class="swiper-slide">
                    <img src="<?php echo base_url("uploads") . "/" . add_thumb($img, "_m") ?>" class="img-thumbnail swiper-slide-img-thumbnail" width="100%">
                </div>
				<?php } ?>
                </div>
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
                </div>
                </div>
                </div>
                    <div class="col-12 col-md-12 col-lg-7 col-xl-7 my-2">
                        <div class="product p-4 rounded">
                            <div class="mt-4 mb-3"> <span class="text-uppercase text-muted brand"><?= lang("lang_h69") ?> - <?php echo get_info('cats', $product->cat, 'title'); ?></span>
                                <h5 class="text-uppercase"><?php echo $product->title; ?></h5>
								<div class="Start">
								<ul class="item-rating p-0">
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
										<li><i class="fas fa-star-half-alt"></i></li>
									<?php endif; ?>

									<?php for ($i = 1; $i <= $unfilledStars; $i++) : ?>
										<li><i class="far fa-star"></i></li>
									<?php endfor; ?>
								</ul>
							</div>
                                <div class="price d-flex flex-row align-items-center"> <span class="act-price"><?php echo format_money($product->price - ($product->price * $product->discount / 100)); ?></span>
								<?php if ($product->discount > 0) : ?> 
								<div class="mx-2"> <small class="dis-price"><?php echo format_money($product->price); ?></small> <span class="bg-warning rounded-pill p-1">-<?php echo $product->discount; ?>%</span> </div>
								<?php endif; ?>
                                </div>
                            </div>
                            <p class="about"><?php echo $product->descr; ?></p>

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

						    <div class="p-button mini-cart-item d-flex align-items-center ">
								<div class="product_quantity" style="margin-right: 20px;">
								<div class="quanty_form">
									<div class="product-quantity d-flex">
										<button type="button" class="sub subQty">-</button>
										<input type="text" value="1" name="qty" />
										<button type="button" class="add addQty">+</button>
									</div>
								</div>
							</div>
							</div>
                            <div class="cart mt-4 align-items-center">
							<a  onclick="addToCart(1);"><button class="btn btn-danger text-uppercase mr-2 px-4"><?= lang("lang_h72") ?></button></a>
							<a  onclick="addToCart(2);"><button class="btn btn-primary text-uppercase mr-2 px-4"><?= lang("lang_h51") ?></button></a>
							<i class="fa fa-heart text-muted"></i>
							<i class="fa fa-share-alt text-muted"></i>
						    </div>

						</form>
                        </div>
                    </div>
				</div>
				<div class="row mt-4">
					<div class="text-center col-12 p-3 bg-light rounded">
						<h3 class="title"><?= lang("lang_h14") ?></h3>
						<hr class="bg-primary m-1"></hr>
						<div class="pt-1">
							<div id="container-to-hide" class="container p-0">
								<p class="text-muted"><?= count(($reviews)) ?> <?= lang("lang_h74") ?></p>
								<?php if (empty($reviews)) : ?>
									<div class="col-md-12">
										<div class="alert alert-info" role="alert">
										<?= lang("lang_h75") ?>
										</div>
									</div>
								<?php else : ?>
								<div class="row g-3 text-start">
									<?php foreach ($reviews as $review) : ?>
									<div class="col-12 col-md-6 col-lg-4">
										<div class="card h-100 border-0 shadow-sm review-card">
											<div class="card-body">
												<h5 class="card-title mb-1"><?= html_escape($review->name) ?></h5>
												<div class="text-warning mb-2"><?= str_repeat("&#9733;", $review->rating) . str_repeat("&#9734;", 5 - $review->rating) ?></div>
												<p class="card-text mb-0"><?= $review->comment !== null && trim($review->comment) !== "" ? nl2br(html_escape(trim($review->comment))) : lang("lang_h76") ?></p>
												<?php if ($review->img !== null && $review->img != "") : ?>
													<img class="review-image" src="<?= base_url("images/" . rawurlencode((string) $review->img)) ?>" alt="">
												<?php endif; ?>
											</div>
										</div>
									</div>
									<?php endforeach; ?>
								</div>
								<?php endif; ?>
								<div id="already-reviewed" class="container" style="display: none;">
								<div class="alert alert-warning" role="alert"><span><strong><?= lang("lang_h77") ?></div>
								</div>
								<button id="review-action" onclick="showModal()" type="button" class="btn mt-3" data-toggle="modal" data-target="#reviewModal" style="background-color: <?= setting("color") ?>;color:white">
									<i class="fas fa-plus-circle"></i> <?= lang("lang_h78") ?>
								</button>
							</div>
							</div>
							<!-- add review form -->
						<div class="modal-dialog d-none text-center" id="custom-modal-dialog">
						<form id="reviewForm" method="post" enctype="multipart/form-data" class="modal-content">
						<button type="button" class="btn btn-secondary py-1" onclick="showReviews()"><i class="fas fa-share"></i> <?= lang("lang_h111") ?></button>
							<div class="header my-1">
								<h5 class="title" id="reviewModalLabel"><?= lang("lang_h78") ?></h5>
							</div>
							<div class="body">
							<div id="messageContainer"></div>
								<div id="form-body">
									
									<div class="form-group pb-1">
										<input name="name" type="text" class="form-control" id="name" placeholder="<?= lang("lang_h22") ?>" required>
									</div>
									<div class="form-group pb-1">
										<input name="email" type="email" class="form-control" id="email" placeholder="<?= lang("lang_h79") ?>" required>
									</div>
									<div class="form-group pb-1">
										<select name="rating" class="form-control" id="rating" required>
											<option value="5">&#9733; &#9733; &#9733; &#9733; &#9733;</option>
											<option value="4">&#9733; &#9733; &#9733; &#9733;</option>
											<option value="3">&#9733; &#9733; &#9733;</option>
											<option value="2">&#9733; &#9733;</option>
											<option value="1">&#9733;</option>
										</select>
									</div>
									<div class="form-group pb-1">
										<textarea name="comment" class="form-control" id="comment" rows="2" placeholder="<?= lang("lang_h81") ?>"></textarea>
									</div>
									<div class="form-group">
									<label for="image" id="image-label" class="btn btn-primary">
									<i class="fas fa-upload"></i> <?= lang("lang_h82") ?>
								    </label>
								    <input name="img" type="file" class="form-control-file d-none" id="image" accept="image/*">
								    <div id="image-frame" class="my-3 rounded h-100" style="height: 50px;">
								</div>
									</div>
									<input type="hidden" name="product_id" value="<?= $product->id ?>">
								</div>
							</div>
							<div class="text-center">
								<div class="loading-spinner" style="display: none;">
									<div class="spinner-border text-primary" role="status">
										<span class="sr-only"><?= lang("lang_h83") ?></span>
									</div>
									<span><?= lang("lang_h83") ?></span>
								</div>
								<button id="submit-review-button" type="submit" class="btn btn-primary"><?= lang("lang_h85") ?></button>
							</div>
						</form>
					</div>
					<!-- end add review form -->
					</div>
                </div>
            </div>
		</section>
<section>
	<div class="container shadow-1 my-2 py-2 rounded bg-light">
		<div class="text-center p-1">
	<h3 class="title"><?= lang("lang_h10"); ?></h3>
	</div>
<div class="row p-2">
<?php foreach ($related_products as $p) { ?>
	<div class="col-md-3 col-sm-6 my-2">
<div class="product-grid h-100 bg-white">
    <div class="product-image">
        <a href="<?= base_url("product/$p->slug"); ?>" class="image">
            <img class="pic-1" src="<?= $p->images !== null && $p->images != "" ? base_url('uploads/' . add_thumb($p->images, "_m")) : base_url("assets/img/default_product.png"); ?>" alt="<?= $p->title; ?>">
        </a>
        <?php if ($p->discount != 0) : ?>
            <span class="product-discount-label" style="background:<?= setting("color") ?>"><?= $p->discount; ?>%</span>
        <?php endif; ?>
        <ul class="product-links">
            <li><a href="#" data-tip="Add to Wishlist"><i class="fas fa-heart"></i></a></li>
        </ul>
    </div>
    <div class="product-content">
        <ul class="rating" style="color:<?= setting("color") ?>">
            <?php
            $rating = $p->review;
            $filledStars = floor($rating);
            $hasHalfStar = ($rating - $filledStars) >= 0.5;
            $unfilledStars = 5 - $filledStars - ($hasHalfStar ? 1 : 0);
            ?>
            <?php for ($j = 1; $j <= $filledStars; $j++) : ?>
                <li><i class="fas fa-star"></i></li>
            <?php endfor; ?>
            <?php if ($hasHalfStar) : ?>
                <li><i class="fas fa-star-half-alt"></i></li>
            <?php endif; ?>
            <?php for ($j = 1; $j <= $unfilledStars; $j++) : ?>
                <li><i class="far fa-star"></i></li>
            <?php endfor; ?>
        </ul>
        <h3 class="title"><a href="<?= base_url("product/$p->slug"); ?>" data-setting-color="<?= setting("color") ?>"><?= $p->title; ?></a></h3>
        <div class="price" style="color:<?= setting("color") ?>">
            <?php if ($p->discount != 0) : ?>
            	<span><?= $p->price; ?> <?= $currency; ?></span>
            	<?= round($p->price - ($p->price * $p->discount / 100), 2); ?> <?= $currency; ?>
            <?php else : ?>
            	<?= $p->price; ?> <?= $currency; ?>
            <?php endif; ?>
        </div>
        <a class="add-to-cart" style="background:<?= setting("color") ?>" href="<?= base_url("product/$p->slug"); ?>"><?= lang("lang_h51") ?></a>
    </div>
</div>
</div>
<?php } ?>
        </div>
		</div>
		</section>


			

<?php include_once 'footer.php'; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/js/lightslider.min.js" integrity="sha512-Gfrxsz93rxFuB7KSYlln3wFqBaXUc1jtt3dGCp+2jTb563qYvnUBM/GP2ZUtRC27STN/zUamFtVFAIsRFoT6/w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.10.0/js/lightgallery.min.js" integrity="sha512-gDBgGPXSeC2hx1W3S1CfSHbAValtLI8OArTGf0UVX7Fwb9Ak7HUE3LK9UEZxKGYVrIe0CJUVZDk9B2dIPwJ6VQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.10.0/js/lightgallery-all.js" integrity="sha512-+CEHuu5sJGrNiVDC5xQw3PiATr/eWP6I+iga0idvaNriG6jzaKY0U/t7DXAUWfJKDF1/vPfAy5KwV3RUd2vbsQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/izimodal/1.5.1/js/iziModal.min.js"></script>

<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>

<?php
// review moderation buttons post to admin/*, which requires the CSRF token
if (is_admin()) $this->load->view('enAdmin/inc/csrf');
?>

<script type="text/javascript">

function approve_c(hada, id) {
	hadaj = $(hada);
	$.post(base_url + "/admin/approve_comment", {id : id}, function(data) {
		if(data == 1)
		{
			hadaj.remove();
		}
	})
}

function showModal() {
    // Get references to the modal dialog and the container to hide
    var modalDialog = document.getElementById("custom-modal-dialog");
    var containerToHide = document.getElementById("container-to-hide");

    // Toggle the 'd-none' class for the modal dialog and container
    modalDialog.classList.toggle("d-none");
    containerToHide.classList.toggle("d-none");
}

function showReviews() {
    // Get references to the modal dialog and the container to hide
    var modalDialog = document.getElementById("custom-modal-dialog");
    var containerToHide = document.getElementById("container-to-hide");

    // Toggle the 'd-none' class for the modal dialog and container
    modalDialog.classList.toggle("d-none");
    containerToHide.classList.toggle("d-none");
}


function delete_c(hada, id) {
	hadaj = $(hada);
	$.post(base_url + "/admin/delete_comment", {id : id}, function(data) {
		if(data == 1)
		{
			hadaj.parent().parent().parent().remove();
			$('.grid').masonry({
			  // options
			  itemSelector: '.grid-item',
			});
		}
	})
}



$("#modal-custom").iziModal();

$('.grid').masonry({
  // options
  itemSelector: '.grid-item',
});

</script>


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
var imageLabel = document.getElementById("image-label");
var imageInput = document.getElementById("image");
var imageFrame = document.getElementById("image-frame");

imageLabel.addEventListener("click", function() {
    imageInput.click();
});

imageInput.addEventListener("change", function() {
    if (imageInput.files && imageInput.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            var uploadedImage = document.createElement("img");
            uploadedImage.src = e.target.result;
            uploadedImage.classList.add("img-fluid");

            while (imageFrame.firstChild) {
                imageFrame.removeChild(imageFrame.firstChild);
            }

            imageFrame.appendChild(uploadedImage);
        };

        reader.readAsDataURL(imageInput.files[0]);
    }
});

</script>