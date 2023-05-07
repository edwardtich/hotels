<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Mailings */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mailings-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name_form')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'from_email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'from_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mails')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
