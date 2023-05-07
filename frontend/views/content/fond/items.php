<?php

use yii\widgets\LinkPager;
use frontend\models\Content;
use yii\helpers\Url;

if ($items[0]['cat_seo_title']) $this->title = $items[0]['cat_seo_title'];
else $this->title = $items[0]['cat_title'];

if ($items[0]['cat_seo_description'])
    $this->registerMetaTag(['name' => 'description', 'content' => $items[0]['cat_seo_description']], 'description');
else $this->registerMetaTag(['name' => 'description', 'content' => $items[0]['cat_title']], 'description');

if ($items[0]['cat_seo_keywords'])
    $this->registerMetaTag(['name' => 'keywords', 'content' => $items[0]['cat_seo_keywords']], 'keywords');
else $this->registerMetaTag(['name' => 'keywords', 'content' => $items[0]['cat_title']], 'keywords');

$uri = explode('?', Yii::$app->request->url)[0];
$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to([$uri], true)]);
?>
<div class="container mt-100">
    <div class="row">
        <div class="text-center col-lg-5">
            <h3 class="main__content_title text-center">
                План
            </h3>
            <?= $this->context->decodeWidgets($items[0]['text']) ?>
        </div>
        <div class="text-center col-lg-7">
            <h3 class="main__content_title text-center">
                Номерной фонд
            </h3>
            <?= \frontend\widgets\noomerFond\NumberWidget::widget() ?>
        </div>
    </div>

</div>