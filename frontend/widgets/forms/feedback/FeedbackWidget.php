<?php
/**
 * Created by PhpStorm.
 * User: GerasinIG
 * Date: 12.02.16
 * Time: 16:59
 */

namespace frontend\widgets\forms\feedback;

use frontend\models\Feedback;
use yii\base\Widget;

class FeedbackWidget extends Widget
{


    public function run()
    {

        $model = new Feedback();

        return $this->render('horizontal', ['model' => $model]);
    }
} 