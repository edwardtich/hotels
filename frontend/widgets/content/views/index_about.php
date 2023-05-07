<?php
/** @var View $this */

/** @var $items array */

use yii\web\View;

?>

<?php foreach ($items as $item) :{ ?>
    <div class="main__content_room pb-60 row">
        <div class="main__content_slider col-lg-6">
            <?= \frontend\widgets\PhotoSlider\PhotoSlider::widget(['view' => 'index', 'gallery' => $item['gallery']]); ?>
        </div>
        <div class="main__content_text col-lg-6">
            <h3 class="main__content_title ms-lg-4 fs-sm-22">
                <?= $item['title']; ?>
            </h3>
            <div class="main__content_desc ms-lg-4">
                <?= $item['text'] ?>
            </div>
        </div>
    </div>
<?php } endforeach; ?>