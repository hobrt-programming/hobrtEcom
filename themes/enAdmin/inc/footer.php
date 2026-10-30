      <!-- Footer -->
    <footer class="sticky-footer bg-white">
      	<div class="container my-auto">
      		<div class="copyright text-center my-auto">
      			<span>Copyright &copy; <a href="https://hobrt.me" target="_blank">Hobrt</a> 2019 - <?php echo date("Y"); ?></span>
      		</div>
      	</div>
      </footer>
      <!-- End of Footer -->

  </div>
  <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
	<i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"><?= lang("admin_h311") ?></h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body"><?= lang("admin_h312") ?></div>
			<div class="modal-footer">
				<button class="btn btn-secondary" type="button" data-dismiss="modal"><?= lang("admin_h313") ?></button>
				<?php echo form_open("user/logout", array("class" => "m-0")); ?>
					<button class="btn btn-primary" type="submit"><i class="fas fa-sign-out-alt"></i> <?= lang("admin_h111") ?></button>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>
<script>
	// highlight the sidebar entry of the current page (and open its group)
	(function () {
		// pages without their own menu entry count as their list page
		var aliases = { details: "orders", edit_product: "products", edit_cat: "cat", edit_page: "pages", edit_collection: "collections", edit_admin: "admins" };
		var here = location.pathname.replace(/\/+$/, "").replace(/\/admin\/(\w+)(\/.*)?$/, function (m, page) {
			return aliases[page] ? "/admin/" + aliases[page] : m;
		});
		var best = null, bestLen = 0;
		document.querySelectorAll("#accordionSidebar a.nav-link[href], #accordionSidebar a.collapse-item[href]").forEach(function (a) {
			var path = new URL(a.href, location.href).pathname.replace(/\/+$/, "");
			var prefix = !/\/admin$/.test(path) && here.indexOf(path + "/") === 0; // "admin" (home) only matches itself
			if ((here === path || prefix) && path.length > bestLen) {
				best = a;
				bestLen = path.length;
			}
		});
		if (!best) return;
		best.classList.add("active");
		var item = best.closest(".nav-item");
		if (item) item.classList.add("active");
		var group = best.closest(".collapse");
		if (group) group.classList.add("show");
	})();
</script>

<!-- Page level plugins -->
<script src="vendor/chart.js/Chart.min.js"></script>
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="vendor/dropzone/dropzone.js"></script>

<!-- <script src="https://cdn.ckeditor.com/ckeditor5/17.0.0/classic/ckeditor.js"></script> -->

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
	toastr.options.preventDuplicates = false;
	toastr.options.closeMethod = 'fadeOut';
	toastr.options.timeOut = 1000;
	toastr.options.closeEasing = 'swing';
	toastr.options.rtl = <?= (lang('admin_h55') == "rtl") ? "true":"false" ?>;

</script>
<!--<script src="js/demo/chart-pie-demo.js"></script>-->
<script>



	$.extend( true, $.fn.dataTable.defaults, {
	    language: {
            url: '//cdn.datatables.net/plug-ins/1.10.22/i18n/<?php echo lang("admin_h67"); ?>.json'
        }
	});
	
	$(".btn-danger").click(function() {
		var yes = confirm("are you sure ? this action can't be undo ");


		var ele = $(this);

		var url = ele.attr("href");

		if(yes) {

			$.get(url, {}, function(data) {
				
				if(data == 1) {
					ele.parent().parent().remove();
				}
				
			})


		}


		return false;
	})

	var obj = [
		{
			title: "Products",
			url: "products"
		},
		{
			title: "Add product",
			url: "add_product"
		},
		{
			title: "Orders",
			url: "requests"
		},
		{
			title: "Pending orders",
			url: "requests1"
		},
		{
			title: "Awaiting shipping",
			url: "requests2"
		},
		{
			title: "Shipped orders",
			url: "requests3"
		},
		{
			title: "Delevired orders",
			url: "requests/0"
		},
		{
			title: "Canceled orders",
			url: "requests/1"
		},
		{
			title: "Categories",
			url: "cat"
		},
		{
			title: "Add category",
			url: "add_cat"
		},
		{
			title: "Cities stats",
			url: "citiesStats"
		},
		{
			title: "Profit page",
			url: "profitPage"
		},
		{
			title: "Stock management",
			url: "stock"
		},
		{
			title: "Analytics",
			url: "stats"
		},
		{
			title: "Sources",
			url: "sources"
		},
		{
			title: "Pages",
			url: "pages"
		},
		{
			title: "Add page",
			url: "add_page"
		},
		{
			title: "Admins",
			url: "admins"
		},
		{
			title: "Add admin",
			url: "add_admin"
		},
		{
			title: "Settings",
			url: "setting"
		}
	];

	function findInObj(value) {
		var s = $(".searchTop").val();
		return value.title.toLowerCase().startsWith(s.toLowerCase());
	}

	function findInObjMobile(value) {
		var s = $(".searchTopMobile").val();
		return value.title.toLowerCase().startsWith(s.toLowerCase());
	}

	$(document).on("keyup", ".searchTopMobile", function() {

		$(".dropStyle").slideDown("slow");

		$(".dropStyle").html("");

		var filtred = obj.filter(findInObjMobile).slice(0, 5);

		console.log(filtred);

		filtred.forEach(function(v, i) {

			var ht = '<a href="'+ base_url + "admin/" + v.url +'" class="list-group-item list-group-item-action">' + v.title + '</a>';

			$(".dropStyle").append(ht);

		})

	})

	$(".searchTop").keyup(function() {

		$(".dropStyle").slideDown("slow");

		$(".dropStyle").html("");

		var filtred = obj.filter(findInObj).slice(0, 5);

		console.log(filtred);

		filtred.forEach(function(v, i) {

			var ht = '<a href="'+ base_url + "admin/" + v.url +'" class="list-group-item list-group-item-action">' + v.title + '</a>';

			$(".dropStyle").append(ht);

		})

	});

</script>


</body>

</html>