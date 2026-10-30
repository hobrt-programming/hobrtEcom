		</main>
		<!---End-Offer-Banner-Section-->
		<section class="section-spacing service-area pt-2 pb-2">
			<div class="container">
				<div class="row service-border wow fadeInUp" data-wow-delay=".25s" data-wow-duration="1s" data-wow-iteration="1">
					<?php foreach (all_badges() as $badge) : ?>
						<div class="col-lg-3 col-sm-6">
							<div class="single-service-wrap">
								<div class="thumb mb-1" style="float: initial;border-color: <?= $color ?>;">
									<img src="<?= $badge->img !== null && $badge->img != "" ? base_url("images/$badge->img") : base_url("assets/img/default_image.jpg") ?>" alt="" width="32" height="32">
								</div>
								<div class="wrap-details" style="text-align: center;width: initial;">
									<h3 class="h5"><?= $badge->title ?></h3>
									<p><?= $badge->subtitle ?></p>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<!---Start-Footer-Section-->
		<footer class="footer-section-spacing home-footer-bg">
			<div class="container">
				<div class="row">
					<div class="col-lg-3 col-md-4">
						<div class="footer-about">
							<img src="<?= store_logo() ?>" <?= $logo_size ?> style="width:auto;max-width:100%;height:55px" alt="<?= html_escape(setting("title")) ?>" loading="lazy">
							<p><?= setting("descr") ?></p>
						</div>
					</div>
					<!--item-->
					<div class="col-lg-3 col-md-4">
						<div class="popular-tag">
							<h2 class="footer-title"><?= lang("lang_h43") ?></h2>
							<ul>
								<?php foreach (footer_pages() as $footer_page) : ?>
									<li>
										<a href="<?= base_url("/page/$footer_page->slug"); ?>"><?= $footer_page->title ?></a>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>
					<!--item-->
					<div class="col-lg-3 col-md-4">
						<div class="contact-us">
							<h2 class="footer-title"><?= lang("lang_h44") ?></h2>
							<ul>
								<?php if (setting("teles") !== null && setting("teles") != "") { ?>
									<?php foreach (explode(";", setting("teles")) as $teles) : ?>
										<li><i class="fas fa-phone" style="color:<?= $color ?>"></i><?= $teles ?></li>
									<?php endforeach; ?>
								<?php } ?>

								<?php if (setting("whs") !== null && setting("whs") != "") { ?>
									<?php foreach (explode(";", setting("whs")) as $whs) : ?>
										<li><i class="fab fa-whatsapp" style="color:green"></i><?= $whs ?></li>
									<?php endforeach; ?>
								<?php } ?>

								<li><i class="fas fa-envelope" style="color:<?= $color ?>"></i> contact@<?= $_SERVER['HTTP_HOST'] ?></li>
							</ul>
						</div>
					</div>
					<?php if (newsletter_enabled()) : ?>
					<!--item-->
					<div class="col-lg-3 col-md-4">
						<div class="contact-us">
							<h2 class="footer-title"><?= lang("lang_h45") ?></h2>
							<p><?= lang("lang_h46") ?></p>
							<form action="<?= base_url("ajax/subscribe") ?>" method="post" data-newsletter data-error="<?= html_escape(lang("lang_h116")) ?>">
								<input type="email" name="email" placeholder="<?= lang("lang_h100") ?>" required maxlength="250" class="email" aria-label="<?= html_escape(lang("lang_h100")) ?>">
								<button type="submit" class="contact-btn"><?= lang("lang_h47") ?></button>
							</form>
							<p class="small mt-2" data-newsletter-msg></p>
						</div>
					</div>
					<?php endif; ?>
					<!--copy-right-->
					<div class="container">
						<div class="row justify-content-center">
							<div class="container-fluid">
								<div class="copy-right">
									<span class="copy-right-seprater"></span>
									<p><?= setting("title") ?> <?= date("Y") ?> <?= lang("lang_h48") ?></p>
								</div>
							</div>
						</div>
					</div>
					<!--end copy-right-->
				</div>
			</div>
		</footer>
		<!-- Jquery.min.js-->
		<script src="js/jquery.1.12.4.js"></script>
		<!--bootstrap.min.js-->
		<script src="js/bootstrap.min.js"></script>
		<!--slicknav.min.js-->
		<script src="js/jquery.slicknav.min.js"></script>
		<!--slickslider.min.js-->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous"></script>
		<!-- magnific-popup.js -->
		<script src="js/lity.min.js"></script>
		<!-- imagesloaded.js -->
		<script src="js/imagesloaded.js"></script>
		<!-- wow.js -->
		<script src="js/wow.min.js"></script>
		<!-- main.js -->
		<script src="js/main.js?v=<?= filemtime(__DIR__ . "/js/main.js") ?>"></script>

		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>

		<script>window.hbCartText = <?= json_encode(array("added" => lang("lang_h117"), "addedText" => lang("lang_h118"), "checkout" => lang("lang_h119"), "continue" => lang("lang_h30"), "removed" => lang("lang_h32"), "removedText" => lang("lang_h120")), JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?>;</script>
		<script src="js/cart.js?v=<?= filemtime(__DIR__ . "/js/cart.js") ?>"></script>
				<?php if (newsletter_enabled()) : ?><script src="<?= base_url("assets/js/newsletter.js?v=" . filemtime(FCPATH . "assets/js/newsletter.js")) ?>"></script><?php endif; ?>
	</body>