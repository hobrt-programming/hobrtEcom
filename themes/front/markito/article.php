<div class="new-collection-item">
    <div class="new-collection-item-img p-0">
        <button class="wishlist noselect">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="-1 -1 26 26">
                <path d="M12 4.248c-3.148-5.402-12-3.825-12 2.944 0 4.661 5.571 9.427 12 15.808 6.43-6.381 12-11.147 12-15.808 0-6.792-8.875-8.306-12-2.944z" />
            </svg>
        </button>
        <a href="<?php echo base_url("product/$p->slug"); ?>">
            <img src="<?php echo $p->images !== null && $p->images != "" ? base_url('uploads/' . add_thumb($p->images, "_m")) : base_url("assets/img/default_product.png"); ?>" class="wow zoomIn" data-wow-delay=".25s" data-wow-duration="1s" data-wow-iteration="1" alt=""></a>
        <a href="<?php echo base_url("product/$p->slug"); ?>" class="add-to-cart shadow"><i class="fas fa-cart-plus"></i><?= lang("lang_h51") ?></a>
    </div>
    <div class="new-collection-item-content">
        <ul class="item-rating">
            <?php
            $rating = $p->review; // 3.5;

            // Calculate the number of filled, half-filled, and unfilled stars
            $filledStars = floor($rating);
            $hasHalfStar = ($rating - $filledStars) >= 0.5;
            $unfilledStars = 5 - $filledStars - ($hasHalfStar ? 1 : 0);
            ?>
            <?php for ($i = 1; $i <= $filledStars; $i++) : ?>
                <li><i class="fas fa-star"></i></li>
            <?php endfor; ?>

            <?php if ($hasHalfStar) : ?>
                <li><i class="fas fa-star-half-alt"></i></li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $unfilledStars; $i++) : ?>
                <li><i class="far fa-star"></i></li>
            <?php endfor; ?>
        </ul>
        <a href="<?= base_url("product/$p->slug") ?>">
            <h5><?php echo $p->title; ?></h5>
        </a>

        <?php /* each price in its own left-to-right box, so number and currency stay together in Arabic */ ?>
        <?php if ($p->discount != 0) { ?>
            <span><bdi dir="ltr"><?= format_money($p->price - ($p->price * $p->discount / 100)) ?></bdi> <bdi dir="ltr" class="price-discount"><?= format_money($p->price) ?></bdi></span>
        <?php } else { ?>
            <span><bdi dir="ltr"><?= format_money($p->price) ?></bdi></span>
        <?php } ?>
    </div>
</div>