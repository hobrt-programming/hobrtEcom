<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * "Fill with AI" button + dialog for the product and landing page forms.
 * Include it in the card header of the form, after setting
 * $ai_fill_form = 'product' or 'landing'. Fills the form, saves nothing:
 * created photos go to the product gallery (or the top of the landing page
 * text) and are only kept when the admin submits the form.
 */
$ai_landing = $ai_fill_form === 'landing';
$CI = &get_instance();
$CI->load->library('hb_ai');
$ai_can_draw = $CI->hb_ai->image_provider() !== '';
?>
<button type="button" class="btn btn-sm ai-fill-btn" id="ai-fill-btn" data-toggle="modal" data-target="#ai-fill-modal">
	<i class="fas fa-magic"></i> <?= lang("admin_h315") ?>
</button>

<div class="modal fade" id="ai-fill-modal" tabindex="-1" role="dialog" aria-labelledby="ai-fill-title" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<form class="modal-content" id="ai-fill-form">
			<div class="modal-header">
				<h5 class="modal-title" id="ai-fill-title"><i class="fas fa-magic text-primary"></i> <?= lang("admin_h315") ?></h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="<?= html_escape(lang("admin_h281")) ?>"><span aria-hidden="true">×</span></button>
			</div>
			<div class="modal-body">
				<p class="small text-muted mb-3"><?= lang($ai_landing ? "admin_h318" : "admin_h316") ?></p>

				<label class="ai-photo" id="ai-photo-box">
					<input type="file" id="ai-fill-photo" accept="image/jpeg,image/png" hidden>
					<span class="ai-photo-empty"><i class="fas fa-camera"></i> <?= lang("admin_h327") ?><small><?= lang("admin_h328") ?></small></span>
					<img alt="" id="ai-photo-preview" style="display:none">
					<button type="button" class="ai-photo-remove" id="ai-photo-remove" style="display:none" aria-label="<?= html_escape(lang("admin_h329")) ?>" title="<?= html_escape(lang("admin_h329")) ?>">×</button>
				</label>

				<textarea class="form-control mt-3" id="ai-fill-brief" rows="4" maxlength="3000" dir="auto" placeholder="<?= html_escape(lang($ai_landing ? "admin_h319" : "admin_h317")) ?>"></textarea>

				<?php if ($ai_landing): ?>
					<label class="small font-weight-bold mt-3 mb-1" for="ai-fill-feedback"><i class="fas fa-comments text-primary"></i> <?= lang("admin_h338") ?></label>
					<textarea class="form-control" id="ai-fill-feedback" rows="3" maxlength="6000" dir="auto" placeholder="<?= html_escape(lang("admin_h339")) ?>"></textarea>
					<small class="form-text text-muted"><?= lang("admin_h340") ?></small>
				<?php endif; ?>

				<div class="ai-images mt-3">
					<div class="custom-control custom-switch">
						<input type="checkbox" class="custom-control-input" id="ai-fill-draw" <?= $ai_can_draw ? 'checked' : 'disabled' ?>>
						<label class="custom-control-label" for="ai-fill-draw"><?= lang("admin_h330") ?></label>
					</div>
					<select class="custom-select custom-select-sm" id="ai-fill-count" <?= $ai_can_draw ? '' : 'disabled' ?> aria-label="<?= html_escape(lang("admin_h330")) ?>">
						<?php for ($n = 1; $n <= 4; $n++): ?><option value="<?= $n ?>" <?= $n === 2 ? 'selected' : '' ?>><?= $n ?></option><?php endfor; ?>
					</select>
				</div>
				<p class="small text-muted mt-1 mb-0" id="ai-draw-hint">
					<?php if (!$ai_can_draw): ?>
						<?= lang("admin_h331") ?> <a href="<?= base_url("admin/ai_settings") ?>"><?= lang("admin_h276") ?></a>
					<?php else: ?>
						<span class="with-photo" style="display:none"><?= lang("admin_h332") ?></span>
						<span class="no-photo"><?= lang("admin_h333") ?></span>
					<?php endif; ?>
				</p>

				<p class="small text-muted mt-3 mb-0"><i class="fas fa-info-circle"></i> <?= lang("admin_h320") ?></p>
				<div class="ai-progress mt-3" id="ai-fill-progress" style="display:none"></div>
				<div class="alert alert-danger small mt-3 mb-0" id="ai-fill-error" style="display:none"></div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" type="button" data-dismiss="modal"><?= lang("admin_h313") ?></button>
				<button class="btn btn-primary" type="submit" id="ai-fill-go">
					<span class="go"><i class="fas fa-magic"></i> <?= lang("admin_h321") ?></span>
					<span class="busy" style="display:none"><span class="spinner-border spinner-border-sm"></span> <?= lang("admin_h277") ?></span>
				</button>
			</div>
		</form>
	</div>
