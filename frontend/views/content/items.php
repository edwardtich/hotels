<?php

use yii\widgets\LinkPager;
use frontend\models\Content;
use yii\helpers\Url;

//echo $_SERVER['REQUEST_URI'];
if($items[0]['cat_seo_title']) $this->title = $items[0]['cat_seo_title'];
else $this->title = $items[0]['cat_title'];

if($items[0]['cat_seo_description'])
    $this->registerMetaTag(['name' => 'description', 'content' => $items[0]['cat_seo_description']], 'description');
else $this->registerMetaTag(['name' => 'description', 'content' =>$items[0]['cat_title']], 'description');

if($items[0]['cat_seo_keywords'])
    $this->registerMetaTag(['name' => 'keywords', 'content' => $items[0]['cat_seo_keywords']], 'keywords');
else $this->registerMetaTag(['name' => 'keywords', 'content' =>$items[0]['cat_title']], 'keywords');

$uri = explode('?', Yii::$app->request->url)[0];

$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to([$uri], true)]);
?>
<!---->
<!---->
<!--<section id="news">-->
<!--    <div class="container">-->
<!--        <h1 class="white-text1">--><?//=$items[0]['cat_title'];?><!--</h1>-->
<!--        <div class="row">-->
<!--        --><?php //foreach($items as $item): ?>
<!--            <div class="col m3 l3">-->
<!--                <div class="card hoverable news hoverable-pink">-->
<!--                    <div class="card-image">-->
<!--                        <a href="--><?//=Content::url($item)?><!--">-->
<!--                            --><?php //if($item['logo']):?>
<!--                                <img src="--><?//=Yii::$app->params['content']['logo']['urlDir'].'min_'.$item['logo']?><!--" alt="--><?//=$item['title']?><!--"/>-->
<!--                            --><?php //elseif ($item['img']):?>
<!--                                <img src="--><?//=Yii::$app->params['content']['preview']['urlDir'].'min_'.$item['img']?><!--" alt="--><?//=$item['title']?><!--"/>-->
<!--                            --><?php //else:?>
<!--                                <img src="/images/content_b.jpg" alt="--><?//=$item['title']?><!--"/>-->
<!--                            --><?php //endif;?>
<!--                            <div class="card-title bg-dark white-text">-->
<!--                                --><?//=$item['title']?><!--<br>-->
<!--                                --><?php //if (! $item['is_date_hidden']): ?>
<!--                                    <span class="card-date">--><?//=Yii::$app->formatter->asDate($item['date'], 'php:d.m.Y')?><!--</span>-->
<!--                                --><?php //endif; ?>
<!--                            </div>-->
<!--                        </a>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        --><?php //endforeach;?>
<!--        </div>-->
<!---->
<!--        <div class="center-align">-->
<!--            --><?//= LinkPager::widget([
//                'pagination' => $pagination,
//                'prevPageLabel' => '<i class="material-icons">chevron_left</i>',
//                'nextPageLabel' => '<i class="material-icons">chevron_right</i>'
//                ]) ?>
<!--        </div>-->
<!--    </div>-->
<!--</section>-->