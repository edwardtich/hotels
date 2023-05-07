<?php
use yii\helpers\Html;

foreach ($model->getAttributes() as $attr => $value) {
    if ($attr != 'reCaptcha') {
        echo Html::tag('p', '<b>' . $model->getAttributeLabel($attr) . '</b> : ' . $value);
    }
}
