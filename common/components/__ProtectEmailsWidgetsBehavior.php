<?php
/**
 * ProtectEmailsWidgetsBehavior protects emails in content
 *
 * Controller:
 * class DefaultController extends Controller
 * {
 *     public function behaviors()
 *     {
 *         return [
 *             'ProtectEmailsWidgetsBehavior' => [
 *                 'class' => ProtectEmailsWidgetsBehavior::className(),
 *                 'categories' => [],
 *              ],
 *         ];
 *     }
 * }
 *
 * @authors:
 * @link
 * @version 1.0
 */

namespace common\components;

use yii\base\Behavior;

class ProtectEmailsWidgetsBehavior extends Behavior
{
    public $cacheTime = 0;

    /**
     * Content parser
     * Use $this->view->protectEmailWidgets($model->text) in view
     * @param $text
     * @return mixed
     */
    public function protectEmailWidgets($text)
    {
        while (preg_match('/\S+@\S+\.\S+/is', $text, $p)) {
            $text = str_replace($p[0], '1111', $text);
        }
        return $text;
    }
}
