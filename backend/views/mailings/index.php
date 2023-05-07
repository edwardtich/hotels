<?php

use backend\models\search\MailingsSearch;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel MailingsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Рассылки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mailings-index">

    <div class="row">
        <div class="col-sm-8"><h1><?= Html::encode($this->title) ?></h1></div>
        <div class="col-sm-4 padding-top-25"><?= Html::a('<span class="glyphicon glyphicon-plus"></span> Добавить рассылку', ['create'], ['class' => 'btn btn-success pull-right']) ?></div>
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
            'title',
            'name_form',
            'mails',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
