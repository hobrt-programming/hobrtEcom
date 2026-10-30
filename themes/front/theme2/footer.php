
<footer>
	<div class="container">
		<div class="row">
			<div class="col-md-3 col-sm-6">
				<h2 class="logo"><?php echo setting('title'); ?></h2>
				<p><?php echo setting('descr'); ?></p>
				<li class="fa fa-stack"><a href="<?php echo setting('fb') ?>" target="_blank"><i class="fab fa-facebook-f"></i> </a></li>
				<li class="fa fa-stack"><a href="<?php echo setting('ig') ?>" target="_blank"><i class="fab fa-instagram"></i> </a></li>
				<li class="fa fa-stack"><a href="<?php echo setting('tw') ?>" target="_blank"><i class="fab fa-twitter"></i> </a></li>

			</ul>
		</div>
		<div class="col-md-3 col-sm-6">
			<h2><?= lang("lang_h105") ?></h2>
			<ul class="list-unstyled">
				<?php
				$pages = $this->m_p->s_a("pages", array("footer" => 1), FALSE);

				foreach($pages as $page) :
				?>
				<li><a href="<?php echo base_url("page/$page->id") ?>"><?php echo $page->title; ?></a></li>
				<?php endforeach; ?>
				</ul>
			</div>
			<div class="clearfix"></div>
			<div class="col-md-3 col-sm-6">
				<h2><?= lang("lang_h42") ?></h2>
				<ul class="list-unstyled">
						<?php
				$pages = $this->m_p->s_a("products", array("featured" => 1), FALSE);

				foreach($pages as $page) :
				?>
				<li><a href="<?php echo base_url("product/$page->slug") ?>"><?php echo $page->title; ?></a></li>
				<?php endforeach; ?>
					</ul>
				</div>
				<div class="col-md-3 col-sm-6">
					<h2><?= lang("lang_h66") ?></h2>
					<ul class="list-unstyled">
						<?php foreach(all_categories() as $cat) : ?>
							<li><a href="<?php echo base_url("category/$cat->slug"); ?>" class=""><?php echo $cat->title; ?></a></li>
						<?php endforeach; ?>
						</ul>
					</div>
				</div>

			</div>
			<div class="copyright text-center">
				<p>© <?= lang("lang_h48") ?> <a href="https://hobrt.me">hobrt</a> <?php echo date('Y') ?>
				</p>
			</div>
		</footer>
		<!-- End Footer -->

		<script src ="assets/js/jquery-3.3.1.min.js"></script>
		<script src ="assets/js/main.js?v=0.0.1"></script>
		<script src ="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/buy.js?v=<?= filemtime(__DIR__ . "/assets/js/buy.js") ?>"></script>
			<?php if (newsletter_enabled()) : ?><script src="<?= base_url("assets/js/newsletter.js?v=" . filemtime(FCPATH . "assets/js/newsletter.js")) ?>"></script><?php endif; ?>
	</body>
	</html>
