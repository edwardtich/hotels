<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ContentCategories */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить категорию';
?>
<div class="content-categories-update">

    <h1 class="page-header"><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
