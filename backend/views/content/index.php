<?php

use backend\models\Content;
use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\ContentCategories;
use kartik\date\DatePicker;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ContentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

if (! empty(Yii::$app->request->queryParams['cat'])) {
    $this->title = ContentCategories::getCat(Yii::$app->request->queryParams['cat']);
    $createUrl = ['create','cat'=>Yii::$app->request->queryParams['cat']];
} else {
    $this->title = 'Контент';
    $createUrl = ['create'];
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="row">
        <div class="col-sm-8"><h1><?= Html::encode($this->title) ?></h1></div>
        <div class="col-sm-4 padding-top-25"><?= Html::a('<span class="glyphicon glyphicon-plus"></span> Создать страницу', $createUrl, ['class' => 'btn btn-success pull-right']) ?></div>
    </div>

    <div class="row">
        <div class="col-sm-12"><hr></div>
    </div>

    <?php Pjax::begin(['scrollTo' => new \yii\web\JsExpression('$(".table").offset().top - 10')]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'contentOptions' => ['style' => 'text-align:center;'],
                'headerOptions' => ['style' => 'text-align:center;width:70px']
            ],
            [
                'attribute' => 'logo',
                'format' => 'raw',
                'value' =>  function(Content $data) {
                    $src = $data->logo ? Yii::$app->params['content']['logo']['urlDir'] . 'min_' . $data->logo : '/100_img_not_found.jpg';
                    return Html::a(Html::img($src, ['style' => 'width:100px']), ['content/update', 'id' => $data->id], ['data-pjax' => '0']);
                },
                'filter'=>false
            ],
            [
                'attribute' => 'title',
                'headerOptions'=>['style'=>'text-align:center;'],
            ],
            [
                'label' => 'Категория',
                'attribute' => 'categories.title',
                'value' => 'categories.title',
                'contentOptions' => ['style' => 'text-align:center;'],
                'headerOptions'=> ['style' => 'text-align:center;width:200px'],
                'filter' => \backend\models\ContentCategories::getCat(),
                'visible'=> Yii::$app->request->queryParams['cat'] ? false : true,
            ],
            [
                'attribute' => 'date',
                'format' => ['date', 'php:d-m-Y'],
                'contentOptions' => ['class' => 'text-center'],
                'headerOptions'=>['style' => 'text-align:center;width:200px'],
                'filter' => DatePicker::widget(['model' => $searchModel,'attribute' => 'date','type' => DatePicker::TYPE_COMPONENT_APPEND,])
            ],
            //'description:ntext',
            // 'text:ntext',
            // 'img',
            // 'date',
            // 'status',
            // 'sort',
            // 'seo_title',
            // 'seo_description',
            // 'seo_keywords',
            // 'create_user_id',
            // 'update_user_id',
            // 'create_time:datetime',
            // 'update_time:datetime',

            ['class' => 'yii\grid\ActionColumn', 'contentOptions' => ['class' => 'text-center', 'style' => 'width:100px;']],
        ],
    ]) ?>

    <?php Pjax::end(); ?>

</div>
