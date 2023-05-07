<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\ContentCategories */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="content-categories-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <div role="tabpanel">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#main" aria-controls="main" role="tab" data-toggle="tab">Основное</a></li>
                <li role="presentation"><a href="#seo" aria-controls="seo" role="seo" data-toggle="tab">СЕО</a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="main">
                    <div class="row margin-top-25">
                        <div class="col-sm-9">
                            <div class="well well-sm">
                                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                                <?= $form->field($model, 'status')->textInput()->checkbox() ?>
                                <?= $form->field($model,'template')->dropDownList($model->getTemplates(),['prompt'=>'По умолчанию'] ); ?>
                                <?= $form->field($model, 'img')->widget(
                                    FileInput::className(), [
                                        'pluginOptions' => [
                                            'showUpload' => false,
                                            'browseLabel' => '',
                                            'removeLabel' => '',
                                            'mainClass' => 'input-group-lg',
                                            'initialPreview'=>$model->img ? [Html::img(Yii::$app->params['catContent']['preview']['urlDir'].$model->img, ['class'=>'file-preview-image', 'alt'=>$model->title, 'title'=>$model->title])] : '',
                                        ]
                                    ]
                                );?>
                                <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="well well-sm" style="background-color: #fff; width:245px">
                                <?= $form->field($model, 'date')->widget(
                                    DatePicker::className(), [
                                    'type' => DatePicker::TYPE_INLINE,
                                    'language' => 'ru',
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'format' => 'dd-mm-yyyy',
                                    ]
                                ]);?>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="seo">
                    <div class="well well-sm margin-top-25">
                        <?= $form->field($model, 'alias',['enableAjaxValidation' => true])->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'seo_title')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'seo_description')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'seo_keywords')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>
        </div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<span class="glyphicon glyphicon-plus"></span> Создать' : ' <span class="glyphicon glyphicon-ok"></span> Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
