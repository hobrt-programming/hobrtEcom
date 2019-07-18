<?php include_once 'header.php'; ?>


			<!-- Main -->
			<div class="lx-main">
				<!-- Main Content -->
				<div class="lx-main-content">
					<div class="lx-bloc-title">
						<h3>جديد</h3>
						<p>أحدث المنتوجات المضافة إلى الموقع</p>
					</div>
					<div class="lx-products-list lx-bloc-content">
						<div class="lx-products-items">
							
							<?php $i = 0; foreach($products as $p) : $i++; ?>

							<div class="lx-g4 lx-g5-to-g2">
								<div class="lx-products-item">
									<a href="<?php echo base_url("home/show/$p->id"); ?>">
										<div class="lx-products-item-img">
											<?php if($p->discount != 0){ ?>
											<span><?php echo $p->discount; ?>%<br />OFF</span>
											<?php } ?>
											<img src="uploads/<?php echo add_thumb($p->images , "_m") ?>" />
										</div>
										<div class="lx-products-item-detail">
											<h2><?php echo $p->title; ?> </h2>
											<p>
												<ins>
												<?php if($p->discount != 0){ ?>
												<span><?php echo $p->price; ?>DH</span> <?php echo floor($p->price - ($p->price * $p->discount / 100)); ?>DH
												<?php }else{ ?>
													<?php echo $p->price; ?>DH
												<?php } ?>

												</ins>
											</p>
										</div>
									</a>
								</div>
							</div>

							<?php if($i%4 == 0) echo "<div class='lx-clear-fix'></div>"; endforeach; ?>
							<div class="lx-clear-fix"></div>
						</div>
					</div>
					<div class="lx-clear-fix"></div>
				</div>
			</div>


<?php include_once 'footer.php'; ?>