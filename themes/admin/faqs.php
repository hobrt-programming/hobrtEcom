<?php $title='الخصومات'; require_once 'views/head.php'; ?>


<?php

if($tp == "add") {

?>

	<h2 class="text-flat">رئيسية التحكم <span class="text-sm"><?php echo $title; ?></span></h2>

	<ul class="breadcrumb pb30">
		<li><a href="<?php echo base_url("admin"); ?>"><i class="fa fa-home"></i> الرئيسية</a></li>
		<li><a href="<?php echo base_url("admin/discounts"); ?>">الخصومات</a></li>
		<li class="active">إضافة سوأل</li>
	</ul>

	<?php if(isset($msg)){ ?>
	<div class="alert alert-success">تم إضافة الخصم بنجاح .</div>
	<?php } ?>
	<div class="well bs-component" data-sr="wait 0s, then enter left and hustle 100%">
		<?php echo form_open_multipart("",array("class" => "form-horizontal")); ?>

		  <fieldset>

		    <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
		      <label for="inputUser" class="col-lg-2 control-label">كود التخفيض</label>
		      <div class="col-lg-10 input-grup">
		      	<i class="fa fa-file"></i>
		        <input type="text" class="form-control text-right" placeholder="كود التخفيض" name="coupon">
		        <span class="help-block">كود التخفيض .</span>
		      </div>
		    </div>

		    <!-- <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
		      <label for="inputUser" class="col-lg-2 control-label">العدد (يمكنك تركه 0 إدا كان غير محدود)</label>
		      <div class="col-lg-10 input-grup">
		        <input type="number" value="0" class="form-control text-right" placeholder="العدد" name="num">
		        <span class="help-block">العدد .</span>
		      </div>
		    </div> -->

		    <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
		      <label for="inputUser" class="col-lg-2 control-label">تاريخ إنتهاء الخصم</label>
		      <div class="col-lg-10 input-grup">
		        <input type="text" id="datep" class="form-control text-right" placeholder="تاريخ إنتهاء الخصم" name="date">
		        <span class="help-block">تاريخ إنتهاء الخصم .</span>
		      </div>
		    </div>

		    <div class="form-group" data-sr="wait 0.3s, then enter bottom and hustle 100%">
		      <div class="col-xs-10 col-xs-pull-2">
		        <button type="reset" class="btn btn-default">أبدء من جديد ؟</button>
		        <button type="submit" class="btn btn-primary" name="test">حفظ</button>
		      </div>
		    </div>

		  </fieldset>

		</form>

	</div>


<?php

}elseif($tp == "edit") {

?>



	<h2 class="text-flat">رئيسية التحكم <span class="text-sm"><?php echo $title; ?></span></h2>

	<ul class="breadcrumb pb30">
		<li><a href="<?php echo base_url("admin"); ?>"><i class="fa fa-home"></i> الرئيسية</a></li>
		<li><a href="<?php echo base_url("admin/discounts"); ?>">الخصومات</a></li>
		<li class="active">تعديل</li>
	</ul>

	<?php foreach($cat as $key){ ?>
	<div class="well bs-component" data-sr="wait 0s, then enter left and hustle 100%">
		<?php echo form_open_multipart("",array("class" => "form-horizontal")); ?>

		  <fieldset>

		    <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
		      <label for="inputUser" class="col-lg-2 control-label">كود التخفيض</label>
		      <div class="col-lg-10 input-grup">
		      	<i class="fa fa-file"></i>
		        <input type="text" class="form-control text-right" placeholder="كود التخفيض" name="coupon"  value="<?php echo $key->coupon; ?>">
		        <span class="help-block">كود التخفيض .</span>
		      </div>
		    </div>

		    <!-- <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
		      <label for="inputUser" class="col-lg-2 control-label">العدد (يمكنك تركه 0 إدا كان غير محدود)</label>
		      <div class="col-lg-10 input-grup">
		        <input type="number" class="form-control text-right" placeholder="العدد" name="num"  value="<?php echo $key->num; ?>">
		        <span class="help-block">العدد .</span>
		      </div>
		    </div> -->

		    <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
		      <label for="inputUser" class="col-lg-2 control-label">تاريخ إنتهاء الخصم</label>
		      <div class="col-lg-10 input-grup">
		        <input type="text" id="datep" class="form-control text-right" placeholder="تاريخ إنتهاء الخصم" name="date"  value="<?php echo $key->date; ?>">
		        <span class="help-block">تاريخ إنتهاء الخصم .</span>
		      </div>
		    </div>

		    <div class="form-group" data-sr="wait 0.3s, then enter bottom and hustle 100%">
		      <div class="col-xs-10 col-xs-pull-2">
		        <button type="reset" class="btn btn-default">أبدء من جديد ؟</button>
		        <button type="submit" class="btn btn-primary" name="test">حفظ</button>
		      </div>
		    </div>

		  </fieldset>

		</form>

	</div>
	<?php } ?>



<?php

}else {

?>


<ul class="breadcrumb pb30">
  <li><a href="<?php echo base_url("admin"); ?>">الرئيسية</a></li>
  <li class="active">الخصومات .</li>
  <li class="pull-left"><a href="<?php echo base_url("admin/add_discount"); ?>" class="btn btn-success btn-xs"><i class="fa fa-plus-square"></i> أضف خصم جديد</a></li>
</ul>



	<table id="no-more-tables" class="table table-bordered" role="table">
		<thead>
			<tr>
				<th width="2%">#</th>
				<th width="15%" class="text-right">كود التخفيض</th>
				<th width="15%" class="text-right">تاريخ إنتهاء الخصم</th>
				<th width="60%" class="text-right">التحكم</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($cat as $key) {  ?>
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

	<div class="center"><?php echo $links; ?></div>

<?php
}



require_once 'views/sidebar.php'; require_once 'views/foot.php';