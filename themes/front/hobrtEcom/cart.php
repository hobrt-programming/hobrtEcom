<?php include_once 'header.php'; ?>

			<!-- Main -->
			<div class="lx-main">
				<!-- Main Content -->
				<div class="lx-main-content">
					<div class="container py-3">
					<?php if (count($info) > 0) { ?>
						<form action="" method="post" id="sendcart">
							<div class="row g-3">
								<div class="col-md-8 col-sm-12">
									<div class="lx-cart-products-list shadow-2 rounded p-2">
										<table cellpadding="0" cellspacing="0" class="w-100">
											<?php $tprice = 0; $ship = 0; foreach ($info as $cart) { $pr = floor($cart->price - ($cart->price * $cart->discount / 100)); $tpr = isset($arr[$cart->id]['q']) ? $pr * $arr[$cart->id]['q'] : $pr; ?>
											<tr class="items shadow-1 rounded">
												<td class="p-2" style="width: 76px;">
													<div class="lx-cart-products-list-img">
														<a href="<?php echo base_url("product/$cart->slug"); ?>"><img class="rounded" style="height: 60px;" src="<?php echo base_url("uploads") . "/" . add_thumb($cart->images, "_m"); ?>" alt="" /></a>
													</div>
												</td>
												<td class="p-2">
													<h3 class="h6 m-0"><a href="<?php echo base_url("product/$cart->slug"); ?>"><?php echo short_text($cart->title, 4, 20); ?> x <?php echo $arr[$cart->id]['q'] ?? 1; ?></a></h3>
												</td>
												<td class="p-2">
													<div class="btn btn-danger-light py-0"><a href="javascript:;" data-id="<?php echo $cart->id; ?>" class="lx-delete-cookie decoration-none"><i class="fas fa-trash-alt"></i></a></div>
												</td>
												<td class="lx-price-total p-2 text-nowrap"><strong><?php echo $tpr; ?> <?= $currency; ?></strong></td>
												<?php $tprice = $tprice + $tpr; $ship = $ship + $cart->shipping; ?>
											</tr>
											<?php } ?>
										</table>
										<p class="couponUse"></p>
										<div class="row text-center">
											<div class="col-6">
												<p class="lx-shipping-costs bg-light p-2 rounded"><i class="fas fa-shipping-fast"></i> <?= lang("lang_h19"); ?> : <b class="ship"><?php echo $ship; ?> <?= $currency; ?></b></p>
											</div>
											<div class="col-6">
												<p class="lx-total-costs bg-success p-2 rounded text-light"><i class="fas fa-money-check"></i> <?= lang("lang_h20"); ?> : <strong class="totalprice"><?php echo ($tprice + $ship); ?> <?= $currency; ?></strong></p>
											</div>
										</div>
										<input type="hidden" name="totalprice" id="value" value="<?php echo ($tprice + $ship); ?>" />
									</div>
								</div>
								<div class="col-md-4 col-sm-12">
									<div class="lx-cart-total shadow-2 rounded h-100 p-4">
										<div class="lx-cart-info-address">
											<h3 class="h5"><?= lang("lang_h21"); ?></h3>
											<label class="my-2 w-100"><span><?= lang("lang_h22"); ?> :</span><input class="form-control" type="text" name="fullname" placeholder="<?= lang("lang_h22"); ?>" /></label>
											<label class="my-2 w-100"><span><?= lang("lang_h23"); ?> :</span><input class="form-control" type="tel" name="phone" placeholder="<?= lang("lang_h23"); ?>" /></label>
											<label class="my-2 w-100"><span><?= lang("lang_h24"); ?> :</span><input class="form-control" type="text" name="address" placeholder="<?= lang("lang_h24"); ?>" /></label>
											<label class="my-2 w-100"><span><?= lang("lang_h25"); ?> :</span><input class="form-control" type="text" name="city" placeholder="<?= lang("lang_h25"); ?>" /></label>
											<div class="my-2 bg-light rounded p-2 text-center">
												<label class="w-100"><span><?= lang("lang_h26"); ?> :</span><input class="form-control" type="text" name="coupon" placeholder="<?= lang("lang_h26"); ?>" id="coupon" /></label>
												<button type="button" class="btn btn-warning rounded py-1 my-1 lx-applycoupon" data-activated="no"><?= lang("lang_h27"); ?></button>
											</div>
											<p class="lx-coupon-warning"></p>
											<div class="lx-cart-next-step">
												<a href="javascript:;" class="btn btn-success text-center rounded p-2 w-100"><?= lang("lang_h28"); ?></a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</form>
					<?php } else { ?>
						<p class="text-center text-muted py-5"><em><?= lang("lang_h29"); ?></em></p>
					<?php } ?>
					</div>
				</div>
			</div>

<?php include_once 'footer.php'; ?>
