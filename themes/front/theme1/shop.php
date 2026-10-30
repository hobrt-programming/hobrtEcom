<?php include_once 'header.php'; ?>

	</header>

	<!-- Start Latest product -->
	<section class="latest-product">
		<div class="container">
			<h3 class="text-left"><?php echo isset($title) ? html_escape($title) : lang("lang_h65"); ?></h3>

			<div class="row">

				<?php foreach($products as $p) : ?>

				<div class="col-sm-4">
					<div class="product-img">
					<a href="<?php echo base_url("home/product/$p->slug"); ?>">
					<div class="box rounded-2">
						<div>
							<?php if($p->discount != 0){ ?><span class="sale"><?= lang("lang_h5") ?> <?php echo $p->discount; ?>%</span><?php } ?>
						</div>
						<img src="<?php echo base_url("uploads/".add_thumb($p->images , "_m")); ?>" class="img-responsive">
					</div>
					</a>
					<a href="<?php echo base_url("home/product/$p->slug"); ?>"><h4><?php echo $p->title; ?></h4></a>
						
					<?php if($p->discount != 0){ ?>

					<span class="sale-price"><?php echo $p->price; ?> <?=$currency;?></span>
					<span><?php echo floor($p->price - ($p->price * $p->discount / 100)); ?> <?=$currency;?></span>

					<?php }else{ ?>
						<span><?php echo $p->price; ?> <?=$currency;?></span>
					<?php } ?>

					<hr>
					<a href="<?php echo base_url("home/product/$p->slug"); ?>" class="btn" ><?= lang("lang_h8") ?></a>
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
				
		</div>
	</section>
	<!-- End Latest product -->


<?php include_once 'footer.php'; ?>