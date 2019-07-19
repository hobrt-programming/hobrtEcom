<?php foreach($info as $key){ ?>
<?php $title='تعديل بيانات المدير '.$key->username; require_once 'views/head.php'; ?>
	<h2 class="text-flat">رئيسية التحكم <span class="text-sm"><?php echo $title; ?></span></h2>

	<ul class="breadcrumb pb30">
		<li><a href="#"><i class="fa fa-home"></i> الرئيسية</a></li>
		<li><a href="#">المدراء</a></li>
		<li class="active"><?php echo $title; ?></li>
	</ul>


	<div class="well bs-component" data-sr="wait 0s, then enter left and hustle 100%">
		<?php echo form_open("",array("class" => "form-horizontal")); ?>

		  <fieldset>

		    <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
		      <label for="inputUser" class="col-lg-2 control-label">إسم المستخدم</label>
		      <div class="col-lg-10 input-grup">
		      	<i class="fa fa-user"></i>
		        <input type="text" class="form-control text-right" placeholder="إسم المستخدم" name="username" value="<?php echo $key->username; ?>">
		        <span class="help-block">الرجاء كتابة هنا إسم المستخدم .</span>
		      </div>
		    </div>
		    <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
		      <label for="inputUser" class="col-lg-2 control-label">الإيميل </label>
		      <div class="col-lg-10 input-grup">
		      	<i class="fa fa-envelope"></i>
		        <input type="text" class="form-control text-right" placeholder="الإيميل" name="email" value="<?php echo $key->email; ?>">
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
		    <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
		      <label for="inputUser" class="col-lg-2 control-label">إعادة كلمة السر</label>
		      <div class="col-lg-10 input-grup">
		      	<i class="fa fa-lock"></i>
		        <input type="password" class="form-control text-right" placeholder="إعادة كلمة السر" name="rpassword">
		        <span class="help-block">الرجاء إعادة كتابة كلمة السر هنا .</span>
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
}