<?php require_once 'views/head.php'; ?>

<ul class="breadcrumb pb30">
  <li><a href="#">الرئيسية</a></li>
  <li class="active">الرسائل .</li>
</ul>



	<table id="no-more-tables" class="table table-bordered" role="table">
		<thead>
			<tr>
				<th width="2%">#</th>
				<th width="30%" class="text-right">الإسم</th>
				<th width="30%" class="text-right">الإيميل</th>
				<th width="30%" class="text-right">التحكم</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($msg as $key) {  ?>
			<tr>
				<td data-title="#"><span class="badge"><?php echo $key->id; ?></span></td>
				<td data-title="العنوان"><?php echo $key->name; ?></td>
				<td data-title="الرتبة"><?php echo $key->email; ?></td>
				<td data-title="التحكم" class="text-center">
					<a href="<?php echo base_url("admin/show_msg/$key->id"); ?>" class="btn btn-default btn-xs"><i class="fa fa-pencil-square"></i> قراءة الرسالة</a>
					<a href="<?php echo base_url("admin/delt/msg/$key->id/messages"); ?>" class="btn btn-danger btn-xs"><i class="fa fa-minus-square"></i> حذف</a>
			</div>
				</td>
			</tr>
		<?php } ?>

		</tbody>		
	</table>

	<div class="center"><?php echo $links; ?></div>

<?php require_once 'views/sidebar.php'; require_once 'views/foot.php';