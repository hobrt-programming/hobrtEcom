<?php include_once 'header.php'; ?>

			<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/izimodal/1.5.1/css/iziModal.min.css">
			<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
			<link rel="stylesheet" type="text/css" href="assets/css/hobrt.css">
			<!-- Main -->
			<div class="lx-main">
				<!-- Main Content -->
				<div class="lx-main-content">
					<?php if(isset($msg)){ ?>
					<div class="t11">
						<?php echo $msg; ?>
					</div>
					<?php } ?>


					<?php foreach($info as $p) : ?>

					<div class="lx-g2" style="float:left;">
						<div class="lx-product-images">
							<div class="lx-product-main-img">
								<img src="<?php echo base_url("uploads")."/".add_thumb($p->images , "") ?>" data-nb="0" />
							</div>
							<ul>
								<?php

								$images = explode(",", $p->images);

								foreach($images as $img) {
								?>
								<li><img src="<?php echo base_url("uploads")."/".add_thumb($img , "_m") ?>" /></li>
								<?php } ?>
								<div class="lx-clear-fix"></div>
							</ul>
						</div>
					</div>
					<div class="lx-g2">
						<div class="lx-product-details">
							<h1> <?php echo $p->title; ?></h1>
							<?php if($p->discount > 0) { ?> <p class="lx-product-disaccount"><span>تخفيض:</span> <?php echo $p->discount; ?>% </p> <?php } ?>
							<?php if($p->discount > 0) { ?>
								<p class="lx-product-price"><span><?php echo $p->price; ?>DH</span> <?php echo floor($p->price - ($p->price * $p->discount / 100)); ?>DH</p>
							<?php }else{ ?>
								<p class="lx-product-price"><?php echo $p->price; ?>DH</p>
							<?php } ?>
							<div class="lx-product-qty">
								<ins>الكمية: </ins>
								<span class="lx-minus">-</span>
								<input type="text" id="qty" name="qty" data-max="1000" value="1" />
								<span class="lx-plus">+</span>
							</div>
							<div class="lx-purchase-btns">
								<a href="javascript:;" class="lx-add-to-cart" data-id="<?php echo $p->id; ?>">أطلب الآن</a>
							</div>

							<div class="lx-purchase-btns-floating">
								<a href="javascript:;" class="lx-add-to-cart" data-id="<?php echo $p->id; ?>">أطلب الآن</a>
							</div>

							<p class="lx-watching"><abbr><?php echo rand(100, 200); ?></abbr> شخص يشاهد هذا المنتوج حاليا</p>
							<ul>
								<li>- الدفع عن الاستلام</li>
								<li>- 25 درهم مصاريف الشحن بالدار البيضاء</li>
								<li>- 45 درهم مصاريف الشحن نحو جميع مدن المغرب</li>

							</ul>
								<br>
							<ul>

								<style type="text/css">
									
									iframe {
										width: 100%;
										height: 300px;
									}

								</style>

								<?php echo nl2br($p->descr); ?>

							</ul>
							<div class="lx-share">
								<ul>
									<li><a href="https://www.facebook.com/sharer/sharer.php?u=" class="popup lx-facebook"><i class="fab fa-facebook-square"></i> Facebook</a></li>
									<li><a href="https://twitter.com/intent/tweet?url=" class="popup lx-twitter"><i class="fab fa-twitter"></i> Twitter</a></li>
									<li><a href="https://plus.google.com/share?url=" class="popup lx-google-plus"><i class="fab fa-google-plus"></i> Google+</a></li>
									<li><a href="whatsapp://send?text=" data-action="share/whatsapp/share" class="popup lx-whatsapp"><i class="fab fa-whatsapp"></i> WhatsApp</a></li>
									<div class="lx-clear-fix"></div>
								</ul>
							</div>
						</div>
					</div>

					<?php endforeach; ?>

					<div class="lx-clear-fix"></div>

					<div class="lx-bloc-title">

						<a href="#" data-izimodal-open="#modal-custom" data-izimodal-transitionin="fadeInDown" class="add_more">اضف تقييم</a>

						<div class="grid">
							
							<?php foreach($votes as $vote) : ?>
								<div class="grid-item">

									<article class="card">
										<figure class="card__thumbnail">
											<?php if(!empty($vote->img)){ ?> <img src="reviews/<?php echo $vote->img; ?>"> <?php } ?>
										</figure>
										<header class="card__title">
											<h4><?php echo $vote->name; ?></h4>
										</header>
										<main class="card__description">

											<small>12/05/2019</small>

											<fieldset class="rating">
												<input type="radio" id="star5<?=$vote->id;?>" disabled value="5" <?php if($vote->vote == 5) echo "checked"; ?> /><label class = "full" for="star5<?=$vote->id;?>"></label>
												<input type="radio" id="star4<?=$vote->id;?>" disabled value="4" <?php if($vote->vote == 4) echo "checked"; ?> /><label class = "full" for="star4<?=$vote->id;?>"></label>
												<input type="radio" id="star3<?=$vote->id;?>" disabled value="3" <?php if($vote->vote == 3) echo "checked"; ?> /><label class = "full" for="star3<?=$vote->id;?>"></label>
												<input type="radio" id="star2<?=$vote->id;?>" disabled value="2" <?php if($vote->vote == 2) echo "checked"; ?> /><label class = "full" for="star2<?=$vote->id;?>"></label>
												<input type="radio" id="star1<?=$vote->id;?>" disabled value="1" <?php if($vote->vote == 1) echo "checked"; ?> /><label class = "full" for="star1<?=$vote->id;?>"></label>
											</fieldset>

											<p><?php echo $vote->comment; ?></p>
										</main>
										<?php if(is_login("admin_login")){ ?>
										<footer class="container">
											<a class="btn red" onclick="delete_c(this, '<?=$vote->id;?>');"><i class="fa fa-remove"></i></a>
											<?php if($vote->ac == 0){ ?>
												<a class="btn green" onclick="approve_c(this, '<?=$vote->id;?>');"><i class="fa fa-check"></i></a>
											<?php } ?>

										</footer>
										<?php } ?>

									</article>

								</div>


							<?php endforeach; ?>

						</div>

					</div>

					<div class="lx-bloc-title">
						<h3>قد يعجبك أيضا</h3>
					</div>
					<div class="lx-products-list lx-bloc-content">

						<?php foreach($related as $key){ ?>

						<div class="lx-g4 lx-g5-to-g2">
							<div class="lx-products-item">
								<a href="<?php echo base_url("home/show/$key->id"); ?>">
									<div class="lx-products-item-img">
										<?php if($key->discount != 0){ ?>
										<span><?php echo $key->discount; ?>%<br />OFF</span>
										<?php } ?>
										<img src="uploads/<?php echo add_thumb($key->images , "_m") ?>" />
									</div>
									<div class="lx-products-item-detail">
										<h2><?php echo $key->title; ?> </h2>
										<p>
											<ins>
											<?php if($key->discount != 0){ ?>
											<span><?php echo $key->price; ?>DH</span> <?php echo floor($key->price - ($key->price * $key->discount / 100)); ?>DH
											<?php }else{ ?>
												<?php echo $key->price; ?>DH
											<?php } ?>

											</ins>
										</p>
									</div>
								</a>
							</div>
						</div>
						<?php } ?>
						<div class="lx-clear-fix"></div>
					</div>-->
					<div class="lx-clear-fix"></div>
				</div>
			</div>

			<div id="modal-custom">
				
				<button data-izimodal-close="" class="icon-close" style="">x</button>

				<?php echo form_open_multipart(); ?>
					<section>
						<input type="" name="name" placeholder="الإسم الكامل" required>
						<label>صورة للمنتوج : </label>
						<input type="file" name="img" placeholder="Image" accept="image/jpeg,image/png">
						<textarea placeholder="تعليق" name="comment"></textarea>
						<label class="vote">التقييم : </label>
						<fieldset class="rating">
							<input type="radio" id="star5" name="starv" value="5" required /><label class = "full" for="star5" title="ممتاز"></label>
							<input type="radio" id="star4" name="starv" value="4" required /><label class = "full" for="star4" title="جيد"></label>
							<input type="radio" id="star3" name="starv" value="3" required /><label class = "full" for="star3" title="متوسط"></label>
							<input type="radio" id="star2" name="starv" value="2" required /><label class = "full" for="star2" title="ضعيف"></label>
							<input type="radio" id="star1" name="starv" value="1" required /><label class = "full" for="star1" title="غير مناسب بالمرة"></label>
						</fieldset>
						<br>

						<footer>
							<button data-izimodal-close="" data-izimodal-transitionout="bounceOutDown">إلغاء</button>
							<button class="submit" >اضف التقييم</button>
						</footer>

					</section>

				<?php echo form_close(); ?>

			</div>


<?php include_once 'footer.php'; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/izimodal/1.5.1/js/iziModal.min.js"></script>

<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>

<script type="text/javascript">

function approve_c(hada, id) {
	hadaj = $(hada);
	$.post(base_url + "/admin/approve_comment", {id : id}, function(data) {
		if(data == 1)
		{
			hadaj.remove();
		}
	})
}

function delete_c(hada, id) {
	hadaj = $(hada);
	$.post(base_url + "/admin/delete_comment", {id : id}, function(data) {
		if(data == 1)
		{
			hadaj.parent().parent().parent().remove();
			$('.grid').masonry({
			  // options
			  itemSelector: '.grid-item',
			});
		}
	})
}



$("#modal-custom").iziModal();

$('.grid').masonry({
  // options
  itemSelector: '.grid-item',
});

</script>