<?php require_once 'views/head.php'; ?>

<ul class="breadcrumb pb30">
  <li><a href="<?php echo base_url("admin"); ?>">الرئيسية</a></li>
  <li class="active">طلبات .</li>
</ul>



	<table id="no-more-tables" class="table table-bordered" role="table">
		<thead>
			<tr>
				<th width="2%">#</th>
				<th width="15%" class="text-right">المنتوج</th>
				<th width="15%" class="text-right">إسم المشتري</th>
				<th width="10%" class="text-right">رقم الهاتف</th>
				<th width="10%" class="text-right">المدينة</th>
				<th width="10%" class="text-right">تاريخ الطلب</th>
				<th width="10%" class="text-right">سعر الطلب</th>
				<th width="15%" class="text-right">الحالة</th>
				<th width="30%" class="text-right">التحكم</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($msg as $key) {  ?>
			<tr>
				<td data-title="#"><span class="badge"><?php echo $key->id; ?></span></td>
				<td data-title="العنوان"><?php $pcs = json_decode($key->products, TRUE); foreach($pcs as $p => $q) { echo get_info("products", $p, "title")." / العدد <b>".$q."</b><br />"; }; ?></td>
				<td data-title="العنوان"><?php echo $key->name; ?></td>
				<td data-title="العنوان"><?php echo $key->tele; ?></td>
				<td data-title="العنوان"><?php echo $key->city; ?></td>
				<td data-title="العنوان"><?php echo date("Y-m-d H:i", $key->date); ?></td>
				<td data-title="العنوان"><?php echo $key->totalPrice; ?> DH</td>
				<td data-title="العنوان"><?php switch ($key->status) {
					case 1:
						echo "بإنتظار التأكيد";
						break;
					
					case 2:
						echo "بإنتظار الشحن";
						break;
					
					case 3:
						echo "تم الإرسال";
						break;

					case 0:
						echo "تم إلغاء الطلب";
						break;

					default:
						echo "تم الإستلام";
						break;
				} ?></td>
				<td data-title="التحكم" class="text-center">
					<a href="<?php echo base_url("admin/detiales/$key->id"); ?>" class="btn btn-default btn-xs"><i class="fa fa-pencil-square"></i> التفاصيل</a>
					<a href="<?php echo base_url("admin/delt/orders/$key->id/requests"); ?>" class="btn btn-danger btn-xs"><i class="fa fa-minus-square"></i> حذف</a>
				</td>
			</tr>
		<?php } ?>

		</tbody>		
	</table>

	<div class="center"><?php echo $links; ?></div>

<?php require_once 'views/sidebar.php'; require_once 'views/foot.php';