<?php include_once 'inc/header.php'; ?>

<div id="content-wrapper" class="d-flex flex-column">

	<!-- Main Content -->
	<div id="content">

		<?php include_once 'inc/navbar.php'; ?>

		<div class="container-fluid">

			<!-- Page Heading -->
			<div class="my-4">
			<h1 class="h3 mb-2 text-gray-800 my-2"><span class="bg-primary rounded px-2 text-white"><i class="fas fa-star"></i> <?= $this->input->get("pending") ? lang("admin_h29") : lang("admin_h98"); ?></span></h1>
			</div>
			<!-- DataTales Example -->
			<div class="card shadow mb-4">
				<div class="card-body">
					<?php if(isset($success)) {?>
						<div class="alert alert-success" role="alert"><span><strong><?php echo lang("admin_h118") ?></div>
					<?php } ?>
					<?php if(sizeof($reviews) > 0) {?>
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th><?php echo lang("admin_h119") ?></th>
									<th><?php echo lang("admin_h120") ?></th>
									<th><?php echo lang("admin_h121") ?></th>
									<th><?php echo lang("admin_h122") ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($reviews as $review) : ?>
									<tr>
										<td style="max-width: 350px;">
											<div class="card shadow-sm">
												<div class="card-body p-1" stystyle="direction: <?php echo lang("admin_h55") ?>;">
													<div class="d-flex align-items-center">
														<div style="flex: 1 1 auto">
															<p class="card-text mb-0"><?php echo lang("admin_h24") ?> : <?= html_escape($review->name) ?></p>
															<div>
																<span class="text-warning stars">
																	<?php
																	$rating = $review->rating;
																	echo str_repeat("&#9733;", $rating) . str_repeat("&#9734;", 5 - $rating);
																	?>
																</span>
															</div>
															<p class="card-text mb-0"><?php echo lang("admin_h123") ?> : <?= html_escape($review->email) ?></p>
															<p class="card-text mb-0"><?php echo lang("admin_h124") ?> : <?= $review->comment !== null && $review->comment != "" ? nl2br(html_escape($review->comment)) : lang("admin_h125"); ?></p>

														</div>
														<?php if ($review->img !== null && $review->img != "") { ?>
															<img src="<?= base_url("images/" . rawurlencode((string) $review->img)) ?>" style="width: 80px; height:80px; flex:inherit" alt="Profile Image" class="img-thumbnail">
														<?php } ?>
													</div>
													<span class="text-muted small"><?php echo date('d/m/Y - H:i', strtotime($review->date)); ?></span>
												</div>
											</div>

										</td>
										<td class="d-flex align-items-center">
											<?php if ($review->product !== null) { ?>
												<img src="<?php echo $review->product->images !== null && $review->product->images != "" ? base_url('uploads/' . add_thumb($review->product->images, "_m")) : "img/no_image.jpg" ?>" class="img-thumbnail mr-1" style="width: 50px; height:50px;">
												<h5 class="small mb-0"><?= $review->product->title ?></h5>
											<?php } else { ?>
												<h5 class="small mb-0 text-danger"><?php echo lang("admin_h126") ?></h5>
											<?php } ?>
										</td>
										<td>
											<?php if ($review->ac == 0) { ?>
											<span class="text-warning p-1 border rounded"><?php echo lang("admin_h6") ?></span>
											<?php } else { ?>
											<span class="text-success p-1 border rounded"><?php echo lang("admin_h127") ?></span>
											<?php } ?>
										</td>
										<td>
											<?php if($review->ac == 0) { ?>
											<form method="post" class="m-1">
												<input type="hidden" name="review_id" value="<?= $review->id ?>">
												<button type="submit" name="accept-review" class="btn btn-success"><?php echo lang("admin_h128") ?></button>
											</form>
											<?php } ?>
											<a href="<?php echo csrf_url("admin/delt/reviews/$review->id/reviews"); ?>" class="m-1 btn btn-danger"><?php echo lang("admin_h129") ?></a>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
					<?php }else{ ?>
						<div class="alert alert-info" role="alert"><span><?php echo lang("admin_h130") ?></span></div>
					<?php } ?>
				</div>
			</div>

		</div>
		<!-- /.container-fluid -->

	</div>


	<?php include_once 'inc/footer.php'; ?>