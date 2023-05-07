<?php

use backend\models\search\ContentCategoriesSearch;
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel ContentCategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-categories-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="row">
        <div class="col-sm-8"><h1><?= Html::encode($this->title) ?></h1></div>
        <div class="col-sm-4 padding-top-25"><?= Html::a('<span class="glyphicon glyphicon-plus"></span> Создать категорию', ['create'], ['class' => 'btn btn-success pull-right']) ?></div>
    </div>

    <div class="row">
        <div class="col-sm-12"><hr></div>
    </div>

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
                'attribute' => 'img',
                'format' => 'image',
                'value' =>  function($data) { return $data->img ? Yii::$app->params['catContent']['preview']['urlDir'].$data->img : '/100_img_not_found.jpg'; },
                'contentOptions' => ['style'=>'width:100px;'],
                'filter'=>false
            ],
            //'id',
            'title',
            //'description:ntext',
            //'img',
            [
                'attribute' => 'date',
                'format' => ['date', 'php:d-m-Y'],
                'contentOptions' => ['class'=>'text-center'],
                'headerOptions'=>['style'=>'text-align:center;width:200px'],
                'filter' =>DatePicker::widget(['model'=>$searchModel,'attribute'=>'date','type' => DatePicker::TYPE_COMPONENT_APPEND,])
            ],
            // 'status',
            // 'create_user_id',
            // 'update_user_id',
            // 'created_time',
            // 'updated_time',

            ['class' => 'yii\grid\ActionColumn','contentOptions'=>['class'=>'text-center','style'=>'width:100px;']],
        ],
    ]); ?>

</div>
