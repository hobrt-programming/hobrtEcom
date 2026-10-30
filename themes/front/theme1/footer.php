		<footer class="text-center">
			<ul class="list-inline links">
				<?php
				$pages = $this->m_p->s_a("pages", array("footer" => 1), FALSE);

				foreach($pages as $page) :
				?>
				<li><a href="<?php echo base_url("page/$page->id") ?>"><?php echo $page->title; ?></a></li>
				<?php endforeach; ?>
			</ul>

			<ul class="list-inline social-media">
				<li><a href="<?=setting('fb');?>"><i class="fab fa-facebook-f"></i></a></li>
				<li><a href="<?=setting('tw');?>"><i class="fab fa-twitter"></i></a></li>
				<li><a href="<?=setting('ig');?>"><i class="fab fa-instagram"></i></a></li>

			</ul>

			<p>© <?= lang("lang_h48") ?> <a href="https://hobrt.me" target="_blank" >hobrt.me</a> <?php echo date("Y"); ?>.</p>
		</footer>

		<script src ="assets/js/jquery-3.3.1.min.js"></script>
		<script src ="assets/js/main.js?v=0.0.1"></script>
		<script src ="assets/js/bootstrap.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
			<?php if (newsletter_enabled()) : ?><script src="<?= base_url("assets/js/newsletter.js?v=" . filemtime(FCPATH . "assets/js/newsletter.js")) ?>"></script><?php endif; ?>
	</body>
</html>
