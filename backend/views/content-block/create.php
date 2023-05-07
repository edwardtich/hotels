<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ContentBlock */

$this->title = 'Добавить блок';
$this->params['breadcrumbs'][] = ['label' => 'Блоки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-block-create">

    <h1 class="page-header"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
