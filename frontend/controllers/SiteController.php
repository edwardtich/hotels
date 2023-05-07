<?php

namespace frontend\controllers;
use frontend\models\Feedback;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use common\components\MailingsBehavior;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
            'mailings' => [
                'class' => MailingsBehavior::class
            ],
        ];
    }


    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionGallery()
    {
        return $this->render('gallery');
    }


    /**
     * Форма обратной связи
     * @return string
     */
    public function actionFeedback()
    {
        $model = new Feedback();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($this->sendEmail('feedback', $model, 'Вопрос c сайта НОРА')) {
                return json_encode(['status'=>1,'message'=>'Сообщение отправлено.']);
            } else
                return json_encode(['status'=>0,'message'=>'Произошла ошибка при отправке сообщения.']);
        }
    }
}
