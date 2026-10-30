<?php include_once 'inc/header.php'; ?>

<div id="content-wrapper" class="d-flex flex-column">

	<!-- Main Content -->
	<div id="content">

		<?php include_once 'inc/navbar.php'; ?>

		<div class="container-fluid">

			<div class="my-4">
				<h1 class="h3 mb-2 text-800"><span class="bg-primary rounded px-1 text-light"><i class="fas fa-robot"></i> <?= lang("admin_h258") ?></span></h1>
			</div>

			<?php if ($saved): ?>
				<div class="alert alert-success"><?= lang("admin_h251") ?></div>
			<?php endif; ?>

			<div class="row">
				<div class="col-lg-7">
					<div class="card shadow mb-4">
						<div class="card-body">
							<?php echo form_open("admin/ai_settings", array("autocomplete" => "off", "id" => "ai-form")); ?>

								<div class="form-group">
									<label for="provider"><?= lang("admin_h259") ?></label>
									<select class="form-control" id="provider" name="provider">
										<?php foreach ($providers as $id => $p): ?>
											<option value="<?= $id ?>" <?= $ai['provider'] === $id ? "selected" : "" ?>>
												<?= html_escape($p['label']) ?><?= $ai['all'][$id]['has_key'] ? ' ✓' : '' ?>
											</option>
										<?php endforeach; ?>
									</select>
								</div>

								<?php foreach ($providers as $id => $p): $cur = $ai['all'][$id]; ?>
									<fieldset class="ai-provider" data-provider="<?= $id ?>" <?= $ai['provider'] === $id ? '' : 'hidden' ?>>

										<?php if ($id === 'custom'): ?>
											<p class="small text-muted"><?= lang("admin_h288") ?></p>
										<?php endif; ?>

										<div class="form-group">
											<label for="key-<?= $id ?>"><?= lang("admin_h260") ?></label>
											<input type="password" class="form-control" id="key-<?= $id ?>" name="ai[<?= $id ?>][key]" autocomplete="new-password" dir="ltr"
												placeholder="<?= $cur['has_key'] ? html_escape(lang("admin_h265") . ' ' . $cur['key_hint']) : '' ?>">
											<small class="form-text text-muted">
												<?= $cur['has_key'] ? lang("admin_h262") : lang("admin_h266") ?>
												<?php if ($p['keys']): ?>
													&middot; <?= lang("admin_h279") ?>
													<a href="<?= html_escape($p['keys']) ?>" target="_blank" rel="noopener"><?= html_escape(parse_url($p['keys'], PHP_URL_HOST)) ?></a>
												<?php endif; ?>
											</small>
										</div>

										<div class="form-group">
											<label for="model-<?= $id ?>"><?= lang("admin_h261") ?></label>
											<input type="text" class="form-control" id="model-<?= $id ?>" name="ai[<?= $id ?>][model]" dir="ltr"
												value="<?= html_escape($cur['model']) ?>" placeholder="<?= html_escape($p['model']) ?>">
										</div>

										<?php if (isset($p['image_model'])): ?>
											<div class="form-group">
												<label for="image-model-<?= $id ?>"><?= lang("admin_h325") ?></label>
												<input type="text" class="form-control" id="image-model-<?= $id ?>" name="ai[<?= $id ?>][image_model]" dir="ltr"
													value="<?= html_escape($cur['image_model']) ?>" placeholder="<?= html_escape($p['image_model']) ?>">
												<small class="form-text text-muted"><?= lang("admin_h326") ?></small>
											</div>
										<?php endif; ?>

										<?php if ($p['type'] === 'compatible'): ?>
											<div class="form-group">
												<label for="base-<?= $id ?>"><?= lang("admin_h287") ?></label>
												<input type="url" class="form-control" id="base-<?= $id ?>" name="ai[<?= $id ?>][base]" dir="ltr"
													value="<?= html_escape($cur['base']) ?>" placeholder="<?= html_escape($p['base'] ?: 'https://openrouter.ai/api/v1') ?>">
											</div>
										<?php endif; ?>

										<small class="form-text text-muted mb-3"><?= lang("admin_h283") ?></small>

										<?php if ($cur['has_key']): ?>
											<button type="submit" name="forget" value="<?= $id ?>" class="btn btn-link text-danger px-0 mb-3" onclick="return confirm('<?= html_escape(lang("admin_h274")) ?>?');"><?= lang("admin_h274") ?></button>
										<?php endif; ?>
									</fieldset>
								<?php endforeach; ?>

								<div>
									<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> <?= lang("admin_h250") ?></button>
									<button type="button" class="btn btn-outline-success" id="ai-test"><i class="fas fa-plug"></i> <?= lang("admin_h263") ?></button>
									<span class="badge badge-success ml-2"><?= lang("admin_h289") ?>: <?= html_escape($providers[$ai['provider']]['label']) ?></span>
								</div>
								<div id="ai-test-result" class="mt-3"></div>

							<?php echo form_close(); ?>
						</div>
					</div>
				</div>

				<div class="col-lg-5">
					<div class="card shadow mb-4">
						<div class="card-body small text-muted">
							<p><i class="fas fa-info-circle text-primary"></i> <?= lang("admin_h267") ?></p>
							<p class="mb-0"><?= lang("admin_h284") ?></p>
						</div>
					</div>
				</div>
			</div>

		</div>
		<!-- /.container-fluid -->

	</div>

<?php include_once 'inc/footer.php'; ?>

<script>
	var savedProvider = <?= json_encode($ai['provider']) ?>;

	// one block of fields per provider: each keeps its own key, model and endpoint
	$('#provider').on('change', function () {
		var p = $(this).val();
		$('.ai-provider').each(function () { this.hidden = this.getAttribute('data-provider') !== p; });
	});

	$('#ai-test').on('click', function () {
		var out = $('#ai-test-result').empty();
		if ($('#provider').val() !== savedProvider) {
			out.append($('<div class="alert alert-warning">').text(<?= json_encode(lang("admin_h290")) ?>));
			return;
		}
		var btn = $(this).prop('disabled', true);
		$.post(base_url + 'admin/ai_test').done(function (r) {
			out.append($('<div class="alert">').addClass(r.ok ? 'alert-success' : 'alert-danger').text(r.ok ? <?= json_encode(lang("admin_h264")) ?> : r.error));
		}).always(function () { btn.prop('disabled', false); });
	});
</script>
