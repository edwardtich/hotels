<?php
$this->title = 'Поиск на сайте';
/* @var $model backend\models\Content */
/** @var $items array */
use backend\models\Content;

?>

<div class="leading" style="margin-top: 20px">
        <a href="<?=\frontend\models\Content::url($model)?>" class="contentpagetitle"><?=$model['title']?></a>
    <p><?= strip_tags($model['description']) ?></p>

</div>