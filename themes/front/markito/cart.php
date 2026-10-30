<?php include_once "header.php"; ?>


<section class="page-slider">
	<div class="hero-banner-content">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<h2 class="banner-title"><?= lang("lang_h52") ?></h2>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= base_url("/") ?>"><?= lang("lang_h53") ?></a></li>
							<li class="breadcrumb-item active" aria-current="page"><?= lang("lang_h52") ?></li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>
</section>
<!---End-Main-section-->
<!---Start-Product-Detail-->
<section class="ws-section-spacing">
	<div class="container">
		<div class="row">

			<?php if(count($info) > 0){ ?>

				<div class="col-lg-12">
					<h2 class="title-bottom-spacing"><?= lang("lang_h54") ?></h2>
				</div>
				<div class="col-lg-6 col-md-12 col-sm-12">
					<div class="checkout-card">
						<ul>
							<li class="chechout-title"><?= lang("lang_h55") ?> <span class="chechout-span"><?= lang("lang_h56") ?></span></li>
							<li>
								<ul class="chechout-item">

									<?php $tprice = 0;$ship = 0; foreach($info as $cart){

										$pr = floor($cart->price - ($cart->price * $cart->discount / 100)); $tpr = isset($arr[$cart->id]['q']) ? $pr * $arr[$cart->id]['q'] : $pr;

										$tprice = $tprice + $tpr;

										$ship = $ship + $cart->shipping;
									?>

									<li class="row justify-content-between ">
										<p><img src="<?php echo base_url("uploads")."/".add_thumb($cart->images, "_s"); ?>" class="wow zoomIn" data-wow-delay=".25s" data-wow-duration="1s"  data-wow-iteration="1" alt="<?php echo $cart->title; ?>" title="<?php echo $cart->title; ?>">
										<?php echo short_text($cart->title, 4, 20); ?> x <?php echo $arr[$cart->id]['q'] ?? 1; ?>
										<span><?php echo format_money($tpr); ?></span></p>
										<a href="javascript:;" onclick="deleteFromCart(<?php echo $cart->id; ?>, this)"><i class="fa fa-trash float-right pr-2"></i></a>
									</li>
									
									<?php } ?>

								</ul>
							</li>
							<li><?= lang("lang_h57") ?><span class="Subtotal"><?php echo format_money($tprice); ?></span></li>
							<li class="chechout-shiping"><?= lang("lang_h58") ?><span class="Subtotal"> <?php echo $ship == 0 ? lang("lang_h59") : format_money($ship); ?> </span></li>
							<li class="chechout-total"><?= lang("lang_h56") ?><span class="Subtotal"><?php echo format_money($tprice + $ship); ?></span></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-6 col-md-12 col-sm-12">
					<form action="" method="post">
						<div class="row">
							<div class="col-lg-12">
								<div class="form-group">
									<input type="text" name="fullname" class="form-control" oninvalid="setCustomValidity('<?= lang('lang_h62') ?>')" oninput="setCustomValidity('')" required placeholder="<?= lang("lang_h60") ?>">
								</div>
							</div>
							<div class="col-lg-12">
								<div class="form-group">
									<input type="text" name="phone" oninvalid="setCustomValidity('<?= lang('lang_h63') ?>')" oninput="setCustomValidity('')" required class="form-control" placeholder="<?= lang("lang_h23") ?>">
								</div>
							</div>
							<div class="col-lg-12">
								<div class="form-group">
									<input type="text" name="address" class="form-control" placeholder="<?= lang("lang_h24") ?>">
								</div>
							</div>
							<div class="col-lg-12">
								<div class="form-group">
									<input type="text" name="city" class="form-control" placeholder="<?= lang("lang_h25") ?>">
								</div>
							</div>
							
						</div>

						<button type="submit" class="btn-submit"><?= lang("lang_h61") ?></button>
					</form>
				</div>

			<?php }else { ?>

				<div class="col-md-12">
					<div class="alert alert-info"><?= lang("lang_h29") ?></div>
				</div>

			<?php } ?>

		</div>
	</div>
</section>


<?php include_once "footer.php" ?>