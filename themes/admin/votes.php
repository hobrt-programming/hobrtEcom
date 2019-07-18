<?php require_once 'views/head.php'; ?>

<ul class="breadcrumb pb30">
  <li><a href="#">الرئيسية</a></li>
  <li class="active">التعليقات .</li>
</ul>



	<table id="no-more-tables" class="table table-bordered" role="table">
		<thead>
			<tr>
				<th width="2%">#</th>
				<th width="30%" class="text-right">التعليقات</th>
				<th width="30%" class="text-right">الملف</th>
				<th width="30%" class="text-right">التحكم</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($cat as $key) {  ?>
			<tr>
				<td data-title="#"><span class="badge"><?php echo $key->id; ?></span></td>
				<td data-title="العنوان"><?php echo $key->comment; ?></td>
				<td data-title="العنوان"><?php echo get_info("materials", $key->mat, 'title'); ?></td>
				<td data-title="التحكم" class="text-center">
					<a href="<?php echo base_url("admin/delt/vote/$key->id/votes"); ?>" class="btn btn-danger btn-xs"><i class="fa fa-minus-square"></i> حدف</a>
				</td>
			</tr>
		<?php } ?>

		</tbody>		
	</table>

	<div class="center"><?php echo $links; ?></div>

<?php require_once 'views/sidebar.php'; require_once 'views/foot.php';