<?php
/** @var \yii\web\View $this */

/** @var $items array */
?>
<div class="content_otzovy">
    <div class="owl-carousel owl-carousel-home">
        <?php foreach ($items as $item): ?>
            <div class="content_otzovy_block text-center p-4  d-flex flex-wrap justify-content-center align-items-center">
                <div class="col-lg-1"><i class="fa fa-quote-left"></i></div>
                <div class="col-lg-11 p-1 content_otzovy_block_message">
                    <?= $item['text'] ?>
                    <p class="content_otzovy_block_name">
                        <?= $item['title'] ?>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>