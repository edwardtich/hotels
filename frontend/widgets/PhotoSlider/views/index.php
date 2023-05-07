<?php
/** @var \yii\web\View $this */

/** @var $gallery array */
?>
<div class="owl-carousel owl-carousel-home popup-gallery">
    <?php foreach ($gallery as $image): ?>
        <?php $path = Yii::$app->params['gallery']['urlDir'] . $image['gallery']; ?>
        <a href="<?=$path. '/' . 'max_' . $image['name']?>">
            <img class="owl-lazy"
                 data-src="<?=$path. '/' . 'max_' . $image['name']?>"
                 alt="<?=$image['name']?>"
                 src="<?=$path. '/' . 'max_' . $image['name']?>"/>
        </a>
    <?php endforeach; ?>
</div>