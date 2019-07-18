<?php require_once 'views/head.php'; ?>

<ul class="breadcrumb pb30">
  <li><a href="#">الرئيسية</a></li>
  <li class="active">المدراء .</li>
  <li class="pull-left"><a href="<?php echo base_url("admin/add_admin"); ?>" class="btn btn-success btn-xs"><i class="fa fa-plus-square"></i> أضف مدير</a></li>
</ul>



	<table id="no-more-tables" class="table table-bordered" role="table">
		<thead>
			<tr>
				<th width="2%">#</th>
				<th width="20%" class="text-right">إسم المدير</th>
				<th width="30%" class="text-right">الإيميل</th>
				<th width="30%" class="text-right">التحكم</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($admins as $key) {  ?>
			<tr>
				<td data-title="#"><span class="badge"><?php echo $key->id; ?></span></td>
				<td data-title="العنوان"><?php echo $key->username; ?></td>
				<td data-title="الإيميل"><?php echo $key->email; ?></td>
				<td data-title="التحكم" class="text-center">
					<a href="<?php echo base_url("admin/edit_admin/$key->id"); ?>" class="btn btn-default btn-xs"><i class="fa fa-pencil-square"></i> تعديل</a>
					<a href="<?php echo base_url("admin/delt/admins/$key->id/admins"); ?>" class="btn btn-danger btn-xs"><i class="fa fa-minus-square"></i> حذف</a>
			</div>
				</td>
			</tr>
		<?php } ?>

		</tbody>		
	</table>

	<div class="center"><?php echo $links; ?></div>


<?php require_once 'views/sidebar.php'; require_once 'views/foot.php';