<?php include_once 'inc/header.php'; ?>


<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker3.min.css">


<div id="content-wrapper" class="d-flex flex-column">

	<!-- Main Content -->
	<div id="content">

		<?php include_once 'inc/navbar.php'; ?>

		<div class="container-fluid">
		<div class="my-4">
				<!-- Page Heading -->
				<h1 class="h3 mb-2 text-gray-800 my-2"><span class="bg-primary rounded px-2 text-white"><i class="fas fa-tachometer-alt"></i> <?= lang("admin_h68") ?></span></h1>
				</div>
				<!-- DataTales Example -->
				<div class="card shadow mb-4">
					<div class="card-header py-3">
						<h6 class="m-0 font-weight-bold text-primary"> <?= lang("admin_h69") ?></h6>
					</div>
					<div class="card-body">

							<div class="row">

								<!-- Earnings (Monthly) Card Example -->
								<div class="col-xl-4 col-md-6 mb-4">
									<div class="card border-left-primary shadow h-100 py-2">
										<div class="card-body">
											<div class="row no-gutters align-items-center">
												<div class="col mr-2">
													<div class="text-xs font-weight-bold text-primary text-uppercase mb-1"> <?= lang("admin_h70") ?></div>
													<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total; ?></div>
												</div>
												<div class="col-auto">
													<i class="fas fa-cart-plus fa-2x text-gray-500"></i>
												</div>
											</div>
										</div>
									</div>
								</div>

								<!-- Earnings (Monthly) Card Example -->
								<div class="col-xl-4 col-md-6 mb-4">
									<div class="card border-left-success shadow h-100 py-2">
										<div class="card-body">
											<div class="row no-gutters align-items-center">
												<div class="col mr-2">
													<div class="text-xs font-weight-bold text-primary text-uppercase mb-1"> <?= lang("admin_h71") ?></div>
													<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $tc; ?></div>
												</div>
												<div class="col-auto">
													<i class="far fa-check-circle fa-2x text-success"></i>
												</div>
											</div>
										</div>
									</div>
								</div>

								<!-- Earnings (Monthly) Card Example -->
								<div class="col-xl-4 col-md-6 mb-4">
									<div class="card border-left-info shadow h-100 py-2">
										<div class="card-body">
											<div class="row no-gutters align-items-center">
												<div class="col mr-2">
													<div class="text-xs font-weight-bold text-primary text-uppercase mb-1"> <?= lang("admin_h72") ?></div>
													<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total > 0 ? floor($tc / $total * 100) : 0; ?> %</div>
												</div>
												<div class="col-auto">
													<i class="far fa-chart-bar fa-2x text-primary"></i>
												</div>
											</div>
										</div>
									</div>
								</div>

							</div>

					</div>
				</div>

				<form action="" method="get">

					<div class="row" style="margin-bottom: 20px;">
						<div class="col-md-3"><input type="text" class="datep form-control" autocomplete="off" name="date4" value="<?php echo $_GET['date4'] ?? ""; ?>" placeholder="<?= lang("admin_h91") ?>"></div>
						<div class="col-md-3"><input type="text" class="datep form-control" autocomplete="off" name="date3" value="<?php echo $_GET['date3'] ?? ""; ?>" placeholder="<?= lang("admin_h92") ?>"></div>

						<div class="col-md-2">

							<button class="btn btn-success" type="submit" name="test"> <?= lang("admin_h73") ?></button>

						</div>
					</div>

				</form>

				<!-- DataTales Example -->
				<div class="card shadow mb-4">
					<div class="card-header py-3">
						<h6 class="m-0 font-weight-bold text-primary"> <?= lang("admin_h4") ?></h6>
					</div>
					<div class="card-body">

							<div class="row">

								<div class="chart-area">
									<canvas id="myAreaChart"></canvas>
								</div>

							</div>

					</div>
				</div>

								<!-- DataTales Example -->
				<div class="card shadow mb-4">
					<div class="card-header py-3">
						<h6 class="m-0 font-weight-bold text-primary"> <?= lang("admin_h74") ?></h6>
					</div>
					<div class="card-body">

							<div class="row">

								<!-- Earnings (Monthly) Card Example -->
								<div class="col-xl-4 col-md-6 mb-4">
									<div class="card border-left-primary shadow h-100 py-2">
										<div class="card-body">
											<div class="row no-gutters align-items-center">
												<div class="col mr-2">
													<div class="text-xs font-weight-bold text-primary text-uppercase mb-1"> <?= lang("admin_h70") ?></div>
													<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total; ?></div>
												</div>
												<div class="col-auto">
													<i class="fas fa-cart-plus fa-2x text-gray-500"></i>
												</div>
											</div>
										</div>
									</div>
								</div>

								<!-- Earnings (Monthly) Card Example -->
								<div class="col-xl-4 col-md-6 mb-4">
									<div class="card border-left-success shadow h-100 py-2">
										<div class="card-body">
											<div class="row no-gutters align-items-center">
												<div class="col mr-2">
													<div class="text-xs font-weight-bold text-primary text-uppercase mb-1"> <?= lang("admin_h71") ?></div>
													<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $tc; ?></div>
												</div>
												<div class="col-auto">

													<i class="far fa-check-circle fa-2x text-success"></i>
												</div>
											</div>
										</div>
									</div>
								</div>

								<!-- Earnings (Monthly) Card Example -->
								<div class="col-xl-4 col-md-6 mb-4">
									<div class="card border-left-info shadow h-100 py-2">
										<div class="card-body">
											<div class="row no-gutters align-items-center">
												<div class="col mr-2">
													<div class="text-xs font-weight-bold text-primary text-uppercase mb-1"> <?= lang("admin_h75") ?></div>
													<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $ts; ?></div>
												</div>
												<div class="col-auto">
													<i class="fas fa-truck fa-2x text-success"></i>
												</div>
											</div>
										</div>
									</div>
								</div>

								<!-- Earnings (Monthly) Card Example -->
								<div class="col-xl-4 col-md-6 mb-4">
									<div class="card border-left-info shadow h-100 py-2">
										<div class="card-body">
											<div class="row no-gutters align-items-center">
												<div class="col mr-2">
													<div class="text-xs font-weight-bold text-primary text-uppercase mb-1"> <?= lang("admin_h76") ?></div>
													<div class="h5 mb-0 font-weight-bold text-gray-800"><?php $p = numfmt_format_currency($formatter, $productsPrices ?? 0, $currency); echo $p; ?></div>
												</div>
												<div class="col-auto">
													<i class="fas fa-money-bill fa-2x text-success"></i>
												</div>
											</div>
										</div>
									</div>
								</div>

								<!-- Earnings (Monthly) Card Example -->
								<div class="col-xl-4 col-md-6 mb-4">
									<div class="card border-left-primary shadow h-100 py-2">
										<div class="card-body">
											<div class="row no-gutters align-items-center">
												<div class="col mr-2">
													<div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><?= lang("admin_h77") ?></div>
													<div class="h5 mb-0 font-weight-bold text-gray-800"><?php $profitPerOrder = ($deliveredOrdersCount > 0) ? ($productsPrices / $deliveredOrdersCount) : 0; $profitPerOrderFormatted = numfmt_format_currency($formatter, $profitPerOrder, $currency); echo $profitPerOrderFormatted; ?></div>
												</div>
												<div class="col-auto">
												<i class="fas fa-money-bill fa-2x text-success"></i>
												</div>
											</div>
										</div>
									</div>
								</div>

								<!-- Earnings (Monthly) Card Example -->
								<div class="col-xl-4 col-md-6 mb-4">
									<div class="card border-left-success shadow h-100 py-2">
										<div class="card-body">
											<div class="row no-gutters align-items-center">
												<div class="col mr-2">
													<div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><?= lang("admin_h78") ?></div>
													<div class="h5 mb-0 font-weight-bold text-gray-800"><?php $averageOrderValue = ($deliveredOrdersCount > 0) ? ($productsPrices / $deliveredOrdersCount) : 0; $averageOrderValueFormatted = numfmt_format_currency($formatter, $averageOrderValue, $currency); echo $averageOrderValueFormatted; ?></div>
												</div>
												<div class="col-auto">
													<i class="fas fa-chart-pie fa-2x text-success"></i>
												</div>
											</div>
										</div>
									</div>
								</div>

								<!-- Earnings (Monthly) Card Example -->
								<div class="col-xl-4 col-md-6 mb-4">
									<div class="card border-left-info shadow h-100 py-2">
										<div class="card-body">
											<div class="row no-gutters align-items-center">
												<div class="col mr-2">
													<div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><?= lang("admin_h72") ?></div>
													<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total > 0 ? number_format(($tc/$total)*100, 2) : 0; ?> %</div>
												</div>
												<div class="col-auto">
													<i class="fas fa-industry fa-2x text-primary"></i>
												</div>
											</div>
										</div>
									</div>
								</div>

								<!-- Earnings (Monthly) Card Example -->
								<div class="col-xl-4 col-md-6 mb-4">
									<div class="card border-left-info shadow h-100 py-2">
										<div class="card-body">
											<div class="row no-gutters align-items-center">
												<div class="col mr-2">
													<div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><?= lang("admin_h79") ?></div>
													<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo ($tc > 0) ? number_format($ts/$tc*100, 2) : 0; ?>%</div>
												</div>
												<div class="col-auto">
												<i class="fas fa-industry fa-2x text-primary"></i>
												</div>
											</div>
										</div>
									</div>
								</div>

								
								<!-- Earnings (Monthly) Card Example -->
								<div class="col-xl-4 col-md-6 mb-4">
									<div class="card border-left-info shadow h-100 py-2">
										<div class="card-body">
											<div class="row no-gutters align-items-center">
												<div class="col mr-2">
													<div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><?= lang("admin_h80") ?></div>
													<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total > 0 ? number_format(($ts/$total)*100, 2) : 0; ?> %</div>
												</div>
												<div class="col-auto">
												<i class="fas fa-industry fa-2x text-primary"></i>
												</div>
											</div>
										</div>
									</div>
								</div>


							</div>

					</div>
				</div>


				<div class="row">

					<div class="col-lg-6 col-md-6">

						<!-- Circle Buttons -->
						<div class="card shadow mb-4">
							<div class="card-header py-3">
								<h6 class="m-0 font-weight-bold text-primary"><?= lang("admin_h81") ?></h6>
							</div>
							<div class="card-body">
								
								<div class="chart-pie pt-4 pb-2">
									<canvas id="myPieChart"></canvas>
								</div>
								<div class="mt-4 text-center small">
									<span class="mr-2">
										<i class="fas fa-circle text-primary"></i> <?= lang("admin_h82") ?> <b><?php echo $tship > 0 ? number_format($trf/$tship * 100, 2) : 0; ?> % </b>
									</span>
									<span class="mr-2">
										<i class="fas fa-circle text-success"></i> <?= lang("admin_h83") ?> <b><?php echo $tship > 0 ? number_format($ts/$tship * 100, 2) : 0; ?> % </b>
									</span>
									<span class="mr-2">
										<i class="fas fa-circle text-info"></i> <?= lang("admin_h84") ?> <b><?php echo $tship > 0 ? number_format($td/$tship * 100, 2) : 0; ?> % </b>
									</span>
									<span class="mr-2">
										<i class="fas fa-circle text-info"></i> <?= lang("admin_h85") ?> <b><?php echo $tship > 0 ? number_format($trt/$tship * 100, 2) : 0; ?> % </b>
									</span>
								</div>

							</div>
						</div>

					</div>

					<div class="col-lg-6 col-md-6">

						<!-- Circle Buttons -->
						<div class="card shadow mb-4">
							<div class="card-header py-3">
								<h6 class="m-0 font-weight-bold text-primary"><?= lang("admin_h233") ?></h6>
							</div>
							<div class="card-body">
								
								<div class="chart-pie pt-4 pb-2">
									<canvas id="myPieChart1"></canvas>
								</div>
								<div class="mt-4 text-center small">
									<span class="mr-2">
										<i class="fas fa-circle text-secondary"></i> <?= lang("admin_h6") ?> <b><?php echo $total > 0 ? number_format($tp/$total * 100, 2) : 0; ?> % </b>
									</span>
									<span class="mr-2">
										<i class="fas fa-circle text-info"></i> <?= lang("admin_h86") ?> <b><?php echo $total > 0 ? number_format($trecall/$total * 100, 2) : 0; ?> % </b>
									</span>
									<span class="mr-2">
										<i class="fas fa-circle text-success"></i> <?= lang("admin_h7") ?> <b><?php echo $total > 0 ? number_format($tc/$total * 100, 2) : 0; ?> % </b>
									</span>
									<span class="mr-2">
										<i class="fas fa-circle text-primary"></i> <?= lang("admin_h87") ?> <b><?php echo $total > 0 ? number_format($tout/$total * 100, 2) : 0; ?> % </b>
									</span>
									<span class="mr-2">
										<i class="fas fa-circle text-danger"></i> <?= lang("admin_h10") ?> <b><?php echo $total > 0 ? number_format($tc/$total * 100, 2) : 0; ?> % </b>
									</span>
								</div>

							</div>
						</div>

					</div>

				</div>

				<div class="row">

					<div class="col-lg-6 col-md-6">

						<!-- Circle Buttons -->
						<div class="card shadow mb-4">
							<div class="card-header py-3">
								<h6 class="m-0 font-weight-bold text-primary"><?= lang("admin_h88") ?></h6>
							</div>
							<div class="card-body">
								
								<div class="table-responsive">
									<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
										<thead>
											<tr>
												<th><?= lang("admin_h89") ?></th>
												<th><?= lang("admin_h90") ?></th>
											</tr>
										</thead>
										<tfoot>
											<tr>
											    <th><?= lang("admin_h89") ?></th>
												<th><?= lang("admin_h90") ?></th>
											</tr>
										</tfoot>
										<tbody>
											<?php foreach($prods as $k => $v) { ?>
											<tr>
												<td><?php echo get_info("products", $k, "title"); ?></td>
												<td><span class="badge badge-primary rounded-circle"><?php echo $v; ?></span></td>
											</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>

							</div>
						</div>

					</div>

		<!-- 			<div class="col-lg-6 col-md-6">

						<!-- Circle Buttons ->
						<div class="card shadow mb-4">
							<div class="card-header py-3">
								<h6 class="m-0 font-weight-bold text-primary">Top cities</h6>
							</div>
							<div class="card-body">
								
								<div class="table-responsive">
									<table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
										<thead>
											<tr>
												<th>City</th>
												<th>Total orders</th>
												<th>Total confirmed</th>
												<th>Total delivered</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>City</th>
												<th>Total orders</th>
												<th>Total confirmed</th>
												<th>Total delivered</th>
											</tr>
										</tfoot>
										<tbody>
											<?php foreach($cities as $k) { ?>
											<tr>
												<td><?php echo html_escape($k->name); ?></td>
												<td><?php echo $k->total; ?></td>
												<td><?php echo $k->tc; ?></td>
												<td><?php echo $k->td; ?></td>
											</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>

							</div>
						</div>

					</div> -->

				</div>




			</div>
			<!-- /.container-fluid -->


</div>


<?php include_once 'inc/footer.php'; ?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<script>


	$(".datep").datepicker({
        language: 'en',
        format : "yyyy-mm-dd"
    })

	
// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
var ctx = document.getElementById("myPieChart");

var ctx1 = document.getElementById("myPieChart1");

var myPieChart = new Chart(ctx, {
	type: 'doughnut',
	data: {
		labels: ["Refused", "Shipped", "Delivered", "Returned"],
		datasets: [{
			data: [<?=$trf;?>, <?=$ts;?>, <?=$td;?>, <?=$trt;?>],
			backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#e74a3b'],
			hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#e74a3b'],
			hoverBorderColor: "rgba(234, 236, 244, 1)",
		}],
	},
	options: {
		maintainAspectRatio: false,
		tooltips: {
			backgroundColor: "rgb(255,255,255)",
			bodyFontColor: "#858796",
			borderColor: '#dddfeb',
			borderWidth: 1,
			xPadding: 15,
			yPadding: 15,
			displayColors: false,
			caretPadding: 10,
		},
		legend: {
			display: false
		},
		cutoutPercentage: 80,
	},
});


var myPieChart = new Chart(ctx1, {
	type: 'doughnut',
	data: {
		labels: ["Pending", "Re-Call", "Confirmed", "Out of service", "Canceled"],
		datasets: [{
			data: [<?=$tpending;?>, <?=$trecall;?>, <?=$tc;?>, <?=$tout;?>, <?=$tcanceled;?>],
			backgroundColor: ['#858796', '#36b9cc', '#1cc88a', '#4e73df', '#e74a3b'],
			hoverBackgroundColor: ['#858796', '#36b9cc', '#1cc88a', '#4e73df', '#e74a3b'],
			hoverBorderColor: "rgba(234, 236, 244, 1)",
		}],
	},
	options: {
		maintainAspectRatio: false,
		tooltips: {
			backgroundColor: "rgb(255,255,255)",
			bodyFontColor: "#858796",
			borderColor: '#dddfeb',
			borderWidth: 1,
			xPadding: 15,
			yPadding: 15,
			displayColors: false,
			caretPadding: 10,
		},
		legend: {
			display: false
		},
		cutoutPercentage: 80,
	},
});

$(document).ready(function() {
		$('#dataTable').DataTable({
			"order": [[ 1, "desc" ]],
			"columns": [
				null,
				null
			],
		});

		$('#dataTable1').DataTable({
			"order": [[ 1, "desc" ]],
			"columns": [
				null,
				null,
				null,
				null
			],
		});

		$('#dataTable2').DataTable({
			"order": [[ 1, "desc" ]],
			"columns": [
				null,
				null,
				null,
				null,
				null,
				null
			],
		});

		$('#dataTable3').DataTable({
			"order": [[ 1, "desc" ]],
			"columns": [
				null,
				null,
				null,
				null
			],
		});
	});




// Area Chart Example
var ctxl1 = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctxl1, {
  type: 'line',
  data: {
    labels: [<?php $i = 1; foreach($data as $ce) { echo $i == 1 ? "'".$ce['title']."'" : ", '".$ce['title']."'"; $i++; } ?>],
datasets: [
    {
        label: "<?= lang("admin_h70") ?>" /*total*/,
        lineTension: 0.3,
        backgroundColor: "rgba(78, 115, 223, 0.2)",
        borderColor: "rgba(78, 115, 223, 1)",
        pointRadius: 3,
        pointBackgroundColor: "rgba(78, 115, 223, 1)",
        pointBorderColor: "rgba(78, 115, 223, 1)",
        pointHoverRadius: 3,
        pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
        pointHoverBorderColor: "rgba(78, 115, 223, 1)",
        pointHitRadius: 10,
        pointBorderWidth: 2,
        data: [<?php $i = 1; foreach($data as $ce) { echo $i == 1 ? $ce["values"]->total : ", ".$ce["values"]->total; $i++; } ?>],
    },
    {
        label: "<?= lang("admin_h9") ?>" /*delivered*/,
        lineTension: 0.3,
        backgroundColor: "rgba(28, 200, 138, 0.2)",
        borderColor: "rgba(28, 200, 138, 1)",
        pointRadius: 3,
        pointBackgroundColor: "rgba(28, 200, 138, 1)",
        pointBorderColor: "rgba(28, 200, 138, 1)",
        pointHoverRadius: 3,
        pointHoverBackgroundColor: "rgba(28, 200, 138, 1)",
        pointHoverBorderColor: "rgba(28, 200, 138, 1)",
        pointHitRadius: 10,
        pointBorderWidth: 2,
        data: [<?php $i = 1; foreach($data as $ce) { echo $i == 1 ? $ce["values"]->ts : ", ".$ce["values"]->ts; $i++; } ?>],
    },
    {
        label: "<?= lang("admin_h7") ?>" /*comfirmed*/,
        lineTension: 0.3,
        backgroundColor: "rgba(133, 135, 150, 0.2)",
        borderColor: "rgba(133, 135, 150, 1)",
        pointRadius: 3,
        pointBackgroundColor: "rgba(133, 135, 150, 1)",
        pointBorderColor: "rgba(133, 135, 150, 1)",
        pointHoverRadius: 3,
        pointHoverBackgroundColor: "rgba(133, 135, 150, 1)",
        pointHoverBorderColor: "rgba(133, 135, 150, 1)",
        pointHitRadius: 10,
        pointBorderWidth: 2,
        data: [<?php $i = 1; foreach($data as $ce) { echo $i == 1 ? $ce["values"]->tc : ", ".$ce["values"]->tc; $i++; } ?>],
    },
    // {
    //     label: "<?= lang("admin_h85") ?>" /*returned*/,
    //     lineTension: 0.3,
    //     backgroundColor: "rgba(231, 74, 59, 0.2)",
    //     borderColor: "rgba(231, 74, 59, 1)",
    //     pointRadius: 3,
    //     pointBackgroundColor: "rgba(231, 74, 59, 1)",
    //     pointBorderColor: "rgba(231, 74, 59, 1)",
    //     pointHoverRadius: 3,
    //     pointHoverBackgroundColor: "rgba(231, 74, 59, 1)",
    //     pointHoverBorderColor: "rgba(231, 74, 59, 1)",
    //     pointHitRadius: 10,
    //     pointBorderWidth: 2,
    //     data: [<?php $i = 1; foreach($data as $ce) { echo $i == 1 ? $ce["values"]->tp : ", ".$ce["values"]->tp; $i++; } ?>],
    // },
    {
        label: "<?= lang("admin_h10") ?>" /*shipped*/,
        lineTension: 0.3,
        backgroundColor: "rgba(255, 193, 7, 0.2)",
        borderColor: "rgba(255, 193, 7, 1)",
        pointRadius: 3,
        pointBackgroundColor: "rgba(255, 193, 7, 1)",
        pointBorderColor: "rgba(255, 193, 7, 1)",
        pointHoverRadius: 3,
        pointHoverBackgroundColor: "rgba(255, 193, 7, 1)",
        pointHoverBorderColor: "rgba(255, 193, 7, 1)",
        pointHitRadius: 10,
        pointBorderWidth: 2,
        data: [<?php $i = 1; foreach($data as $ce) { echo $i == 1 ? $ce["values"]->tcan : ", ".$ce["values"]->tcan; $i++; } ?>],
    },
    {
        label: "<?= lang("admin_h8") ?>" /*shipped*/,
        lineTension: 0.3,
        backgroundColor: "rgba(0, 123, 255, 0.2)",
        borderColor: "rgba(0, 123, 255, 1)",
        pointRadius: 3,
        pointBackgroundColor: "rgba(0, 123, 255, 1)",
        pointBorderColor: "rgba(0, 123, 255, 1)",
        pointHoverRadius: 3,
        pointHoverBackgroundColor: "rgba(0, 123, 255, 1)",
        pointHoverBorderColor: "rgba(0, 123, 255, 1)",
        pointHitRadius: 10,
        pointBorderWidth: 2,
        data: [<?php $i = 1; foreach($data as $ce) { echo $i == 1 ? $ce["values"]->tship : ", ".$ce["values"]->tship; $i++; } ?>],
    },
    {
        label: "<?= lang("admin_h6") ?>" /*pending*/,
        lineTension: 0.3,
        backgroundColor: "rgba(255, 0, 0, 0.2)",
        borderColor: "rgba(255, 0, 0, 1)",
        pointRadius: 3,
        pointBackgroundColor: "rgba(255, 0, 0, 1)",
        pointBorderColor: "rgba(255, 0, 0, 1)",
        pointHoverRadius: 3,
        pointHoverBackgroundColor: "rgba(255, 0, 0, 1)",
        pointHoverBorderColor: "rgba(255, 0, 0, 1)",
        pointHitRadius: 10,
        pointBorderWidth: 2,
        data: [<?php $i = 1; foreach($data as $ce) { echo $i == 1 ? $ce["values"]->tp : ", ".$ce["values"]->tp; $i++; } ?>],
    },
],
  },
  options: {
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 10,
        right: 25,
        top: 25,
        bottom: 0
      }
    },
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false,
          drawBorder: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          maxTicksLimit: 5,
          padding: 10
        },
        gridLines: {
          color: "rgb(234, 236, 244)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2]
        }
      }],
    },
    legend: {
      display: false
    },
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      titleMarginBottom: 10,
      titleFontColor: '#6e707e',
      titleFontSize: 14,
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      intersect: false,
      mode: 'index',
      caretPadding: 10
    }
  }
});


</script>