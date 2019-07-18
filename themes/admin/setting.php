<?php $title='إعدادات'; require_once 'views/head.php'; ?>

	<h2 class="text-flat">رئيسية التحكم <span class="text-sm"><?php echo $title; ?></span></h2>

	<ul class="breadcrumb pb30">
		<li><a href="<?php echo base_url("admin"); ?>"><i class="fa fa-home"></i> الرئيسية</a></li>
		<li class="active"><?php echo $title; ?></li>
	</ul>

<?php foreach($setting as $key){ ?>
	<div class="well bs-component" data-sr="wait 0s, then enter left and hustle 100%">
		<?php echo form_open_multipart("",array("class" => "form-horizontal")); ?>
		<?php 

		echo $this->upload->display_errors("<p>","</p>");
		 ?>
		  <fieldset>

		    <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
		      <label for="inputUser" class="col-lg-2 control-label">اسم الموقع</label>
		      <div class="col-lg-10 input-grup">
		        <input type="text" class="form-control text-right" name="title" value="<?php echo $key->title; ?>">
		      </div>
		    </div>

		    <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
		      <label for="inputUser" class="col-lg-2 control-label">ارقام الهاتف ضع بينهم ; </label>
		      <div class="col-lg-10 input-grup">
		        <input type="text" class="form-control text-right" name="teles" value="<?php echo $key->teles; ?>">
		      </div>
		    </div>

		    <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
		      <label for="inputUser" class="col-lg-2 control-label">ارقام واتس اب ضع بينهم ;</label>
		      <div class="col-lg-10 input-grup">
		        <input type="text" class="form-control text-right" name="whs" value="<?php echo $key->whs; ?>">
		      </div>
		    </div>

		    <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
		      <label for="inputUser" class="col-lg-2 control-label">ميسنجر</label>
		      <div class="col-lg-10 input-grup">
		        <input type="text" class="form-control text-right" name="messangers" value="<?php echo $key->messangers; ?>">
		      </div>
		    </div>

		    <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
		      <label for="inputUser" class="col-lg-2 control-label">نص الهيدر</label>
		      <div class="col-lg-10 input-grup">
		        <input type="text" class="form-control text-right" name="header" value="<?php echo $key->header; ?>">
		      </div>
		    </div>

		    <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
		      <label for="inputUser" class="col-lg-2 control-label">وصف الموقع</label>
		      <div class="col-lg-10 input-grup">
		        <input type="text" class="form-control text-right" name="descr" value="<?php echo $key->descr; ?>">
		      </div>
		    </div>
		    
		    <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
		      <label for="inputUser" class="col-lg-2 control-label">فيس بوك بيكسل</label>
		      <div class="col-lg-10 input-grup">
		        <textarea rows="12" name="fbpixel" class="form-control"><?php echo $key->fbpixel; ?></textarea>
		      </div>
		    </div>

		    <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
		      <label for="inputUser" class="col-lg-2 control-label">جوجل اناليتكس</label>
		      <div class="col-lg-10 input-grup">
		        <textarea rows="12" name="googlea" class="form-control"><?php echo $key->googlea; ?></textarea>
		      </div>
		    </div>

		    <div class="form-group" data-sr="wait 0.6s, then enter bottom and hustle 100%">
		      <label for="inputUser" class="col-lg-2 control-label">شعار الموقع</label>
		      <div class="col-lg-10 input-grup">
		        <input type="file" name="logo" class="form-control">
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
<?php } ?>
	</div>



<?php require_once 'views/sidebar.php'; require_once 'views/foot.php';