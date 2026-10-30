<?php

foreach ($info as $key ) { ?>
	

	<?php $pcs = json_decode($key->products, TRUE); foreach($pcs as $p) { ?>
		<li class="media mb-4">
			<img src="<?php echo base_url("uploads")."/".add_thumb(get_info("products", $p['id'], "images") ,'_s') ?>" class="mr-3 rounded-lg" alt="...">
			<div class="media-body">
				<a class="btn btn-danger btn-circle btn-sm float-right" onclick="deletePrd(<?=$p['id'];?>);"><i class="fas fa-trash"></i></a>
				<h5 class="mt-0 mb-1"><?php echo get_info("products", $p['id'], "title"); ?></h5>
				Qty: <b><?php echo $p['q']; ?></b> <br>

				<?php
				if(isset($p['options']) && $p['options'] != null)
				{
					$op = json_decode($p['options'], TRUE);
					if(!is_null($op)){
						foreach ($op as $key1 => $value1) {
							echo option_label($key1), " : ", html_escape($value1), "<br>";
						}
					}
				}
				?>
			</div>
		</li>
	<?php } }


?>