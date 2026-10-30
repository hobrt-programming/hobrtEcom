<?php include_once 'header.php'; ?>

</header>

<!-- Start Latest product -->
<section class="latest-product">
	<div class="container">
		<h3 class="text-left"><?php echo $title; ?></h3>

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

				<a href="<?php echo base_url("home/product/$p->slug"); ?>" class="btn" ><?= lang("lang_h8") ?></a>
			</div>
			</div>
			
			<?php endforeach; ?>

		</div><!-- ROW -->
			
	</div>
</section>
<!-- End Latest product -->


<?php include_once 'footer.php'; ?>