</div>

<style>
	.ai-fill-btn { background: linear-gradient(135deg, #6f42c1, #4e73df); color: #fff; border: 0; border-radius: 2rem; padding: .3rem .9rem; }
	.ai-fill-btn:hover, .ai-fill-btn:focus { color: #fff; filter: brightness(1.08); }
	.ai-filled, .ai-filled + .note-editor { background-color: #f6f2ff !important; border-color: #b9a3f0 !important; transition: background-color .4s; }
	.ai-photo { position: relative; display: flex; align-items: center; justify-content: center; width: 100%; min-height: 120px; margin: 0; border: 2px dashed #d1d6e2; border-radius: .6rem; background: #fafbfd; cursor: pointer; overflow: hidden; }
	.ai-photo:hover, .ai-photo.drag { border-color: #6f42c1; background: #f6f2ff; }
	.ai-photo-empty { display: flex; flex-direction: column; align-items: center; gap: .25rem; color: #6e7687; font-weight: 600; text-align: center; padding: 1rem; }
	.ai-photo-empty .fas { font-size: 1.6rem; color: #6f42c1; }
	.ai-photo-empty small { font-weight: 400; }
	.ai-photo img { max-height: 200px; max-width: 100%; display: block; }
	.ai-photo-remove { position: absolute; top: .4rem; inset-inline-end: .4rem; width: 1.9rem; height: 1.9rem; border: 0; border-radius: 50%; background: rgba(0,0,0,.6); color: #fff; font-size: 1.2rem; line-height: 1; }
	.ai-images { display: flex; align-items: center; justify-content: space-between; gap: 1rem; }
	.ai-images .custom-select { width: 4.5rem; }
	.ai-progress div { font-size: .85rem; color: #4b5563; padding: .15rem 0; }
	.ai-progress .fa-check { color: #1cc88a; }
	.ai-progress .fa-times { color: #e74a3b; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
	var FORM = <?= json_encode($ai_fill_form) ?>,
		T = <?= json_encode(array(
			'done' => lang("admin_h322"), 'setup' => lang("admin_h275"), 'open' => lang("admin_h276"), 'failed' => lang("admin_h324"),
			'reviews' => lang("admin_h341"), 'upload' => lang("admin_h334"), 'write' => lang("admin_h335"), 'image' => lang("admin_h336"), 'imagesFailed' => lang("admin_h344"),
		), JSON_UNESCAPED_UNICODE) ?>,
		$btn = $('#ai-fill-btn'),
		$f = $btn.closest('.card').find('form').not('#ai-fill-form').first(),
		$modal = $('#ai-fill-modal').appendTo('body'),
		$err = $('#ai-fill-error'),
		$progress = $('#ai-fill-progress'),
		photoFile = null,     // chosen, not uploaded yet
		photoName = '',       // uploaded file name in uploads/
		busy = false;

	$modal.on('shown.bs.modal', function () { $('#ai-fill-brief').trigger('focus'); });
	$modal.on('hide.bs.modal', function (e) { if (busy) e.preventDefault(); });

	/* ---------- photo ---------- */

	function setPhoto(file) {
		if (file && !/^image\/(jpeg|png)$/.test(file.type)) return;
		photoFile = file || null;
		photoName = '';
		var $img = $('#ai-photo-preview');
		if (photoFile) $img.attr('src', URL.createObjectURL(photoFile)).show();
		else $img.removeAttr('src').hide();
		$('.ai-photo-empty').toggle(!photoFile);
		$('#ai-photo-remove').toggle(!!photoFile);
		$('#ai-draw-hint .with-photo').toggle(!!photoFile);
		$('#ai-draw-hint .no-photo').toggle(!photoFile);
	}

	$('#ai-fill-photo').on('change', function () { setPhoto(this.files[0]); this.value = ''; });
	$('#ai-photo-remove').on('click', function (e) { e.preventDefault(); e.stopPropagation(); setPhoto(null); });
	$('#ai-photo-box').on('dragover', function (e) { e.preventDefault(); $(this).addClass('drag'); })
		.on('dragleave drop', function () { $(this).removeClass('drag'); })
		.on('drop', function (e) { e.preventDefault(); var f = e.originalEvent.dataTransfer.files[0]; if (f) setPhoto(f); });

	function uploadPhoto() {
		if (!photoFile || photoName) return $.Deferred().resolve(photoName).promise();
		step(T.upload);
		var fd = new FormData();
		fd.append('file', photoFile);
		return $.ajax({ url: base_url + 'admin/upload', type: 'post', data: fd, processData: false, contentType: false, dataType: 'text' })
			.then(function (name) {
				name = $.trim(name);
				if (!/^[\w-]+\.(jpe?g|png|gif)$/i.test(name)) return $.Deferred().reject().promise();
				photoName = name;
				done();
				if (FORM === 'product') addToGallery(name);
				return name;
			});
	}

	/* ---------- form ---------- */

	function isRich($el) { return $el.is('textarea') && $el.next('.note-editor').length > 0; }

	// the form values, with tp[]/info[] as lists and the editors' HTML
	function current() {
		var out = {};
		$.each($f.serializeArray(), function (_, p) {
			var k = p.name.replace(/\[\]$/, '');
			if (p.name.slice(-2) === '[]') (out[k] = out[k] || []).push(p.value);
			else out[k] = p.value;
		});
		$f.find('textarea').each(function () {
			if (isRich($(this))) out[this.name] = $(this).summernote('code');
		});
		return out;
	}

	function mark($el) {
		$el.addClass('ai-filled').one('focus input change', function () { $(this).removeClass('ai-filled'); });
	}

	function setVariants(list) {
		var $rows = $f.find('input[name="tp[]"]').closest('.row'), $first = $rows.first();
		$rows.slice(1).remove();
		$first.find('[name="tp[]"]').val(list[0].tp);
		$first.find('[name="info[]"]').val(list[0].info);
		var plus = $first.find('.btn-success')[0];
		for (var i = list.length - 1; i >= 1; i--) {
			addOptions(plus);   // inserts a row right after the first one
			var $r = $first.next('.row');
			$r.find('[name="tp[]"]').val(list[i].tp);
			$r.find('[name="info[]"]').val(list[i].info);
		}
		$f.find('input[name="tp[]"], input[name="info[]"]').attr('dir', 'auto').each(function () { mark($(this)); });
	}

	function fill(fields) {
		$.each(fields, function (name, value) {
			if (name === 'variants') return setVariants(value);
			if (name === 'reviews') {
				if (typeof addReviewRow === 'function') $.each(value, function (_, r) { mark(addReviewRow(r).find('td')); });
				return;
			}
			var $el = $f.find('[name="' + name + '"]').first();
			if (!$el.length) return;
			if (isRich($el)) $el.summernote('code', value);
			else $el.val(value).trigger('change');
			if ($el.is('input[type=text], input:not([type]), textarea')) $el.attr('dir', 'auto');
			mark($el);
		});
	}

	// landing: the photos go in the {{image1}}, {{image2}}... places the AI left in the text
	var slot = 0;
	function landingEditor() { return $f.find('textarea[name="content"]'); }
	function placeImage(name) {
		var $ed = landingEditor(), html = $ed.summernote('code'), tag = '<img class="lp-img" src="' + base_url + 'uploads/' + name + '" alt="">';
		slot++;
		var re = new RegExp('(<p>\\s*)?\\{\\{image' + slot + '\\}\\}(\\s*</p>)?');
		$ed.summernote('code', re.test(html) ? html.replace(re, tag) : tag + html);
	}
	function clearSlots() {
		var $ed = landingEditor();
		if (!$ed.length) return;
		var html = $ed.summernote('code'), clean = html.replace(/(<p>\s*)?\{\{image\d+\}\}(\s*<\/p>)?/g, '');
		if (clean !== html) $ed.summernote('code', clean);
	}

	// product: add to the gallery (Dropzone + the hidden images list); landing: into the page text
	function addToGallery(name) {
		var url = base_url + 'uploads/' + name;
		if (FORM === 'landing') return placeImage(name);
		var $list = $f.find('.images'), list = $list.val() === '' ? [] : $list.val().split(',');
		if (list.indexOf(name) === -1) list.push(name);
		$list.val(list.join(','));
		var el = $f.find('.dropzone')[0], dz = el && el.dropzone;
		if (dz) {
			var mock = { name: name, serverName: name, size: 0, isMock: true, accepted: true };
			dz.emit('addedfile', mock);
			dz.emit('thumbnail', mock, url);
			dz.emit('complete', mock);
			dz.files.push(mock);
		}
	}

	/* ---------- progress ---------- */

	function step(text) {
		$progress.show().append($('<div>').append('<span class="spinner-border spinner-border-sm"></span> ', document.createTextNode(text)));
	}
	function done(ok) {
		$progress.children().last().find('.spinner-border').replaceWith(ok === false ? '<i class="fas fa-times"></i>' : '<i class="fas fa-check"></i>');
	}

	function notice(text) {
		$f.find('.ai-fill-notice').remove();
		$('<div class="alert alert-info ai-fill-notice d-flex align-items-start" role="status"><i class="fas fa-magic mt-1"></i><div class="mx-2"></div></div>')
			.find('div').text(text).end()
			.prependTo($f);
		$('html, body').animate({ scrollTop: $f.offset().top - 90 }, 300);
	}

	// image problems get their own warning, so they are not lost in the notice
	function warn(text) {
		$f.find('.ai-fill-warning').remove();
		$('<div class="alert alert-warning ai-fill-warning" role="alert"><strong></strong><div class="small mt-1"></div><a class="small font-weight-bold"></a></div>')
			.find('strong').text(T.imagesFailed).end()
			.find('div').text(text).end()
			.find('a').attr('href', base_url + 'admin/ai_settings').text(T.open).end()
			.insertAfter($f.find('.ai-fill-notice'));
	}

	function setBusy(on) {
		busy = on;
		$('#ai-fill-go').prop('disabled', on).find('.go').toggle(!on).end().find('.busy').toggle(on);
		$('#ai-fill-brief, #ai-fill-photo').prop('disabled', on);
		$modal.find('[data-dismiss]').prop('disabled', on);
	}

	function post(path, data) {
		return $.ajax({ url: base_url + path, type: 'post', dataType: 'json', data: data }).then(function (r) {
			return r && r.ok ? r : $.Deferred().reject(r).promise();
		});
	}

	function showError(r) {
		done(false);
		if (r && r.setup)
			$err.empty().append(document.createTextNode(T.setup + ' '), $('<a>').attr('href', base_url + 'admin/ai_settings').text(T.open)).show();
		else
			$err.text((r && r.error) || T.failed).show();
	}

	$('#ai-fill-form').on('submit', function (e) {
		e.preventDefault();
		if (busy) return;
		$err.hide();
		$progress.empty().hide();
		setBusy(true);

		var draw = $('#ai-fill-draw').is(':checked') ? +$('#ai-fill-count').val() : 0, result;
		slot = 0;

		uploadPhoto().then(function () {
			step(T.write);
			return post('admin/ai_fill', {
				form: FORM, brief: $('#ai-fill-brief').val(), photo: photoName, current: JSON.stringify(current()),
				feedback: $('#ai-fill-feedback').val() || '', images: FORM === 'landing' ? (photoName ? 1 : 0) + draw : 0
			});
		}).then(function (r) {
			done();
			result = r;
			fill(r.fields);
			if (r.fields.reviews) { step(T.reviews.replace('%1', r.fields.reviews.length)); done(); }
			if (FORM === 'landing' && photoName && r.fields.content) placeImage(photoName);   // your photo first

			// the images one after the other, each shown as soon as it is ready
			var chain = $.Deferred().resolve().promise(), failed = '';
			for (var i = 0; i < draw; i++) (function (i) {
				chain = chain.then(function () {
					if (failed) return;
					step(T.image.replace('%1', i + 1).replace('%2', draw));
					return post('admin/ai_image', { index: i, photo: photoName, looks: r.image_prompt || '', title: (r.fields.title || $f.find('[name="title"]').val() || '') })
						.then(function (img) { done(); addToGallery(img.file); }, function (x) { done(false); failed = (x && x.error) || T.failed; return $.Deferred().resolve().promise(); });
				});
			})(i);
			return chain.then(function () { return failed; });
		}).then(function (imageError) {
			if (FORM === 'landing') clearSlots();
			$('#ai-fill-feedback').val('');
			setBusy(false);
			$modal.modal('hide');
			notice(T.done + (result.note ? ' ' + result.note : ''));
			if (imageError) warn(imageError);
			setPhoto(null);
			$progress.empty().hide();
		}, function (r) {
			setBusy(false);
			showError(r && r.responseJSON ? r.responseJSON : r);
		});
	});
});
</script>
