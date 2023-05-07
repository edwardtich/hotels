<?php
/** @var View $this */

/** @var $items array */

use yii\web\View;

?>

<?php foreach ($items as $item) :{ ?>
        <div class="main__content_service">
        <p class="text-center m-0">
            <img src="/img/resort-title-heading.png" width="200" height="20">
        </p>
        <h3 class="main__content_title fs-sm-22 text-center">
            <?= $item['title']; ?>
        </h3>
            <?= $item['text'] ?>
        </div>
<?php } endforeach; ?>