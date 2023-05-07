<?php

use backend\models\search\ContentBlockSerach;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel ContentBlockSerach */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Текстовые или html блоки для вставки на сайте через widget';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-block-index">

    <div class="row">
        <div class="col-sm-8"><h1><?= Html::encode($this->title) ?></h1></div>
        <div class="col-sm-4 padding-top-25"><?= Html::a('<span class="glyphicon glyphicon-plus"></span> Добавить блок', ['create'], ['class' => 'btn btn-success pull-right']) ?></div>
    </div>

    <div class="row">
        <div class="col-sm-12"><hr></div>
    </div>
    <div class="alert alert-info" role="alert">
        Код для вставки виджета в контент [[ContentBlock|id=idBlock]]<br>
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'contentOptions'=>['style'=>'text-align:center;'],
                'headerOptions'=>['style'=>'text-align:center;width:70px']
            ],
            'title',
            [
                'attribute' => 'create_time',
                'format' => ['datetime'],
                'contentOptions' => ['class'=>'text-center'],
                'headerOptions'=>['style'=>'text-align:center;width:200px'],
            ],
            //'text:ntext',
            //'create_user_id',
            //'update_user_id',
            //'create_time:datetime',
            // 'update_time:datetime',

            ['class' => 'yii\grid\ActionColumn','contentOptions'=>['class'=>'text-center','style'=>'width:100px;']],
        ],
    ]); ?>

</div>
