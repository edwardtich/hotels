<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Mailings */

$this->title = 'Добавление рассылки';
$this->params['breadcrumbs'][] = ['label' => 'Mailings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mailings-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
