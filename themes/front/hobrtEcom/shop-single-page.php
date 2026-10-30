<?php include_once "header.php"; ?>

<section class="">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="d-flex align-items-center mt-5 mb-5">
					<img class="rounded-circle shadow-sm mr-2" src="<?= $image !== null && $image != "" ? base_url("images/" . $image) : base_url("assets/img/default_image.jpg") ?>" style="width:100px;height:100px;flex: none;" />
					<div style="flex:1 1 auto">
						<h3><?= $title ?></h3>
						<?php if(isset($description))?><p class="m-0 d-none d-md-block"><?= $description ?></p>
					</div>
				</div>
				<h2 class="title"><?= $total?> <?= lang("lang_h86") ?></h2>
				<div class="saprater bottom-spacing">
					<ul>
						<li class="saprater-box"></li>
						<li class="saprater-box"></li>
						<li class="saprater-box"></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="row">
			<div class=" col-lg-12">
				<div class="row">

					<?php foreach ($products as $p) : ?>

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

					<?php endforeach; ?>

				</div>
				<?php if (isset($links)) echo $links; ?>
			</div>
		</div>
	</div>
</section>


<?php include_once "footer.php"; ?>