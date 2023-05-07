<?php
/** @var \yii\web\View $this */

/** @var $gallery array */
?>
<div class="container">
    <div class="row mt-5 gap-2 justify-content-center">
        <?php foreach ($gallery as $image): ?>
            <?php $path = Yii::$app->params['gallery']['urlDir'] . $image['gallery']; ?>
            <a class="col-sm-4  mb-3" href="<?= $path . '/' . 'max_' . $image['name'] ?>"
               data-lightbox="<?= $image['gallery'] ?>">
                <img alt="<?= $image['name'] ?>" src="<?= $path . '/' . 'max_' . $image['name'] ?>">
            </a>
        <?php endforeach; ?>
    </div>
</div>
