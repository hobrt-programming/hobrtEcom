<?php require_once 'views/head.php'; ?>

<!--############################## Title of the page & Time now also ##############################-->
<h2 class="text-flat">رئيسية التحكم <span class="text-sm">الصفحة الرئيسية</span> <span class="date badge pull-left" data-toggle="tooltip" data-placement="bottom" title="UTC +2:00"><?php echo date_arabic(time()); ?></span></h2>

<!--##############################  breadcrumb ##############################-->
<ul class="breadcrumb pb30">
  <li><a href="#">الرئيسية</a></li>
  <li class="active">الصفحة الرئيسية</li>
</ul>

<!-- Margin bottom making some space for out show's :D -->
<div class="mb50"></div>



	<!-- Index Info's -->
	<div class="col-md-3 col-sm-3 col-xs-12" data-sr="wait 0s, then enter bottom" data-toggle="tooltip" data-placement="top" title="أضغط للمزيد">
		<a href="<?php echo base_url("admin/products"); ?>" class="btn-primary btn-block index-info">
			<span class="fa fa-user icn-bk"></span>
			<span class="info-tit">عدد المنتوجات</span>
			<span class="info-cont"><i class="fa fa-user"></i><span class="badge"><?php echo $mo1; ?></span></span>
			<div class="clr"></div>
		</a>
	</div>

	<!-- Index Info's -->
	<div class="col-md-3 col-sm-3 col-xs-12" data-sr="wait 0.3s, then enter right and hustle 100%" data-toggle="tooltip" data-placement="top" title="أضغط للمزيد">
		<a href="<?php echo base_url("admin/requests"); ?>" class="btn-success btn-block index-info">
			<span class="fa fa-puzzle-piece icn-bk"></span>
			<span class="info-tit">عدد الطلبات بإنتظار التأكيد</span>
			<span class="info-cont"><i class="fa fa-puzzle-piece"></i> <?php echo $mo2; ?></span>
			<div class="clr"></div>
		</a>
	</div>

	<!-- Index Info's -->
	<div class="col-md-3 col-sm-3 col-xs-12" data-sr="wait 0.6s, then enter right and hustle 100%" data-toggle="tooltip" data-placement="top" title="أضغط للمزيد">
		<a href="<?php echo base_url("admin/requests"); ?>" class="btn-info btn-block index-info">
			<span class="fa fa-files-o icn-bk"></span>
			<span class="info-tit">عدد الطلبات التي تم تسليمها</span>
			<span class="info-cont"><i class="fa fa-files-o"></i><span class="badge"><?php echo $mo3; ?></span></span>
			<div class="clr"></div>
		</a>
	</div>

	<!-- Index Info's -->
	<div class="col-md-3 col-sm-3 col-xs-12" data-sr="wait 0.9s, then enter right and hustle 100%" data-toggle="tooltip" data-placement="top" title="أضغط للمزيد">
		<a href="<?php echo base_url("admin/products"); ?>" class="btn-danger btn-block index-info">
			<span class="fa fa-users icn-bk"></span>
			<span class="info-tit">عدد التقييمات </span>
			<span class="info-cont"><i class="fa fa-users"></i><?php echo $mo4; ?></span>
			<div class="clr"></div>
		</a>
	</div>

<!--############################## Marging Bottom 50px ##############################-->
<div class="clearfix mb50"></div>


<h3 style="font-size: 20px;background: #222f41;color: #fff;padding: 10px 20px;">اخر الطلبات</h3>

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
		<?php foreach($cat as $key) {  ?>
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


<div class="clearfix mb50"></div>

<div class="clearfix mb50"></div>
	<div class="col-md-6 col-sm-6 col-xs-12" data-sr="wait 0s">
		<div class="list-group shadow">
			<div class="list-group-item active">
				اخر المنتوجات المضافة
			</div>
			
	<table id="no-more-tables" class="table table-bordered" role="table">
		<thead>
			<th width="2%">#</th>
				<th width="25%" class="text-right">عنوان النتوج</th>
				<th width="15%" class="text-right">السعر الأصلي</th>
				<th width="15%" class="text-right">السعر بعد التخفيض</th>
				<th width="15%" class="text-right">عدد المبيعات</th>
				<th width="60%" class="text-right">التحكم</th>
		</thead>
		<tbody>
		<?php foreach($lastadd as $key) {  ?>
			<tr>
				<td data-title="#"><span class="badge"><?php echo $key->id; ?></span></td>
				<td data-title="إسم القسم"> <?php echo $key->title; ?></td>
				<td data-title="إسم القسم"> <?php echo $key->price; ?></td>
				<td data-title="إسم القسم"> <?php echo floor($key->price - ($key->price * $key->discount / 100)); ?></td>
				<td data-title="إسم القسم"> <?php echo $this->m_p->get_num("orders"); ?></td>
				<td data-title="التحكم" class="text-center">
					<a href="<?php echo base_url("admin/edit_product/$key->id"); ?>" class="btn btn-default btn-xs"><i class="fa fa-pencil-square"></i> تعديل</a>
           			<a href="<?php echo base_url("admin/delt/products/$key->id/products"); ?>" class="btn btn-danger btn-xs"><i class="fa fa-minus-square"></i> حذف</a>
				</td>
			</tr>
		<?php } ?>

		</tbody>		
	</table>

		</div><!-- list-group -->
	</div>

	<div class="col-md-6 col-sm-6 col-xs-12 mb20" data-sr="wait 0.3s">
		<div class="list-group shadow">
			<div class="list-group-item active">
				الكوبونات المفعلة
			</div>
	<table id="no-more-tables" class="table table-bordered" role="table">
		<thead>
			<tr>
				<th width="2%">#</th>
				<th width="15%" class="text-right">كود التخفيض</th>
				<th width="30%" class="text-right">تاريخ إنتهاء الخصم</th>
				<th width="60%" class="text-right">التحكم</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($endsoon as $key) {  ?>
			<tr>
				<td data-title="#"><span class="badge"><?php echo $key->id; ?></span></td>
				<td data-title="إسم القسم"> <?php echo $key->coupon; ?></td>
				<td data-title="إسم القسم"> <?php echo $key->date; ?></td>
				<td data-title="التحكم" class="text-center">
					<a href="<?php echo base_url("admin/edit_discount/$key->id"); ?>" class="btn btn-default btn-xs"><i class="fa fa-pencil-square"></i> تعديل</a>
           			<a href="<?php echo base_url("admin/delt/discounts/$key->id/discounts"); ?>" class="btn btn-danger btn-xs"><i class="fa fa-minus-square"></i> حذف</a>
				</td>
			</tr>
		<?php } ?>

		</tbody>		
	</table>
		</div><!-- list-group -->
	</div>
<div class="clearfix mb50"></div>

<?php require_once 'views/sidebar.php'; require_once 'views/foot.php';