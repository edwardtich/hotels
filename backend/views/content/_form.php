<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\file\FileInput;
use vova07\imperavi\Widget;
use dosamigos\fileupload\FileUploadUI;
use backend\models\ContentCategories;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Content */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="content-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div role="tabpanel">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#main" aria-controls="main" role="tab" data-toggle="tab">Основное</a></li>
            <li role="presentation"><a href="#gallery" aria-controls="gallery" role="tab" data-toggle="tab">Фотогалерея</a></li>
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
                            <?= $form->field($model, 'cat')->dropDownList(ContentCategories::getCat(),['prompt'=>'Выберите категорию ...']); ?>

<!--                            --><?//= $form->field($model, 'img')->widget(\common\widgets\cropper\FileInputCropper::className(),[
//                                'cropAttribute'=>'imgCrop',
//                                'cropConfig'=>Yii::$app->params['content']['preview'],
//                                //'cropName'=>'crop-img',
//                                'pluginOptions' => [
//                                    'showUpload' => false,
//                                    'browseLabel' => '',
//                                    'removeLabel' => '',
//                                    'mainClass' => 'input-group-lg',
//                                    'initialPreview'=>$model->img?[Html::img(Yii::$app->params['content']['preview']['urlDir'].$model->img, ['class'=>'file-preview-image', 'alt'=>$model->title, 'title'=>$model->title])]:'',
//                                ]
//                            ])?>
                            
                            <?= $form->field($model, 'logo')->widget(\common\widgets\cropper\FileInputCropper::className(),[
                                'cropAttribute'=>'logoCrop',
                                'cropConfig'=>Yii::$app->params['content']['logo'],
                                //'cropName'=>'crop-img',
                                'pluginOptions' => [
                                    'showUpload' => false,
                                    'browseLabel' => '',
                                    'removeLabel' => '',
                                    'mainClass' => 'input-group-lg',
                                    'initialPreview'=>$model->logo?[Html::img(Yii::$app->params['content']['logo']['urlDir'].$model->logo, ['class'=>'file-preview-image', 'alt'=>$model->title, 'title'=>$model->title])]:'',
                                ]
                            ])?>

                            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

                            <?= $form->field($model, 'text')->widget(Widget::className(), [
                                'settings' => [
                                    'lang' => 'ru',
                                    'minHeight' => 400,
                                    'replaceDivs'=>false,
                                    'imageUpload' => Url::to(['/content/image-upload']),
                                    'plugins' => [
                                        'clips',
                                        'fullscreen'
                                    ]
                                ]
                            ]) ?>

                            <?php if(Yii::$app->params['redactor']['styleContent']){
                                $this->registerJsFile(Yii::getAlias('@web') . '/js/redactorContentStyle.js', ['depends' => 'yii\web\JqueryAsset']);
                                $this->registerJs('applyCSSFileToElement("'.Yii::$app->params['redactor']['styleContent'].'",".redactor-editor")');
                            } ?>
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
            <div role="tabpanel" class="tab-pane" id="gallery">
                <div class="margin-top-25">
                    <?=$form->field($model,'gallery')->hiddenInput()->label(false);?>
                    <div class="alert alert-info" role="alert">Код галереи для вставки в контент [[UnitePhotoGallery|gallery=<?= $model->gallery;?>]]</div>
                    <?= FileUploadUI::widget([
                        'model' => $model,
                        'attribute' => 'images',
                        'url' => ['content/upload-gallery', 'gallery' => $model->gallery],
                        'gallery' => false,
                        'fieldOptions' => [
                            'accept' => 'image/*'
                        ],
                        'clientOptions' => [
                            'maxFileSize' => 10000000000000,
                        ],
                    ]);

                    if($model->gallery){
                        $script = "jQuery.ajax({
                                        url: '".\yii\helpers\Url::toRoute(['content/show-gallery','gallery'=>$model->gallery])."',
                                        dataType: 'json',
                                        context: jQuery('#content-images-fileupload')[0]
                                    }).done(function (result) {
                                    console.log(result);
                                        jQuery(this).fileupload('option', 'done').call(this, jQuery.Event('done'), {result: result});
                                    });
                                    ";

                        $this->registerJs($script);
                    }
                    ?>
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
        <?= Html::submitButton($model->isNewRecord ? '<span class="glyphicon glyphicon-plus"></span> Создать' : '<span class="glyphicon glyphicon-ok"></span> Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
