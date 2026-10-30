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
									<div class="col-lg-4 col-md-6 col-sm-6 col-xs-10">
										<?php include "article.php"; ?>
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