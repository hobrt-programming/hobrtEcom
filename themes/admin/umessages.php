<?php require_once 'views/head.php'; ?>

<ul class="breadcrumb pb30">
  <li><a href="#">الرئيسية</a></li>
  <li class="active">الرسائل .</li>
</ul>



	<table id="no-more-tables" class="table table-bordered" role="table">
		<thead>
			<tr>
				<th width="2%">#</th>
				<th width="30%" class="text-right">العضو</th>
				<th width="30%" class="text-right">التحكم</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($cat as $key) {  ?>
			<tr <?php if($key->see == 0) echo "style='background: #ccc;'"; ?>>
				<td data-title="#"><span class="badge"><?php echo $key->id; ?></span></td>
				<td data-title="العنوان"><?php echo get_info("users", $key->user, 'username'); ?></td>
				<td data-title="التحكم" class="text-center">
					<a href="<?php echo base_url("admin/messages_user/$key->user"); ?>" class="btn btn-default btn-xs"><i class="fa fa-pencil-square"></i> قراءة الرسالة</a>
			</div>
				</td>
			</tr>
		<?php } ?>

		</tbody>		
	</table>

	<div class="center"><?php echo $links; ?></div>

<?php require_once 'views/sidebar.php'; require_once 'views/foot.php';