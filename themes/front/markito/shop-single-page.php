<?php include_once "header.php"; ?>

<section class="">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="d-flex align-items-center mt-5 mb-5">
					<img class="rounded-circle shadow-sm mr-2" src="<?= $image !== null && $image != "" ? base_url("images/" . $image) : base_url("assets/img/default_image.jpg") ?>" style="width:100px;height:100px;flex: none;" />
					<div style="flex:1 1 auto">
						<h3><?= $title ?></h3>
						<?php if(isset($description))?><p class="m-0 d-none d-md-block"><?= $description ?></p>
					</div>
				</div>
				<h2 class="title"><?= $total?> <?= lang("lang_h86") ?></h2>
				<div class="saprater bottom-spacing">
					<ul>
						<li class="saprater-box"></li>
						<li class="saprater-box"></li>
						<li class="saprater-box"></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="row">
			<div class=" col-lg-12">
				<div class="row">

					<?php foreach ($products as $p) : ?>

						<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
							<?php include "article.php"; ?>
						</div>

					<?php endforeach; ?>

				</div>
				<?php if (isset($links)) echo $links; ?>
			</div>
		</div>
	</div>
</section>


<?php include_once "footer.php"; ?>