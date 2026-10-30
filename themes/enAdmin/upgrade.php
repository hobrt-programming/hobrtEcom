<?php include_once 'inc/header.php'; ?>

<div id="content-wrapper" class="d-flex flex-column">

	<!-- Main Content -->
	<div id="content">

		<?php include_once 'inc/navbar.php'; ?>

		<div class="container-fluid">

			<div class="my-4">
				<h1 class="h3 mb-2 text-800"><span class="bg-primary rounded px-1 text-light"><i class="fas fa-database"></i> Database update</span></h1>
			</div>

			<div class="card shadow">
				<div class="card-body">

					<?php if ($error): ?>
						<div class="alert alert-danger">The update failed: <?php echo html_escape($error); ?></div>
					<?php elseif ($log !== NULL): ?>
						<div class="alert alert-success">The database was updated.</div>
					<?php endif; ?>

					<p>Database version: <b><?php echo (int) $current; ?></b> &middot; this release needs: <b><?php echo (int) $latest; ?></b></p>

					<?php if ($current < $latest): ?>
						<p>Take a backup of the database first. The update only adds what is missing, it can be run again safely.</p>
						<?php echo form_open("admin/upgrade"); ?>
							<button type="submit" class="btn btn-warning"><i class="fas fa-sync"></i> Update the database</button>
						<?php echo form_close(); ?>
					<?php else: ?>
						<p class="text-success mb-0"><i class="fas fa-check"></i> The database is up to date.</p>
					<?php endif; ?>

					<?php if (!empty($log)): ?>
						<hr>
						<pre class="small mb-0"><?php foreach ($log as $line) echo html_escape($line), "\n"; ?></pre>
					<?php endif; ?>

				</div>
			</div>

		</div>
		<!-- /.container-fluid -->

	</div>

<?php include_once 'inc/footer.php'; ?>
