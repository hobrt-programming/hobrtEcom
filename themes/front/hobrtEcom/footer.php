
		<footer class="bg-primary-gradient">
    <div class="container py-4 py-lg-5">
        <div class="row justify-content-center">
            <div class="col-sm-4 col-md-4 text-center text-lg-start d-flex flex-column">
                <h3 class="fs-6 fw-bold"><?= lang("lang_h43") ?></h3>
                <ul class="list-unstyled">
				<?php foreach (footer_pages() as $footer_page) : ?>
				<li>
						<a href="<?= base_url("/page/$footer_page->slug"); ?>"><?= $footer_page->title ?></a>
					</li>
				<?php endforeach; ?>
                </ul>
            </div>
			<div class="col-sm-4 col-md-4 text-center text-lg-start d-flex flex-column">
                <h3 class="fs-6 fw-bold"><?= lang("lang_h92") ?></h3>
                <ul class="list-unstyled">
                <?php foreach (all_categories() as $all_category) : ?>
			<li>
				<a href="<?= base_url("/category/$all_category->slug"); ?>"><?= $all_category->title ?></a>
			</li>
		        <?php endforeach; ?>
                </ul>
            </div>
            <div class="col-lg-3 text-center text-lg-start d-flex flex-column align-items-center order-first align-items-lg-start order-lg-last">
                <div class="fw-bold d-flex align-items-center mb-2">
				<a class="navbar-brand d-flex align-items-center" href="<?= base_url("/") ?>"><img src="<?= store_logo() ?>" style="height:55px" alt="logo.png" class="logo"></a>
                <ul class="list-unstyled py-1">
				</div>
                <p class="text-muted"><?= setting("descr") ?></p>
            </div>
        </div>
        <hr />
        <div class="text-muted d-flex justify-content-between align-items-center pt-3">
            <p class="mb-0">Hobrt <?= lang("lang_h96") ?> <?php echo date("Y"); ?></p>
            <ul class="list-inline mb-0">
                <li class="list-inline-item"><svg class="bi bi-facebook" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"></path>
                    </svg></li>
                <li class="list-inline-item"><svg class="bi bi-twitter" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"></path>
                    </svg></li>
                <li class="list-inline-item"><svg class="bi bi-instagram" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"></path>
                    </svg></li>
            </ul>
        </div>
    </div>
</footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
		<script src="assets/hbtheme/assets/js/script.min.js?h=9a9b12d9479055b6ccf322643488f6dd"></script>

		<!-- JQuery -->
		<script src="assets/js/jquery-1.12.4.min.js"></script>
		<!-- Swipe Script -->
		<script src="assets/js/hammer.min.js"></script>

		<script src="assets/js/popup.js"></script>

		<script src="<?php echo base_url("home/js"); ?>"></script>

		<!-- Main Script -->
		<script src="assets/js/script.js?v=<?= filemtime(FCPATH . "assets/js/script.js") ?>"></script>
		
        <script src="assets/js/script.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
		<script>window.hbCartText = <?= json_encode(array("added" => lang("lang_h117"), "addedText" => lang("lang_h118"), "checkout" => lang("lang_h119"), "continue" => lang("lang_h30"), "removed" => lang("lang_h32"), "removedText" => lang("lang_h120")), JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?>;</script>
        <script src="assets/js/cart.js?v=<?= filemtime(FCPATH . "assets/js/cart.js") ?>"></script>
        <script src="assets/hbtheme/assets/js/single-product.js"></script>
        <script src="assets/hbtheme/assets/js/swipe-bundle.min.js"></script>
        <script src="assets/hbtheme/assets/js/app.js"></script>
        <script>
       var galleryThumbnailsBanners = new Swiper('.gallery-thumbnails', {
            spaceBetween: 4,
            direction: 'horizontal',
            loop: false,
            autoplay: false,
            slidesPerView: 4,
            centerInsufficientSlides: true,
            watchOverflow: true,
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
            observer: true,
            observeParents: true,
            navigation: {
                nextEl: '.gallery-thumbnails .swiper-button-next',
                prevEl: '.gallery-thumbnails .swiper-button-prev',
            },
        });
        var galleryTopThumbnailsBanners = new Swiper('.gallery-top-thumbnails', {
            spaceBetween: 10,
            slidesPerView: 1,
            loop: false,
            autoplay: false,
            observer: true,
            observeParents: true,
            thumbs: {
                swiper: galleryThumbnailsBanners
            },
            direction: 'horizontal',
        });
    </script>
		
	</body>
</html>