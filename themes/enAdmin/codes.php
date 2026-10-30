<?php include_once 'inc/header.php'; ?>

<style>
	.ace_editor {
		height: 100%;
	}

	.row {
		height: 100%;
	}

	/* ---- AI assistant panel: right side in English, left side in Arabic ---- */
	.ai-panel {
		position: fixed;
		top: 0;
		bottom: 0;
		inset-inline-end: 0;
		width: min(440px, 100vw);
		z-index: 1050;
		display: flex;
		flex-direction: column;
		background: #fff;
		box-shadow: 0 0 24px rgba(16, 24, 40, .18);
		transform: translateX(105%);
		transition: transform .2s ease;
	}

	[dir="rtl"] .ai-panel {
		transform: translateX(-105%);
	}

	.ai-panel.open {
		transform: none !important;
	}

	.ai-head {
		display: flex;
		align-items: center;
		gap: .5rem;
		padding: .9rem 1rem;
		border-bottom: 1px solid #e7eaf0;
	}

	.ai-head h5 {
		margin: 0;
		font-size: 1rem;
		font-weight: 700;
		flex: 1;
	}

	.ai-log {
		flex: 1;
		overflow-y: auto;
		padding: 1rem;
		background: #f7f8fb;
	}

	.ai-msg {
		max-width: 92%;
		margin-bottom: .75rem;
		padding: .6rem .8rem;
		border-radius: .75rem;
		white-space: pre-wrap;
		overflow-wrap: anywhere;
		font-size: .9rem;
		line-height: 1.5;
	}

	.ai-msg.user {
		margin-inline-start: auto;
		background: #4e73df;
		color: #fff;
	}

	.ai-msg.bot {
		background: #fff;
		border: 1px solid #e7eaf0;
		color: #1f2937;
	}

	.ai-msg.error {
		background: #fdecea;
		color: #b42318;
	}

	.ai-note {
		font-size: .75rem;
		color: #6b7280;
		margin: -.35rem 0 .6rem;
	}

	.ai-card {
		background: #fff;
		border: 1px solid #e7eaf0;
		border-radius: .75rem;
		margin-bottom: .75rem;
		overflow: hidden;
	}

	.ai-card-head {
		padding: .55rem .8rem;
		font-size: .85rem;
		border-bottom: 1px solid #e7eaf0;
	}

	.ai-card-head code {
		font-weight: 700;
	}

	.ai-diff {
		margin: 0;
		max-height: 220px;
		overflow: auto;
		font-size: .75rem;
		direction: ltr;
		text-align: left;
	}

	.ai-diff div {
		padding: .3rem .8rem;
		white-space: pre-wrap;
		word-break: break-word;
	}

	.ai-diff .del {
		background: #fdecea;
		color: #912018;
		text-decoration: line-through;
	}

	.ai-diff .ins {
		background: #e7f6ec;
		color: #05603a;
	}

	.ai-card-actions {
		padding: .5rem .8rem;
		display: flex;
		gap: .5rem;
		align-items: center;
	}

	.ai-form {
		padding: .75rem;
		border-top: 1px solid #e7eaf0;
		display: flex;
		gap: .5rem;
	}

	.ai-form textarea {
		resize: none;
		font-size: .9rem;
	}

	.ai-history {
		flex: 1;
		overflow-y: auto;
		background: #f7f8fb;
		padding: .5rem;
	}

	.ai-history-item {
		display: flex;
		align-items: center;
		gap: .5rem;
		padding: .6rem .75rem;
		margin-bottom: .4rem;
		background: #fff;
		border: 1px solid #e7eaf0;
		border-radius: .6rem;
		cursor: pointer;
	}

	.ai-history-item:hover,
	.ai-history-item.current {
		border-color: #4e73df;
	}

	.ai-history-item .title {
		flex: 1;
		font-size: .88rem;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}

	.ai-history-item .date {
		font-size: .72rem;
		color: #6b7280;
		white-space: nowrap;
	}

	.ai-working {
		display: none;
		font-size: .8rem;
		color: #6b7280;
		padding: 0 1rem .5rem;
	}
</style>

