<?php if (!empty($products)) : ?>
    <ul class="list-group">
        <?php foreach ($products as $product) : ?>
            <li class="list-group-item"  data-product-id="<?= $product["id"] ?>" style="cursor:pointer">
                <img class="rounded mr-2" width="30" height="30" src="<?= base_url('uploads/'.add_thumb($product["images"] , "_s")); ?>" />
                <span><?= $product['title'] ?></span>
                <i class="fas fa-times text-danger" style="float: right;font-size: 25px;"></i>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else : ?>
    <p>No results found</p>
<?php endif; ?>