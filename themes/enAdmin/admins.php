<?php include_once 'inc/header.php'; ?>

<div id="content-wrapper" class="d-flex flex-column">

	<!-- Main Content -->
	<div id="content">

		<?php include_once 'inc/navbar.php'; ?>

			<div class="container-fluid">

				<!-- Page Heading -->
				<div class="my-4">
				<h1 class="h3 mb-2 text-gray-800 my-2"><span class="bg-primary rounded px-2 text-white"><i class="fas fa-user-circle"></i> <?php echo lang("admin_h18") ?></span></h1>
				</div>

				<div class="card shadow mb-4">
					<div class="card-header py-3">
						<h6 class="m-0 font-weight-bold text-primary"><?php echo lang("admin_h206") ?> </h6>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>#</th>
										<th><?php echo lang("admin_h207") ?> </th>
										<th><?php echo lang("admin_h123") ?> </th>
										<th><?php echo lang("admin_h30") ?> </th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th>#</th>
										<th><?php echo lang("admin_h207") ?> </th>
										<th><?php echo lang("admin_h123") ?> </th>
										<th><?php echo lang("admin_h30") ?> </th>
									</tr>
								</tfoot>
								<tbody>
									<?php foreach($admins as $key) { ?>
									<tr>
										<td><?php echo $key->id; ?></td>
										<td><?php echo $key->username; ?></td>
										<td><?php echo $key->email; ?></td>
										<td>
											
											<a href="<?php echo base_url("admin/edit_admin/$key->id"); ?>" class="btn btn-primary btn-circle btn-sm"><i class="fas fa-edit"></i></a>
											<a href="<?php echo csrf_url("admin/delt/admins/$key->id/admins"); ?>" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></a>

										</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>


			</div>

</div>


<?php include_once 'inc/footer.php'; ?>

<script>

	jQuery.extend( jQuery.fn.dataTableExt.oSort, {
		"currency-pre": function ( a ) {
			a = (a==="-") ? 0 : a.replace( /[^\d\-\.]/g, "" );
			return parseFloat( a );
		},

		"currency-asc": function ( a, b ) {
			return a - b;
		},

		"currency-desc": function ( a, b ) {
			return b - a;
		}
	} );
	
	$(document).ready(function() {
		$('#dataTable').DataTable({
			"order": [[ 0, "desc" ]],
			"columns": [
				null,
				null,
				null,
				{ "orderable": false },
			],
		});
	});


</script>