<div id="content-wrapper" class="d-flex flex-column">

	<!-- Main Content -->
	<div id="content">

		<?php include_once 'inc/navbar.php'; ?>

		<!-- Begin Page Content -->
		<div class="container-fluid" style="height: 80%;">

			<!-- Page Heading -->
			<div class="my-4 d-flex align-items-center justify-content-between">
				<h1 class="h3 mb-2 text-gray-800 my-2"><span class="bg-primary rounded px-2 text-white"><i class="fas fa-window-restore"></i> <?php echo lang("admin_h16") ?></span></h1>
				<button type="button" class="btn btn-primary" id="ai-open"><i class="fas fa-magic"></i> <?= lang("admin_h257") ?></button>
			</div>
			<div class="row">

				<div class="col-md-3">

					<div class="list-group">

						<?php foreach($files as $f) : ?>

							<a href="<?php echo base_url("admin/template_editor/".basename($f)); ?>" class="list-group-item list-group-item-action <?= isset($file) && basename($f) === $file ? 'active' : '' ?>"><?php echo basename($f); ?></a>

						<?php endforeach; ?>
					</div>

				</div>

				<div class="col-md-9" dir="ltr" style="text-align: left;">

					<?php if (!empty($saved)) : ?>
						<div class="alert alert-success py-2" dir="auto"><?= lang("admin_h292") ?></div>
					<?php elseif (!empty($write_error) || (isset($writable) && !$writable)) : ?>
						<div class="alert alert-warning py-2" dir="auto"><i class="fas fa-lock"></i> <?= lang("admin_h291") ?></div>
					<?php endif; ?>

					<?php if(isset($content)) :  ?>

						<?php echo form_open("", ['class' => "w-100 h-100 form-s"]); ?>

							<textarea id="my-selector" style="height: 100%;"><?php echo htmlspecialchars($content); ?></textarea>

							<textarea name="content" id="test-tarea" style="display: none;"></textarea>

							<button class="btn btn-success test-btn"><?php echo lang("admin_h160") ?></button>

						<?php echo form_close(); ?>


					<?php endif ?>

				</div>

			</div>


		</div>

</div>

<!-- AI assistant -->
<aside class="ai-panel" id="ai-panel" aria-label="<?= html_escape(lang("admin_h257")) ?>">
	<div class="ai-head">
		<i class="fas fa-magic text-primary"></i>
		<h5><?= lang("admin_h257") ?></h5>
		<button type="button" class="btn btn-sm btn-light" id="ai-history-btn" title="<?= html_escape(lang("admin_h294")) ?>" <?= $ai_ready ? '' : 'disabled' ?>><i class="fas fa-history"></i> <?= lang("admin_h294") ?></button>
		<button type="button" class="btn btn-sm btn-light" id="ai-new"><?= lang("admin_h270") ?></button>
		<button type="button" class="btn btn-sm btn-light" id="ai-close" aria-label="<?= html_escape(lang("admin_h281")) ?>"><i class="fas fa-times"></i></button>
	</div>
	<div class="ai-log" id="ai-log">
		<?php if ($ai_ready): ?>
			<p class="small text-muted mb-0"><?= lang("admin_h282") ?></p>
		<?php else: ?>
			<div class="alert alert-warning mb-0">
				<?= lang("admin_h275") ?><br>
				<a href="<?= base_url("admin/ai_settings") ?>"><?= lang("admin_h276") ?></a>
			</div>
		<?php endif; ?>
	</div>
	<div class="ai-history" id="ai-history" hidden></div>
	<div class="ai-working" id="ai-working"><i class="fas fa-spinner fa-spin"></i> <?= lang("admin_h277") ?></div>
	<form class="ai-form" id="ai-form">
		<textarea class="form-control" id="ai-input" rows="2" placeholder="<?= html_escape(lang("admin_h268")) ?>" <?= $ai_ready ? '' : 'disabled' ?>></textarea>
		<button type="submit" class="btn btn-primary" <?= $ai_ready ? '' : 'disabled' ?> aria-label="<?= html_escape(lang("admin_h269")) ?>"><i class="fas fa-paper-plane"></i></button>
	</form>
</aside>


