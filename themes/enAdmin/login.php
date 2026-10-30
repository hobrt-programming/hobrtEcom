<?php $rtl = lang('admin_h55') === 'rtl'; ?>
<!DOCTYPE html>
<html lang="<?= $rtl ? 'ar' : 'en' ?>" dir="<?= $rtl ? 'rtl' : 'ltr' ?>">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex, nofollow">
	<base href="<?php echo base_url(); ?>themes/enAdmin/">

	<title><?= html_escape(setting("title")) ?> · <?= lang("admin_h300") ?></title>

	<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="css/sb-admin-2.min.css" rel="stylesheet">

	<style>
		body {
			min-height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 1.5rem 1rem;
			background: #f4f6fa;
			background-image: radial-gradient(circle at 15% 10%, rgba(78, 115, 223, .16), transparent 45%), radial-gradient(circle at 90% 95%, rgba(28, 200, 138, .12), transparent 40%);
		}

		.login-card {
			text-align: start;   /* Bootstrap's reboot forces left */
			width: 100%;
			max-width: 410px;
			background: #fff;
			border: 1px solid #e7eaf0;
			border-radius: 1rem;
			box-shadow: 0 12px 32px rgba(16, 24, 40, .08);
			padding: 2.25rem 2rem 1.75rem;
		}

		.login-brand {
			text-align: center;
			margin-bottom: 1.5rem;
		}

		.login-brand img {
			max-height: 56px;
			max-width: 200px;
			margin-bottom: .9rem;
		}

		.login-brand h1 {
			font-size: 1.2rem;
			font-weight: 700;
			color: #1f2937;
			margin: 0 0 .25rem;
		}

		.login-brand p {
			color: #6b7280;
			font-size: .9rem;
			margin: 0;
		}

		.login-card label {
			font-weight: 600;
			font-size: .85rem;
			color: #374151;
			margin-bottom: .35rem;
		}

		.field {
			position: relative;
		}

		.field > .fas {
			position: absolute;
			top: 50%;
			inset-inline-start: .95rem;
			transform: translateY(-50%);
			color: #9ca3af;
			pointer-events: none;
		}

		.field .form-control {
			height: 2.9rem;
			border-radius: .6rem;
			border-color: #dfe3ea;
			padding-inline: 2.6rem;
			font-size: .95rem;
		}

		.field .form-control:focus {
			border-color: #a5b8f3;
			box-shadow: 0 0 0 .2rem rgba(78, 115, 223, .15);
		}

		.toggle-pass {
			position: absolute;
			top: 50%;
			inset-inline-end: .5rem;
			transform: translateY(-50%);
			border: 0;
			background: none;
			color: #9ca3af;
			padding: .35rem .5rem;
			border-radius: .4rem;
		}

		.toggle-pass:hover,
		.toggle-pass:focus {
			color: #4e73df;
			outline: none;
			background: #f1f4fd;
		}

		.btn-login {
			height: 2.9rem;
			border-radius: .6rem;
			font-weight: 600;
			font-size: .95rem;
		}

		.login-error {
			border-radius: .6rem;
			font-size: .88rem;
			padding: .65rem .9rem;
		}

		.login-foot {
			text-align: center;
			margin-top: 1.25rem;
			font-size: .85rem;
		}

		.login-foot a {
			color: #6b7280;
		}
	</style>
</head>

<body>

	<main class="login-card">
		<div class="login-brand">
			<?php if (setting("logo") !== '' && setting("logo") !== '-'): ?>
				<img src="<?= store_logo() ?>" alt="">
			<?php endif; ?>
			<h1><?= html_escape(setting("title")) ?></h1>
			<p><?= lang("admin_h297") ?></p>
		</div>

		<?php if (!isset($msg) && $this->input->get('out')): ?>
			<div class="alert alert-success login-error" role="status"><i class="fas fa-check-circle"></i> <?= lang("admin_h314") ?></div>
		<?php endif; ?>

		<?php if (isset($msg)): ?>
			<div class="alert alert-danger login-error" role="alert"><i class="fas fa-exclamation-circle"></i> <?= html_escape($msg) ?></div>
		<?php endif; ?>

		<form action="" method="post" autocomplete="on">
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

			<div class="form-group">
				<label for="u"><?= lang("admin_h298") ?></label>
				<div class="field">
					<i class="fas fa-user"></i>
					<input type="text" class="form-control" id="u" name="u" required autofocus autocomplete="username" dir="auto"
						value="<?= html_escape((string) $this->input->post('u')) ?>">
				</div>
			</div>

			<div class="form-group mb-4">
				<label for="p"><?= lang("admin_h299") ?></label>
				<div class="field">
					<i class="fas fa-lock"></i>
					<input type="password" class="form-control" id="p" name="p" required autocomplete="current-password" dir="ltr">
					<button type="button" class="toggle-pass" id="toggle-pass" aria-label="<?= html_escape(lang("admin_h301")) ?>" title="<?= html_escape(lang("admin_h301")) ?>"><i class="fas fa-eye"></i></button>
				</div>
			</div>

			<button type="submit" class="btn btn-primary btn-block btn-login"><?= lang("admin_h300") ?></button>
		</form>

		<div class="login-foot">
			<a href="<?= base_url() ?>"><i class="fas <?= $rtl ? 'fa-arrow-right' : 'fa-arrow-left' ?>"></i> <?= lang("admin_h302") ?></a>
		</div>
	</main>

	<script>
		document.getElementById('toggle-pass').addEventListener('click', function () {
			var input = document.getElementById('p'), show = input.type === 'password';
			input.type = show ? 'text' : 'password';
			this.querySelector('i').className = show ? 'fas fa-eye-slash' : 'fas fa-eye';
		});
	</script>

</body>

</html>
