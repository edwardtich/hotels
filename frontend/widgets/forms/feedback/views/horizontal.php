<?php
use frontend\models\Feedback;
use yii\helpers\Url;
use yii\bootstrap\Html;
use yii\widgets\ActiveForm;
?>
<section class="main__content_body main_form text-center ">
    <div class="container">
        <img src="/img/about-heading-bg.webp" style="width: 390px; height: 40px;">
        <h2 class="main_form_title">ОСТАВЬТЕ ЗАЯВКУ ИЛИ ЗАДАЙТЕ ВОПРОС</h2>
        <?php $form = ActiveForm::begin(['options' => ['class' => 'main_form_form', 'id' => 'feedback']]); ?>
        <div class="row">
            <div class="col-sm">
                <?= $form->field($model, 'name')->textInput(['class' => 'form-control', 'placeholder' => 'Имя'])->label(false); ?>
            </div>
            <div class="col-sm">
                <?= $form->field($model, 'email')->textInput(['class' => 'form-control', 'placeholder' => 'email'])->label(false); ?>
            </div>
            <div class="col-sm">
                <?= $form->field($model, 'phone')->textInput(['class' => 'form-control', 'placeholder' => 'Телефон'])->label(false); ?>
            </div>
            <div class="col-sm">
                <?= $form->field($model, 'topic')->textInput(['class' => 'form-control', 'placeholder' => 'Тема'])->label(false); ?>
            </div>
            <?= $form->field($model, 'body')->textarea(['class' => 'form-control', 'placeholder' => 'Сообщение', 'rows'=>5])->label(false); ?>
        </div>
        <div class="text-start mt-3">
            <?= Html::Button('Отправить заявку', ['class' => 'btn btn-success','type'=>'submit']); ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</section>


<?php $this->render('_js') ?>

