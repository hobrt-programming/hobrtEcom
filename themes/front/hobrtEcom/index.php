<?php include_once 'header.php'; ?>
<!-- start slider -->
<div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel" style="height: 400px;">
  <div class="carousel-indicators">
    <?php foreach ($slider as $key => $slid) : ?>
      <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="<?= $key ?>" <?= $key === 0 ? 'class="active"' : '' ?> aria-label="Slide <?= $key + 1 ?>"></button>
    <?php endforeach; ?>
  </div>
  <div class="carousel-inner h-100">
    <?php foreach ($slider as $key => $slid) : ?>
      <div class="carousel-item <?= $key === 0 ? 'active' : '' ?> h-100" data-bs-interval="4000">
        <img src="<?php echo $slid->img !== null && $slid->img != "" ? base_url("images/$slid->img") : base_url("assets/img/default_slider.png"); ?>" style="height: inherit;object-fit: cover;" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block bg-dark text-light rounded" style="opacity: 0.8;">
          <h5><?= $slid->title ?></h5>
          <p><?= $slid->subtitle ?></p>
          <div class="btn btn-primary"><a target="_blank" href="<?php echo $slid->link; ?>"><?= lang("lang_h41") ?></a></div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

  <!-- end slider -->

  <!-- start categories -->
<div class="container mt-3 mb-3">
<div class="text-center mx-auto my-2">
                <p class="fw-bold mb-2" style="color:<?= setting("color") ?>;"><?=lang("lang_h66");?></p>
                <h3 class="fw-bold"><?=lang("lang_h91");?></h3>
            </div>
<div class="swiper-container gallery-thumbnails swiper-container-initialized swiper-container-horizontal swiper-container-rtl swiper-container-thumbs">
<div class="swiper-wrapper" style="transition: all 0ms ease 0s; transform: translate3d(0px, 0px, 0px);">
    <!-- Thumbnails -->
	<?php foreach (all_categories() as $cat) : ?>
	    <div class="product-grid swiper-slide swiper-slide-active text-center swiper-slide-thumb-active bg-light rounded" style="margin-right: 2px; margin-bottom: 10px; width: 50px; margin-left: 2px;background:<?= setting("color") ?>"><a href="<?php echo site_url("category/$cat->slug"); ?>">
        <img src="<?php echo $cat->img != null && $cat->img != "" ? base_url("images/$cat->img") : base_url("assets/img/default_image.jpg"); ?>" alt="<?php echo $cat->title; ?>" class="img-thumbnail rounded-circle swiper-slide-img-thumbnail" width="60%" style="border: 2px solid <?= setting("color") ?>;">
		<p style="margin-right: 2px; margin-bottom: 10px; margin-left: 2px;"><?php echo $cat->title; ?></p>
        </a></div>
		<?php endforeach; ?>
	</div>
	<div class="swiper-button-next d-block text-light rounded" tabindex="0" role="button" aria-label="Next slide" aria-disabled="false" style="background: <?= setting("color") ?>;opacity: 0.7;"></div>
                    <div class="swiper-button-prev text-light rounded d-block swiper-button-disabled" tabindex="-1" role="button" aria-label="Previous slide" aria-disabled="true" style="background: <?= setting("color") ?>;opacity: 0.7;"></div>
                <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
	</div>
	<!-- end categories -->

	<section>
    <div class="container bg-primary-gradient py-5 my-2 rounded">
        <p class="fw-bold mb-2" style="color: <?= setting("color") ?>"><?= lang("lang_h2"); ?></p>
        <h3 class="fw-bold"><?= lang("lang_h3"); ?></h3>
        <div class="p-2">
            <div class="row">
                <?php foreach ($latest_products as $i => $p) : ?>
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
                    <?php if (($i + 1) % 4 == 0) : ?>
                        <div class="lx-clear-fix"></div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>


<?php include_once 'footer.php'; ?>