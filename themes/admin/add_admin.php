<?php $title='إضافة مد'; require_once 'views/head.php'; ?>


	<ul class="breadcrumb pb30">
		<li><a href="<?php echo base_url("admin"); ?>"><i class="fa fa-home"></i> الرئيسية</a></li>
		<li><a href="<?php echo base_url("admin/cat"); ?>">المدراء</a></li>
		<li class="active">إضافة مدير</li>
	</ul>

	<?php if(isset($msg)){ ?>
	<div class="alert alert-success">تم إضافة المدير بنجاح .</div>
	<?php } ?>
	<div class="well bs-component" data-sr="wait 0s, then enter left and hustle 100%">
		<?php echo form_open("admin/add_admin",array("class" => "form-horizontal")); ?>

		  <fieldset>

		    <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
		      <label for="inputUser" class="col-lg-2 control-label">إسم المستخدم</label>
		      <div class="col-lg-10 input-grup">
		      	<i class="fa fa-user"></i>
		        <input type="text" class="form-control text-right" placeholder="إسم المستخدم" name="username">
		        <span class="help-block">الرجاء كتابة هنا إسم المستخدم .</span>
		      </div>
		    </div>
		    <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
		      <label for="inputUser" class="col-lg-2 control-label">الإيميل </label>
		      <div class="col-lg-10 input-grup">
		      	<i class="fa fa-envelope"></i>
		        <input type="text" class="form-control text-right" placeholder="الإيميل" name="email">
		        <span class="help-block">الرجاء كتابة هنا الإيميل .</span>
		      </div>
		    </div>
		    <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
		      <label for="inputUser" class="col-lg-2 control-label">كلمة السر </label>
		      <div class="col-lg-10 input-grup">
		      	<i class="fa fa-lock"></i>
		        <input type="password" class="form-control text-right" placeholder="كلمة السر" name="password">
		        <span class="help-block">الرجاء كتابة هنا كلمة السر .</span>
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



<?php require_once 'views/sidebar.php'; require_once 'views/foot.php';