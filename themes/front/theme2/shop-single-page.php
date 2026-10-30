<?php include_once "header.php"; ?>
				
				<!-- Start category product -->
	<section class="latest-product">
		<div class="container pb-2" style="background-color: white;">
        <div style="margin: 10px;">        
				<div class="d-flex align-items-center mt-5 mb-5 p-2">
					<img class="rounded shadow-sm mr-2" src="<?= $image !== null && $image != "" ? base_url("images/" . $image) : base_url("assets/img/default_image.jpg") ?>" style="width:100px;height:100px;flex: none;" />
					<div>
						<h3><?= $title ?></h3>
					</div>
				</div>
                </div>
                <?php if(isset($description))?><p class="m-0 d-none d-md-block"><?= $description ?></p>
			<p class="m-3"><span class="bg-success p-1 rounded"><?= $total?> <?= lang("lang_h86") ?>
			<svg class="bi bi-filter" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
			<path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"></path>
		</svg>
		</span></p>

			<div class="row">

				<?php foreach($products as $p) : ?>

				<div class="col-sm-3">
					<div class="product-img h-100">
					<a href="<?php echo base_url("product/$p->slug"); ?>">
					<div class="box rounded-2 mb-2">
						<div>
							<?php if($p->discount != 0){ ?><span class="sale"><?= lang("lang_h5") ?> <?php echo $p->discount; ?>%</span><?php } ?>
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
					<a href="<?php echo base_url("product/$p->slug"); ?>" class="btn" ><?= lang("lang_h8") ?></a>
	
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
            <?php if (isset($links)) echo $links; ?>
            </div>
		</div>
	</section>
	<!-- End category product -->
				
		</div>
	</div>


<?php include_once "footer.php"; ?>