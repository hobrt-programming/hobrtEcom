<?php include_once 'header.php'; ?>

	</header>

	<!-- Start Latest product -->
	<div class="container">
		<hr>
		<div class="row">

			<?php foreach($products as $p) : ?>

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


<?php include_once 'footer.php'; ?>
