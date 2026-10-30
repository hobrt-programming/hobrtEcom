<?php include_once 'header.php'; ?>
		<!--Start WEBSITE-DESCRIPTION -->
		<div class="header-v">
			<div class="overly">
				<div class="container">
					<div class="col-sm-12">
						<h1 class="text-center"> <strong><?php echo setting("title"); ?></strong> </h1>
						<p class="text-center"><?php echo setting("descr"); ?></p>
						<div class="button-modal">
							<a href="<?php echo site_url('home/products'); ?>"><?=lang("lang_h3");?></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End WEBSITE DESCRIPTION -->
	</header>

	<!-- Start Latest product -->
	<section class="latest-product">
		<div class="container pb-2" style="background-color: white;margin-top: -83px;">
			<h3 class="text-left"><?=lang("lang_h2");?></h3>
			<p class="m-3"><span class="bg-success p-1 rounded"><?=lang("lang_h3");?>
			<svg class="bi bi-filter" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
			<path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"></path>
		</svg>
		</span></p>

			<div class="row">

				<?php foreach($latest_products as $p) : ?>

				<div class="col-sm-4">
					<div class="product-img">
					<a href="<?php echo base_url("product/$p->slug"); ?>">
					<div class="box rounded-2">
						<div>
							<?php if($p->discount != 0){ ?><span class="sale"><?=lang("lang_h5");?> <?php echo $p->discount; ?>%</span><?php } ?>
						</div>
						<img src="<?php echo base_url("uploads/".add_thumb($p->images , "_m")); ?>" class="img-responsive">
					</div>
					</a>
					<a href="<?php echo base_url("product/$p->slug"); ?>"><h4><?php echo $p->title; ?></h4></a>
						
					<?php if($p->discount != 0){ ?>

					<span class="sale-price"><?php echo $p->price; ?> <?=$currency;?></span>
					<span><?php echo floor($p->price - ($p->price * $p->discount / 100)); ?> <?=$currency;?></span>

					<?php }else{ ?>
						<span><?php echo $p->price; ?> <?=$currency;?></span>
					<?php } ?>

					<hr>
					<a href="<?php echo base_url("product/$p->slug"); ?>" class="btn" ><?=lang("lang_h8");?></a>
					<a class="category p-1 rounded-2" href="#"><span style="font-size: 10px;"><?php echo get_info('cats', $p->cat, 'title'); ?>
					<svg class="bi bi-tags-fill" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
					<path d="M2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586V2zm3.5 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"></path>
					<path d="M1.293 7.793A1 1 0 0 1 1 7.086V2a1 1 0 0 0-1 1v4.586a1 1 0 0 0 .293.707l7 7a1 1 0 0 0 1.414 0l.043-.043-7.457-7.457z"></path>
					</svg>
					</span></a>
				</div>
				</div>

				<?php endforeach; ?>

			</div><!-- ROW -->
				
			<div class="text-center">
				<a href="<?php echo base_url("home/products"); ?>" class="btn mt-4"><?=lang("lang_h98");?></a>
			</div>
		</div>
	</section>
	<!-- End Latest product -->

	<!-- Start NEWSLETTER -->
	<?php if (newsletter_enabled()) : ?>
	<section class="newsletter text-center">
		<div class="container-fluid">
			<div class="row">

				<div class="col-sm-12">
					<h3><?=lang("lang_h46");?></h3>
					<p><?=lang("lang_h99");?></p>
				</div>

				<div class="col-sm-6 col-sm-push-3">
					<form class="input-group" action="<?= base_url("ajax/subscribe") ?>" method="post" data-newsletter data-error="<?= html_escape(lang("lang_h116")) ?>">
						<input type="email" name="email" required maxlength="250" class="form-control" placeholder="<?=lang("lang_h100");?>">
						<div class="input-group-btn">
							<button type="submit" class="btn"><?=lang("lang_h47");?></button>
						</div>
					</form>
					<p class="small" style="margin-top:8px" data-newsletter-msg></p>
				</div>

			</div>
		</div>
	</section>
	<?php endif; ?>
	<!-- End NEWSLETTER -->

<?php include_once 'footer.php'; ?>