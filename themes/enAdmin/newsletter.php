<?php include_once 'inc/header.php'; ?>

<div id="content-wrapper" class="d-flex flex-column">

	<!-- Main Content -->
	<div id="content">

		<?php include_once 'inc/navbar.php'; ?>

		<div class="container-fluid">

			<div class="my-4">
				<h1 class="h3 mb-2 text-800"><span class="bg-primary rounded px-1 text-light"><i class="fas fa-envelope-open-text"></i> <?= lang("admin_h241") ?></span></h1>
			</div>

			<?php if (!$ready): ?>
				<div class="alert alert-warning">
					<?= lang("admin_h253") ?> &middot; <a href="<?php echo base_url("admin/upgrade"); ?>">admin/upgrade</a>
				</div>
			<?php else: ?>

				<?php if ($saved): ?>
					<div class="alert alert-success"><?= lang("admin_h251") ?></div>
				<?php endif; ?>

				<div class="card shadow mb-4">
					<div class="card-body">
						<?php echo form_open("admin/newsletter"); ?>
							<div class="custom-control custom-switch mb-2">
								<input type="checkbox" class="custom-control-input" id="newsletter" name="newsletter" value="1" <?php echo $enabled ? "checked" : ""; ?>>
								<label class="custom-control-label" for="newsletter"><?= lang("admin_h242") ?></label>
							</div>
							<p class="small text-muted"><?= lang("admin_h252") ?></p>
							<button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save"></i> <?= lang("admin_h250") ?></button>
						<?php echo form_close(); ?>
					</div>
				</div>

				<div class="card shadow mb-4">
					<div class="card-header py-3 d-flex align-items-center justify-content-between">
						<h6 class="m-0 font-weight-bold text-primary"><?= lang("admin_h243") ?> (<?php echo (int) $total; ?>)</h6>
						<?php if ($total > 0): ?>
							<a class="btn btn-sm btn-success" href="<?php echo base_url("admin/newsletter_export"); ?>"><i class="fas fa-file-csv"></i> <?= lang("admin_h247") ?></a>
						<?php endif; ?>
					</div>
					<div class="card-body">
						<?php if ($total == 0): ?>
							<p class="text-muted mb-0"><?= lang("admin_h248") ?></p>
						<?php else: ?>
							<div class="table-responsive">
								<table class="table table-bordered table-sm mb-0">
									<thead>
										<tr>
											<th><?= lang("admin_h244") ?></th>
											<th><?= lang("admin_h245") ?></th>
											<th><?= lang("admin_h246") ?></th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($subscribers as $s): ?>
											<tr>
												<td><?php echo html_escape($s->email); ?></td>
												<td><?php echo html_escape($s->lang); ?></td>
												<td><?php echo html_escape($s->date); ?></td>
												<td class="text-center">
													<a class="btn btn-sm btn-danger py-0" href="<?php echo csrf_url("admin/delete_subscriber/" . (int) $s->id); ?>" onclick="return confirm('<?= lang("admin_h249") ?>?');"><i class="fas fa-trash-alt"></i></a>
												</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
							<?php echo $links; ?>
						<?php endif; ?>
					</div>
				</div>

			<?php endif; ?>

		</div>
		<!-- /.container-fluid -->

	</div>

<?php include_once 'inc/footer.php'; ?>
