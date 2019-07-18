<?php require_once 'views/head.php'; ?>

<ul class="breadcrumb pb30">
  <li><a href="<?php echo base_url("admin"); ?>">الرئيسية</a></li>
  <li class="active">طلب</li>
</ul>


<?php foreach($msg as $key){ ?>
	<caption class="text-right text-success"><i class="fa fa-table fa-fw"></i>الإسم الكامل .</p></caption>
	<h3><?php echo $key->name; ?></h3>
	<caption class="text-right text-success"><i class="fa fa-table fa-fw"></i>رقم الهاتف .</p></caption>
	<h3><?php echo $key->tele; ?></h3>
	<caption class="text-right text-success"><i class="fa fa-table fa-fw"></i>العنوان .</p></caption>
	<h3><?php echo $key->address; ?></h3>
	<caption class="text-right text-success"><i class="fa fa-table fa-fw"></i>المدينة .</p></caption>
	<h3><?php echo $key->city; ?></h3>
	<caption class="text-right text-success"><i class="fa fa-table fa-fw"></i>الكوبون .</p></caption>
	<h3><?php echo $key->coupon; ?></h3>
	<caption class="text-right text-success"><i class="fa fa-table fa-fw"></i>السعر الإجمالي .</p></caption>
	<h3><?php echo $key->totalPrice; ?></h3>
	<caption class="text-right text-success"><i class="fa fa-table fa-fw"></i>حالة الطلب .</p></caption>
	<h3><?php switch ($key->status) {
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
				} ?></h3>
	<h2>المنتوجات </h2>

	<table class="table" style="text-align: right;">
		
		<tr>
			<th class="text-right">عنوان المنتوج</th>
			<th class="text-right">العدد</th>
		</tr>
		<?php

		$pcs = json_decode($key->products, TRUE); foreach($pcs as $p => $q) {

		?>

		<tr>
			
			<td><?php echo get_info("products", $p, "title"); ?></td>

			<td><b><?php echo $q; ?></b></td>

		</tr>

		<?php } ?>

	</table>

<br>
	<hr>
	<br>

<h2>تعديل </h2>


<?php echo form_open(); ?>

<div class="form-group">
	<label>حالة الطلب : </label>
	<select class="form-control" name="status">
		
		<option value="1" <?php if($key->status == 1) echo "selected"; ?>>بإنتظار التأكيد</option>
		<option value="2" <?php if($key->status == 2) echo "selected"; ?>>بإنتظار الشحن</option>
		<option value="3" <?php if($key->status == 3) echo "selected"; ?>>تم الإرسال</option>
		<option value="5" <?php if($key->status == 5) echo "selected"; ?>>تم الإستلام</option>
		<option value="0" <?php if($key->status == 0) echo "selected"; ?>>تم إلغاء الطلب</option>

	</select>

</div>

<div class="form-group">
	
	<label>العنوان : </label>
	<textarea class="form-control" name="address"><?php echo $key->address; ?></textarea>

</div>

<button type="submit" class="btn btn-success" name="test">تعديل</button>

<?php echo form_close(); ?>


<?php } ?>
<?php require_once 'views/sidebar.php'; require_once 'views/foot.php';