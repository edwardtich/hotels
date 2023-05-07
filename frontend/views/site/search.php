<?php
/* @var $searchModel SearchForm */
/* @var $dataProvider ActiveDataProvider */

use frontend\models\SearchForm;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\data\ActiveDataProvider;
$this->title="Поиск";
?>
<div class="search_list">
<h5 class="search_title">Поиск по сайту </h5>
<div class ="search_form">
    <?php $form = ActiveForm::begin(['action' => ['/site/search'], 'method' => 'get']); ?>
    <?= Html::activeTextInput($searchModel, 'text', ['placeholder'=>"Введите запрос"])  ?>
    <?= Html::submitButton('Найти', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end(); ?>
</div>
</div>

<?php
if ($searchModel->text) {
echo (\yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'itemOptions' => ['class' => 'item'],
    'itemView' => function ($model) {
        return $this->render('_item', ['model' => $model]);
        },
]));
}
else {
echo ('Для поиска введите запрос');
}?>
