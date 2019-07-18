<?php require_once 'views/head.php'; ?>

<ul class="breadcrumb pb30">
  <li><a href="#">الرئيسية</a></li>
  <li class="active">الرسائل</li>
</ul>


<?php foreach($msg as $key){ ?>
	<caption class="text-right text-success"><i class="fa fa-table fa-fw"></i>إسم المرسل .</p></caption>
	<h3><?php echo $key->name; ?></h3>
	<caption class="text-right text-success"><i class="fa fa-table fa-fw"></i>البريد الإلكتروني .</p></caption>
	<h3><?php echo $key->email; ?></h3>
	
	<caption class="text-right text-success"><i class="fa fa-table fa-fw"></i>نص الرسالة .</p></caption>
	<p><?php echo $key->msg; ?></p>
<?php } ?>
<?php require_once 'views/sidebar.php'; require_once 'views/foot.php';