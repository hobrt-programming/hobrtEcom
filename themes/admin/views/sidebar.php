
	</div><!-- /col-9 -->
	</div><!-- /padding -->
</div>
<!-- /main -->
<!-- sidebar -->
<div class="column col-md-2 col-xs-12" id="sidebar">
	<ul class="sideBar">
		<li><a href="<?php echo base_url('admin'); ?>"><i class="fa fa-home"></i><i class="fa fa-chevron-left pull-left sideDown"></i>الصفحة الرئيسية</a></li>

		<?php $adp = ad_perm(); ?>

		<?php

		foreach($adp as $k => $key)
		{

			if(isset($key['options']))
			{
				echo '<li class="menu"><i class="fa fa-user"></i><i class="fa fa-chevron-down pull-left sideDown"></i>';
				echo $key['title'];
				echo '<ul class="sideChild">';
				foreach($key['options'] as $k)
				{
					echo '<li><a href="'.base_url("admin/".$k['url']).'"><i class="fa fa-file"></i> '.$k['title'].'</a></li>';
				}
				echo "</ul></li>";
			}else {
				echo '<li><a href="'.base_url("admin/".$key['url']).'"><i class="fa fa-arrow-circle-left"></i><i class="fa fa-chevron-left pull-left sideDown"></i> '.$key['title'].' </a></li>';
			}
		}


		?>


	</ul>
</div>
<!-- /sidebar -->