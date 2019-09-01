<?php $title='الخصومات'; require_once 'views/head.php'; ?>


<?php

if($tp == "add") {

?>

	<ul class="breadcrumb pb30">
		<li><a href="<?php echo base_url("admin"); ?>"><i class="fa fa-home"></i> الرئيسية</a></li>
		<li><a href="<?php echo base_url("admin/discounts"); ?>">المنتوجات</a></li>
		<li class="active">إضافة سوأل</li>
	</ul>

	<?php if(isset($msg)){ ?>
	<div class="alert alert-success">تم إضافة المنتوج بنجاح .</div>
	<?php } ?>
	<div class="well bs-component" data-sr="wait 0s, then enter left and hustle 100%">
		<?php echo form_open_multipart("",array("class" => "form-horizontal")); ?>

		  <fieldset>

		    <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
		      <label for="inputUser" class="col-lg-2 control-label">عنوان المنتوج</label>
		      <div class="col-lg-10 input-grup">
		      	<i class="fa fa-file"></i>
		        <input type="text" class="form-control text-right" placeholder="عنوان المنتوج" name="title">
		        <span class="help-block">عنوان المنتوج .</span>
		      </div>
		    </div>

		    <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
		      <label for="inputUser" class="col-lg-2 control-label">السعر الاصلي</label>
		      <div class="col-lg-10 input-grup">
		      	<i class="fa fa-file"></i>
		        <input type="text" class="form-control text-right" placeholder="السعر الاصلي" name="price">
		        <span class="help-block">السعر الاصلي .</span>
		      </div>
		    </div>

		    <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
		      <label for="inputUser" class="col-lg-2 control-label">التخفيض مثلا 10%</label>
		      <div class="col-lg-10 input-grup">
		        <input type="number" class="form-control text-right" placeholder="التخفيض" name="discount">
		        <span class="help-block">التخفيض .</span>
		      </div>
		    </div>

		    <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
		      <label for="inputUser" class="col-lg-2 control-label">سعر الشحن</label>
		      <div class="col-lg-10 input-grup">
		      	<i class="fa fa-file"></i>
		        <input type="text" class="form-control text-right" placeholder="سعر الشحن" name="shipping">
		        <span class="help-block">سعر الشحن .</span>
		      </div>
		    </div>

		    <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
		      <label for="inputUser" class="col-lg-2 control-label">وصف المنتوج</label>
		      <div class="col-lg-10 input-grup">
		        <textarea class="form-control" name="descr" id="editor1"></textarea>
		        <span class="help-block">وصف المنتوج .</span>
		      </div>
		    </div>

		    <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
		      <label for="inputUser" class="col-lg-2 control-label">معلومات الشحن و التسليم</label>
		      <div class="col-lg-10 input-grup">
		        <textarea class="form-control" name="info"></textarea>
		        <span class="help-block">معلومات الشحن و التسليم .</span>
		      </div>
		    </div>

		    <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
		      <label for="inputUser" class="col-lg-2 control-label">القسم</label>
		      <div class="col-lg-10 input-grup">
		        <select class="form-control" name="cat">
		        	<?php foreach($cats as $c) { ?>
		        		<option value="<?php echo $c->id; ?>"><?php echo $c->title; ?></option>
		        	<?php } ?>

		        </select>
		        <span class="help-block">القسم .</span>
		      </div>
		    </div>

			<div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
				<label for="inputUser" class="col-lg-2 control-label">صور المنتوج</label>
				<div class="col-lg-10 input-grup">
					<div class="files col-md-2">
						<i class="ion-camera"></i>
						<h5>صور</h5>
						<input type="file" class="file_select add-mor pa1" name="file[]" accept="image/jpeg,image/gif,image/png"/>
					</div>
					<div class="col-md-9 images_add">
						<ul class="morfakat"></ul>
					</div>
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




	<ul class="breadcrumb pb30">
		<li><a href="<?php echo base_url("admin"); ?>"><i class="fa fa-home"></i> الرئيسية</a></li>
		<li><a href="<?php echo base_url("admin/discounts"); ?>">المنتوجات</a></li>
		<li class="active">تعديل</li>
	</ul>

	<?php foreach($cat as $key){ ?>
	<div class="well bs-component" data-sr="wait 0s, then enter left and hustle 100%">
		<?php echo form_open_multipart("",array("class" => "form-horizontal")); ?>

		  <fieldset>

		    <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
		      <label for="inputUser" class="col-lg-2 control-label">عنوان المنتوج</label>
		      <div class="col-lg-10 input-grup">
		      	<i class="fa fa-file"></i>
		        <input type="text" class="form-control text-right" placeholder="عنوان المنتوج" name="title"  value="<?php echo $key->title; ?>">
		        <span class="help-block">عنوان المنتوج .</span>
		      </div>
		    </div>

		    <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
		      <label for="inputUser" class="col-lg-2 control-label">السعر الاصلي</label>
		      <div class="col-lg-10 input-grup">
		      	<i class="fa fa-file"></i>
		        <input type="text" class="form-control text-right" placeholder="السعر الاصلي" name="price"  value="<?php echo $key->price; ?>">
		        <span class="help-block">السعر الاصلي .</span>
		      </div>
		    </div>

		    <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
		      <label for="inputUser" class="col-lg-2 control-label">التخفيض مثلا 10%</label>
		      <div class="col-lg-10 input-grup">
		        <input type="number" class="form-control text-right" placeholder="التخفيض" name="discount"  value="<?php echo $key->discount; ?>">
		        <span class="help-block">التخفيض .</span>
		      </div>
		    </div>

		    <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
		      <label for="inputUser" class="col-lg-2 control-label">سعر الشحن</label>
		      <div class="col-lg-10 input-grup">
		      	<i class="fa fa-file"></i>
		        <input type="text" class="form-control text-right" placeholder="سعر الشحن" name="shipping" value="<?php echo $key->shipping; ?>">
		        <span class="help-block">سعر الشحن .</span>
		      </div>
		    </div>
		    <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
		      <label for="inputUser" class="col-lg-2 control-label">وصف المنتوج</label>
		      <div class="col-lg-10 input-grup">
		        <textarea class="form-control" name="descr" id="editor1"><?php echo $key->descr; ?></textarea>
		        <span class="help-block">وصف المنتوج .</span>
		      </div>
		    </div>

		    <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
		      <label for="inputUser" class="col-lg-2 control-label">معلومات الشحن و التسليم</label>
		      <div class="col-lg-10 input-grup">
		        <textarea class="form-control" name="info"><?php echo $key->info; ?></textarea>
		        <span class="help-block">معلومات الشحن و التسليم .</span>
		      </div>
		    </div>


		    <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
		      <label for="inputUser" class="col-lg-2 control-label">القسم</label>
		      <div class="col-lg-10 input-grup">
		        <select class="form-control" name="cat">
		        	<?php foreach($cats as $c) { ?>
		        		<option value="<?php echo $c->id; ?>" <?php echo $key->cat == $c->id ? "selected" : ""; ?>><?php echo $c->title; ?></option>
		        	<?php } ?>

		        </select>
		        <span class="help-block">القسم .</span>
		      </div>
		    </div>

			<div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
				<label for="inputUser" class="col-lg-2 control-label">المعرض</label>
				<div class="col-lg-10 input-grup">
					<div class="files col-md-2">
						<i class="ion-camera"></i>
						<h5>صور او فيديوهات</h5>
						<input type="file" class="file_select add-mor pa1" name="file[]" accept="image/jpeg,image/gif,image/png,video/mp4"/>
					</div>
					<div class="col-md-9 images_add">
						<ul class="morfakat">
							<?php
							$imgs = explode(",", $key->images);
							foreach($imgs as $img){
							?>
							<li style='text-align: center;'><img class='test-simg' src='<?php echo base_url("uploads"); ?>/<?php echo add_thumb($img, "_s"); ?>' style='height: 50px;width: auto;'> <br /> <a href='' style='color:red;' class='deltip'><i class='fa fa-remove'></i></a><input type="hidden" name="old_img[]" value="<?php echo $img; ?>"></li>
							<?php } ?>
						</ul>
					</div>
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
  <li class="active">المنتوجات .</li>
  <li class="pull-left"><a href="<?php echo base_url("admin/add_product"); ?>" class="btn btn-success btn-xs"><i class="fa fa-plus-square"></i> أضف منتوج جديد</a></li>
</ul>



	<table id="no-more-tables" class="table table-bordered" role="table">
		<thead>
			<tr>
				<th width="2%">#</th>
				<th width="15%" class="text-right">عنوان النتوج</th>
				<th width="10%" class="text-right">السعر الأصلي</th>
				<th width="10%" class="text-right">السعر بعد التخفيض</th>
				<th width="10%" class="text-right">عدد المبيعات</th>
				<th width="10%" class="text-right">عدد التقييمات</th>
				<th width="15%" class="text-right">عدد التقييمات بإنتظار التأكيد</th>
				<th width="60%" class="text-right">التحكم</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($cat as $key) {  ?>
			<tr>
				<td data-title="#"><span class="badge"><?php echo $key->id; ?></span></td>
				<td data-title="إسم القسم"> <?php echo $key->title; ?></td>
				<td data-title="إسم القسم"> <?php echo $key->price; ?></td>
				<td data-title="إسم القسم"> <?php echo floor($key->price - ($key->price * $key->discount / 100)); ?></td>
				<td data-title="إسم القسم"> <?php echo $this->m_p->totalSales($key->id); ?></td>
				<td data-title="إسم القسم"> <a href="<?php echo base_url("home/show/$key->id"); ?>" target="_blanck"><?php echo $this->m_p->get_num("reviews", array("product" => $key->id)); ?></a></td>
				<td data-title="إسم القسم"> <a href="<?php echo base_url("home/show/$key->id"); ?>" target="_blanck"><?php echo $this->m_p->get_num("reviews", array("product" => $key->id, "ac" => 0)); ?></a></td>
				<td data-title="التحكم" class="text-center">
					<a href="<?php echo base_url("admin/edit_product/$key->id"); ?>" class="btn btn-default btn-xs"><i class="fa fa-pencil-square"></i> تعديل</a>
           			<a href="<?php echo base_url("admin/delt/products/$key->id/products"); ?>" class="btn btn-danger btn-xs"><i class="fa fa-minus-square"></i> حذف</a>
				</td>
			</tr>
		<?php } ?>

		</tbody>		
	</table>

	<div class="center"><?php echo $links; ?></div>

<?php
}



require_once 'views/sidebar.php'; require_once 'views/foot.php';