<?php include_once "header.php"; ?>


<!-- End-Menu-area-->
<main class="main-div home-slider">

	<?php foreach ($slider as $slid) : ?>

		<div class="slider-bg ">
			<div class="hero-slider-content">
				<div class="container">
					<div class="row">
						<div class="col-lg-7 col-md-12 col-sm-12">
							<div class="slider-content wow fadeInUp" data-wow-delay=".25s" data-wow-duration="2s" data-wow-iteration="1">
								<h2 class="hero-sub-title"><?php echo $slid->title; ?></h2>
								<h1 class="hero-title"><?php echo $slid->subtitle; ?></h1>
								<p class="hero-text"><?php echo $slid->info; ?></p>
								<a href="<?php echo $slid->link; ?>" class="slider-btn shadow" style="border-color:<?= setting("color") ?>;background:<?= setting("color") ?>"><?= lang("lang_h41") ?></a>
							</div>
						</div>
						<div class="slider-img">
							<img src="<?php echo $slid->img !== null && $slid->img != "" ? base_url("images/$slid->img") : base_url("assets/img/default_slider.png"); ?>" class="wow fadeInRight" data-wow-delay=".25s" data-wow-duration="1s" data-wow-iteration="1" alt="">
						</div>
					</div>
				</div>
			</div>
		</div>

	<?php endforeach; ?>

</main>
<!---End-Main-Section-->
<!---Category-Section-->
<section class="section-spacing">
	<div class="container">
		<div class="row">
			<div class="client-Slider">

				<?php foreach (all_categories() as $cat) : ?>

					<div class="home-category">
						<a class="row no-gutters" href="<?php echo site_url("category/$cat->slug"); ?>">
							<div class="col-12 col-lg-4 mb-2 mb-lg-0"><img class="rounded-circle" src="<?php echo $cat->img != null && $cat->img != "" ? base_url("images/$cat->img") : base_url("assets/img/default_image.jpg"); ?>" alt="<?php echo $cat->title; ?>"></div>
							<div class="col-12 col-lg-8 d-flex align-items-center">
								<h6 class="ml-0 ml-lg-1 text-nowrap text-truncate"><?php echo $cat->title; ?></h6>
							</div>
						</a>
					</div>

				<?php endforeach; ?>

			</div>
		</div>
	</div>
</section>
<!---Category-Section-->
<!---Start-Trending-Product-section-->
<?php foreach ($collections as $collection) : ?>
	<?php $p_count = sizeof($collection->products); ?>
	<?php if($p_count>0) { ?>
	<section class="same-section-spacing pb-2">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<h2 class="title"><a href="<?= base_url("collection/$collection->slug") ?>"><?= $collection->title ?></a></h2>
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
				<div class="product-slider">
					<?php foreach ($collection->products as $p) : ?>
						<!--item-->
						<?php include "article.php"; ?>
					<?php endforeach; ?>
					
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
<?php endforeach; ?>
<!---End-Trending-Product-Section-->
<div class="p-3"></div>
<!---Category-Section-->
<?php if (sizeof($promo1) > 0) : ?>
	<section class="same-section-spacing pb-2">
		<div class="container">
			<div class="row">

				<?php foreach ($promo1 as $promo) : ?>

					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="offer-banner">
							<div class="row">
								<div class="col-lg-8 col-md-8 col-sm-8">
									<div class="offer-banner-content">
										<h3><?php echo $promo->title; ?></h3>
										<h5> <?php echo $promo->subtitle; ?></h5>
										<a href="<?php echo $promo->link; ?>"><?= lang("lang_h41") ?></a>
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-4">
									<div class="offer-banner-img wow fadeInRight" data-wow-delay=".25s" data-wow-duration="1s" data-wow-iteration="1">
										<img src="<?php echo base_url("images/$promo->img"); ?>" alt="<?php echo $promo->title; ?>">
									</div>
								</div>
							</div>
						</div>
					</div>

				<?php endforeach; ?>

			</div>
		</div>
	</section>
<?php endif; ?>

<?php foreach ($promo2 as $promo) : ?>

	<section class="ws-section-spacing banner-bg pb-2">
		<div class="container">
			<div class="row">
				<div class="col-lg-7 col-md-12 col-sm-12">
					<div class="banner-content wow fadeInUp" data-wow-delay=".25s" data-wow-duration="2s" data-wow-iteration="1">
						<h2><?php echo $promo->title; ?></h2>
						<p><?php echo $promo->subtitle; ?></p>
						<a href="<?php echo $promo->link; ?>" class="buy-now"><?= lang("lang_h41") ?></a>
					</div>
				</div>
				<div class="col-lg-5 col-md-12 col-sm-12">
					<div class="deal-img wow fadeInRight" data-wow-delay=".25s" data-wow-duration="1s" data-wow-iteration="1">
						<img src="<?php echo base_url("images/$promo->img"); ?>" alt="<?php echo $promo->title; ?>">
					</div>
				</div>
			</div>
		</div>
	</section>

<?php endforeach; ?>

<section class="ws-section-spacing pb-2">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h2 class="title"><?= lang("lang_h42") ?></h2>
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

					<?php foreach ($latest_products as $p) : ?>

						<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
							<?php include "article.php"; ?>
						</div>

					<?php endforeach; ?>

				</div>
			</div>
		</div>
	</div>
</section>

<?php include_once "footer.php" ?>