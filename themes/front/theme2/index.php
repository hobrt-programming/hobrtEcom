<?php include_once 'header.php'; ?>


					<!--Start WEBSITE-DESCRIPTION -->
					<div class="header-v">
						<div class="overly">
							<div class="container">
								<div class="col-sm-12">
									<h1 class="text-center"> <strong><?php echo setting('title'); ?></strong> </h1>
									<p class="text-center">
										<?php echo setting('descr'); ?>
									</p>
									<div class="button-modal">
										<a href="<?php echo site_url('home/products'); ?>"><?=lang("lang_h97");?></a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- End WEBSITE DESCRIPTION -->
				</header>

				<!-- Start Latest product -->
				<section class="latest-product">
					<div class="container">
						<h3 class="text-center"><?=lang("lang_h42");?></h3>
						<p class="text-center"><?=lang("lang_h101");?></p>

						<div class="row">

							<?php foreach($latest_products as $p) : ?>

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
											<a href="<?php echo base_url("home/product/$p->slug"); ?>" class="btn"><?= lang("lang_h8") ?></a>
										</div>
									</div>
									</a>
								</div>
							</div>

							<?php endforeach; ?>


						</div><!-- ROW -->
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





				<section class="latest-product">

					<div class="container-fluid">
						<h3 class="text-left"><?= lang("lang_h103") ?></h3>
						<p><?= lang("lang_h104") ?></p>
						<div id="carousel-example-generic">

							<!-- Wrapper for slides -->
							<div role="listbox">
								<div class="item active">
									<!-- START ITEMS -->

									<?php foreach($featured as $p) : ?>

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
														<a href="<?php echo base_url("home/product/$p->slug"); ?>" class="btn"><?= lang("lang_h8") ?></a>
													</div>
												</div>
												</a>
											</div>
										</div>

									<?php endforeach; ?>

								</div>

							</div>
						</div>
					</section>


<?php include_once 'footer.php'; ?>