<?php include_once 'inc/footer.php'; ?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/ace.min.js" integrity="sha512-GoORoNnxst42zE3rYPj4bNBm0Q6ZRXKNH2D9nEmNvVF/z24ywVnijAWVi/09iBiVDQVf3UlZHpzhAJIdd9BXqw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/mode-php.min.js" integrity="sha512-YSQw9FaSxTZgE5BlCVUibn8ecWSjFaY+BuGWInXniEtaYTlx96bMX0YLShXKCAU4HeerUTHRDELbqARidAQ9rQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script>

	ace.config.set('basePath', 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/');

	var editor = document.getElementById("my-selector") ? ace.edit("my-selector") : null;
	var editorDirty = false;

	if (editor) {
		editor.setTheme("ace/theme/monokai");
		editor.session.setMode("ace/mode/php");
		editor.session.on('change', function () { editorDirty = true; });
	}

	$('.test-btn').click(function() {

		$('#test-tarea').val(editor.getSession().getValue());

		$('.form-s').submit();

		return false;

	});

	/* ---- AI assistant ---- */
	(function () {
		var T = <?= json_encode(array(
			'apply' => lang("admin_h271"),
			'applied' => lang("admin_h272"),
			'undo' => lang("admin_h273"),
			'proposal' => lang("admin_h278"),
			'limit' => lang("admin_h280"),
			'setup' => lang("admin_h275"),
			'retry' => lang("admin_h285"),
			'failed' => lang("admin_h293"),
			'unsaved' => lang("admin_h286"),
			'empty' => lang("admin_h295"),
			'delete' => lang("admin_h296"),
		), JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?>;
		var openFile = <?= json_encode(isset($file) ? $file : '') ?>;
		var ready = <?= json_encode((bool) $ai_ready) ?>;
		var restored = false;
		var chat = '';
		var busy = false;
		var log = document.getElementById('ai-log');

		function el(tag, cls, text) {
			var e = document.createElement(tag);
			if (cls) e.className = cls;
			if (text !== undefined) e.textContent = text;
			return e;
		}

		function add(node) {
			log.appendChild(node);
			log.scrollTop = log.scrollHeight;
			return node;
		}

		function working(on) {
			busy = on;
			$('#ai-working').toggle(on);
			$('#ai-form button').prop('disabled', on);
		}

		function proposalCard(p) {
			var card = el('div', 'ai-card');
			var head = el('div', 'ai-card-head');
			head.appendChild(el('code', '', p.file));
			head.appendChild(document.createTextNode(' — ' + (p.reason || T.proposal)));
			var diff = el('div', 'ai-diff');
			diff.appendChild(el('div', 'del', p.find));
			diff.appendChild(el('div', 'ins', p.replace));
			var actions = el('div', 'ai-card-actions');
			var apply = el('button', 'btn btn-sm btn-success', T.apply);
			var undo = el('button', 'btn btn-sm btn-outline-secondary', T.undo);
			var state = el('span', 'small text-success');
			var isApplied = p.status === 'applied';
			apply.style.display = isApplied ? 'none' : '';
			undo.style.display = isApplied ? '' : 'none';
			state.textContent = isApplied ? T.applied : '';
			apply.type = undo.type = 'button';

			function act(url, button) {
				if (url.indexOf('apply') > -1 && p.file === openFile && editorDirty && !confirm(T.unsaved)) return;
				button.disabled = true;
				state.textContent = '';
				state.className = 'small text-success';
				$.post(base_url + url, { chat: chat, proposal: p.id }).done(function (r) {
					if (!r || !r.ok) {
						state.className = 'small text-danger';
						state.textContent = (r && r.error) || T.failed;
						button.disabled = false;
						return;
					}
					if (editor && r.file === openFile) { editor.setValue(r.content, -1); editorDirty = false; }
					var applied = url.indexOf('apply') > -1;
					apply.style.display = applied ? 'none' : '';
					undo.style.display = applied ? '' : 'none';
					state.textContent = applied ? T.applied : '';
					apply.disabled = undo.disabled = false;
				}).fail(function (x) {
					state.className = 'small text-danger';
					state.textContent = T.failed + ' (HTTP ' + x.status + ')';
					button.disabled = false;
				});
			}

			apply.onclick = function () { act('admin/ai_apply', apply); };
			undo.onclick = function () { act('admin/ai_undo', undo); };
			actions.appendChild(apply);
			actions.appendChild(undo);
			actions.appendChild(state);
			card.appendChild(head);
			card.appendChild(diff);
			card.appendChild(actions);
			return card;
		}

		// one server step = one model call; repeat while the assistant is still working
		function step(message) {
			working(true);
			$.post(base_url + 'admin/ai_chat', { chat: chat, message: message, file: openFile })
				.done(function (r) {
					if (r.setup) { add(el('div', 'ai-msg error', T.setup)); working(false); return; }
					if (r.chat) chat = r.chat;
					if (!r.ok) {
						var box = add(el('div', 'ai-msg error', r.error + ' '));
						var retry = el('a', '', T.retry);
						retry.href = '#';
						retry.onclick = function (e) { e.preventDefault(); box.remove(); step(message); };
						box.appendChild(retry);
						working(false);
						return;
					}
					(r.notes || []).forEach(function (n) { add(el('div', 'ai-note', '· ' + n)); });
					if (r.text) add(el('div', 'ai-msg bot', r.text));
					(r.proposals || []).forEach(function (p) { add(proposalCard(p)); });
					if (r.limit) add(el('div', 'ai-note', T.limit));
					if (r.continue) step('');
					else working(false);
				})
				.fail(function (x) {
					add(el('div', 'ai-msg error', 'HTTP ' + x.status));
					working(false);
				});
		}

		function clearLog() {
			$(log).find('.ai-msg, .ai-note, .ai-card').remove();
		}

		function showLog() {
			$('#ai-history').prop('hidden', true);
			log.hidden = false;
		}

		// a saved chat: its transcript, with proposals as they are now (pending or applied)
		function render(v) {
			clearLog();
			chat = v.chat;
			(v.transcript || []).forEach(function (t) {
				if (t.type === 'user') add(el('div', 'ai-msg user', t.text));
				else if (t.type === 'bot') add(el('div', 'ai-msg bot', t.text));
				else if (t.type === 'note') add(el('div', 'ai-note', '· ' + t.text));
				else if (t.type === 'limit') add(el('div', 'ai-note', T.limit));
				else if (t.type === 'proposal' && v.proposals[t.id]) add(proposalCard(v.proposals[t.id]));
			});
		}

		function load(id) {
			$.post(base_url + 'admin/ai_load', { chat: id }).done(function (r) {
				if (r && r.ok) { render(r); showLog(); }
			});
		}

		function history(then) {
			$.post(base_url + 'admin/ai_history', { file: openFile }).done(function (r) {
				then((r && r.chats) || []);
			});
		}

		function showHistory() {
			var box = $('#ai-history').empty().prop('hidden', false);
			log.hidden = true;
			history(function (chats) {
				if (!chats.length) box.append(el('p', 'small text-muted p-2 mb-0', T.empty));
				chats.forEach(function (c) {
					var item = el('div', 'ai-history-item' + (c.chat === chat ? ' current' : ''));
					var del = el('button', 'btn btn-sm btn-link text-danger p-0');
					del.type = 'button';
					del.innerHTML = '<i class="fas fa-trash-alt"></i>';
					del.onclick = function (e) {
						e.stopPropagation();
						if (!confirm(T.delete)) return;
						$.post(base_url + 'admin/ai_delete', { chat: c.chat }).done(function () {
							item.remove();
							if (c.chat === chat) { chat = ''; clearLog(); }
						});
					};
					item.appendChild(el('span', 'title', c.title || '…'));
					item.appendChild(el('span', 'date', c.updated));
					item.appendChild(del);
					item.onclick = function () { if (!busy) load(c.chat); };
					box.append(item);
				});
			});
		}

		$('#ai-open').on('click', function () {
			$('#ai-panel').addClass('open');
			$('#ai-input').focus();
			// first time: bring back the latest chat for this page
			if (ready && !restored) {
				restored = true;
				history(function (chats) { if (chats.length && !chat) load(chats[0].chat); });
			}
		});
		$('#ai-close').on('click', function () { $('#ai-panel').removeClass('open'); });
		$('#ai-history-btn').on('click', function () {
			if (busy) return;
			if ($('#ai-history').prop('hidden')) showHistory(); else showLog();
		});
		$('#ai-new').on('click', function () {
			if (busy) return;
			chat = '';
			clearLog();
			showLog();
		});

		$('#ai-form').on('submit', function (e) {
			e.preventDefault();
			var text = $.trim($('#ai-input').val());
			if (!text || busy) return;
			showLog();
			add(el('div', 'ai-msg user', text));
			$('#ai-input').val('');
			step(text);
		});

		$('#ai-input').on('keydown', function (e) {
			if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); $('#ai-form').trigger('submit'); }
		});
	})();

</script>
