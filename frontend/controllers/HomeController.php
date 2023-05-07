<?php

namespace frontend\controllers;

use frontend\models\Content;
use yii\db\Query;
use yii\web\Controller;

/**
 * Site controller
 */
class HomeController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
