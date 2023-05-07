<?php

use vova07\imperavi\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ContentBlock */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="content-block-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php if ($model->redactor) : ?>

        <?= $form->field($model, 'text')->widget(Widget::class, [
            'settings' => [
                'lang' => 'ru',
                'minHeight' => 400,
                'replaceDivs'=>false,
                'plugins' => [
                    'fullscreen'
                ]
            ]
        ]) ?>

    <?php else : ?>

        <?= $form->field($model, 'text')->textarea(['rows' => 20]) ?>

    <?php endif; ?>

    <?= $form->field($model, 'redactor')->textInput()->checkbox() ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<span class="glyphicon glyphicon-plus"></span> Добавить' : ' <span class="glyphicon glyphicon-ok"></span> Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
