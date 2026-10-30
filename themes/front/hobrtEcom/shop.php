<?php include_once "header.php"; ?>
<!---Start-Shop-section-->
<section class="ws-section-spacing pt-4">
	<div class="container">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?= base_url("/") ?>"><?= lang("lang_h53") ?></a></li>
				<li class="breadcrumb-item active" aria-current="page"><a href="<?= base_url("/shop") ?>"><?= lang("lang_h65") ?></a></li>
			</ol>
		</nav>
		<div class="row">
			<div class="col-lg-9 order-lg-last order-md-first">
				<div class="shop-filter">
					<ul class="nav nav-tabs title-bottom-spacing">
						<a><?= lang("lang_h87") ?></a>
						<select id="order" name="order">
							<option value="date" <?= $this->input->get("order") == "date" ? "selected" : "" ?>><?= lang("lang_h88") ?></option>
							<option value="price_low" <?= $this->input->get("order") == "price_low" ? "selected" : "" ?>><?= lang("lang_h89") ?></option>
							<option value="price_high" <?= $this->input->get("order") == "price_high" ? "selected" : "" ?>><?= lang("lang_h90") ?></option>
						</select>
						<li><a data-toggle="tab" href="#grid" class="active"><i class="flaticon-grid"></i></a></li>
						<li><a data-toggle="tab" href="#list"><i class="flaticon-list-1"></i></a></li>
					</ul>
					<div class="tab-content">
						<!--Grid-->
						<div id="grid" class="tab-pane fade in active">
							<div class="row justify-content-sm-center">
								<?php foreach ($products as $p) : ?>
									<!--item-->
									<div class="col-md-3 col-sm-6 my-2">
                        <div class="product-grid h-100 bg-white">
                            <div class="product-image">
                                <a href="<?= base_url("product/$p->slug"); ?>" class="image">
                                    <img class="pic-1" src="<?= $p->images !== null && $p->images != "" ? base_url('uploads/' . add_thumb($p->images, "_m")) : base_url("assets/img/default_product.png"); ?>" alt="<?= $p->title; ?>">
                                </a>
                                <?php if ($p->discount != 0) : ?>
                                    <span class="product-discount-label" style="background:<?= setting("color") ?>"><?= $p->discount; ?>%</span>
                                <?php endif; ?>
                                <ul class="product-links">
                                    <li><a href="#" data-tip="Add to Wishlist"><i class="fas fa-heart"></i></a></li>
                                </ul>
                            </div>
                            <div class="product-content">
                                <ul class="rating" style="color:<?= setting("color") ?>">
                                    <?php
                                    $rating = $p->review;
                                    $filledStars = floor($rating);
                                    $hasHalfStar = ($rating - $filledStars) >= 0.5;
                                    $unfilledStars = 5 - $filledStars - ($hasHalfStar ? 1 : 0);
                                    ?>
                                    <?php for ($j = 1; $j <= $filledStars; $j++) : ?>
                                        <li><i class="fas fa-star"></i></li>
                                    <?php endfor; ?>
                                    <?php if ($hasHalfStar) : ?>
                                        <li><i class="fas fa-star-half-alt"></i></li>
                                    <?php endif; ?>
                                    <?php for ($j = 1; $j <= $unfilledStars; $j++) : ?>
                                        <li><i class="far fa-star"></i></li>
                                    <?php endfor; ?>
                                </ul>
                                <h3 class="title"><a href="<?= base_url("product/$p->slug"); ?>" data-setting-color="<?= setting("color") ?>"><?= $p->title; ?></a></h3>
                                <div class="price" style="color:<?= setting("color") ?>">
                                    <?php if ($p->discount != 0) : ?>
                                    	<span><?= $p->price; ?> <?= $currency; ?></span>
                                    	<?= round($p->price - ($p->price * $p->discount / 100), 2); ?> <?= $currency; ?>
                                    <?php else : ?>
                                    	<?= $p->price; ?> <?= $currency; ?>
                                    <?php endif; ?>
                                </div>
                                <a class="add-to-cart" style="background:<?= setting("color") ?>" href="<?= base_url("product/$p->slug"); ?>"><?= lang("lang_h51") ?></a>
                            </div>
                        </div>
                    </div>
									<!--item-->
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
				<!---pagination-->
				<?php if (isset($links)) echo $links; ?>
			</div>
			<!--side-bar-->
			<div class="col-lg-3 order-lg-first order-md-last">
				<div class="sidebar-Categories">
					<h5><?= lang("lang_h66") ?></h5>
					<div id="accordion" class="">
						<?php foreach (all_categories() as $cat) : ?>
							<a href="<?= base_url("shop?cat=$cat->id") ?>" class="list-group-item list-group-item-action border-0"><span><?= $cat->title ?></span></a>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!---End-Shop-section-->



<?php include_once "footer.php"; ?>

<script>
	$("#order").on("change", function() {
		const selectedOrder = $(this).val();
		const queryParams = new URLSearchParams(window.location.search);

		queryParams.set("order", selectedOrder);

		const newUrl = `${window.location.pathname}?${queryParams.toString()}`;

		window.location.href = newUrl;
	});
</script>