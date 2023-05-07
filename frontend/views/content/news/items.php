<?php

/** @var $items array */
/** @var $category array */

use frontend\models\Content;
use kuakling\materialize\widgets\LinkPager;

$this->registerMetaTag(['name' => 'description', 'content' => $item['seo_description'] ?: $item['title']], 'description');
$this->registerMetaTag(['name' => 'keywords', 'content' => $item['seo_keywords'] ?: $item['title']], 'keywords');
$this->registerLinkTag(['rel' => 'canonical', 'href' => \frontend\models\Content::urlCanonicalCategory($category)]);
$this->title = $category['title'];

?>

<div class="container mt-5 mb-5">
    <?php foreach ($items as $item): ?>
        <?php
        $date = $item['date'];
        $time = strtotime($date);
        $newformat = date('d.m.Y', $time);
        ?>
        <div class="card mb-3 border-0">
            <div class="row g-0">
                <div class="col-md-2">
                    <a href="<?= Content::url($item) ?>">
                        <img src="<?= Yii::$app->params['content']['logo']['urlDir'] . 'min_' . $item['logo'] ?>"
                             class="img-fluid lazy">
                    </a>
                </div>
                <div class="col-md-10">
                    <div class="card-body">
                        <a class="title-news" href="<?= Content::url($item) ?>">
                            <h3 class="card-title "><?= strip_tags($item['title']) ?></h3>
                        </a>
                        <p class="card-text main__content_desc"><?= $item['text'] ?></p>
                    </div>
                </div>
            </div>
        </div>
        <span class="">&nbsp;</span>
    <?php endforeach; ?>
</div>

<div class="text-center">
    <?= LinkPager::widget([
        'pagination' => $pagination,
        'prevPageLabel' => 'Предыдущая',
        'nextPageLabel' => 'Следующая'
    ]) ?>
</div>
