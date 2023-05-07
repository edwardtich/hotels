<?php

/** @var $item array */

$this->title = $item['cat_title'];

$this->registerMetaTag(['name' => 'description', 'content' => $item['seo_description'] ?: $item['title']], 'description');
$this->registerMetaTag(['name' => 'keywords', 'content' => $item['seo_keywords'] ?: $item['title']], 'keywords');
$this->registerLinkTag(['rel' => 'canonical', 'href' => \frontend\models\Content::urlCanonical($item)]);

?>

<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="d-flex flex-wrap justify-content-start">
                <div class="img-fluid" style="max-width: 450px;">
                    <img src="<?= Yii::$app->params['content']['logo']['urlDir'] . 'max_' . $item['logo'] ?>"
                         class="img-fluid">
                </div>
                <div class="ms-4" style="max-width: 630px;">
                    <div class="main__content_title">
                        <h2><?= $item['title'] ?></h2>
                    </div>
                    <div class="main__content_desc">
                        <div class="published">
                            <i class="fa fa-calendar-o"></i>
                            <time datetime="<?= $item['date'] ?>" itemprop="datePublished" data-toggle="tooltip"
                                  title=""
                                  data-original-title="Дата публикации">
                                <?= $item['date'] ?>
                            </time>
                        </div>
                        <br>
                        <?= $item['text'] ?>
                    </div>
                    <a class="title-news text-end" href="/news">
                        <h5 class="card-title ">к другим новостям и акциям </h5>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>