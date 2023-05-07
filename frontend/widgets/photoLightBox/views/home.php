<?php
/** @var \yii\web\View $this */

/** @var $gallery array */
?>

    <?php foreach ($gallery as $image): ?>
        <?php $path = Yii::$app->params['gallery']['urlDir'] . $image['gallery']; ?>
        <a class="col-sm-4 mb-3" href="<?=$path. '/' . 'max_' . $image['name']?>" data-lightbox="<?=$image['gallery']?>" >
        <img alt="<?=$image['name']?>" src="<?=$path. '/' . 'max_' . $image['name']?>">
        </a>
    <?php endforeach; ?>