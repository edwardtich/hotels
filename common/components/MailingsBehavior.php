<?php

namespace common\components;

use Yii;
use yii\base\Behavior;
use common\models\Mailings;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Behavior for mailing
 *
 * For example:
 *
 * ```php
 * public function behaviors()
 * {
 *      return [
 *          'mailing' => [
 *              'class' => MailingsBehavior::className()
 *          ],
 *      ];
 * }
 * ```
 */
class MailingsBehavior extends Behavior
{
    /**
     * Функция отправки email писем
     * @param $name_form
     * @param $model
     * @param $subject
     * @return bool
     */
    public function sendEmail($name_form, $model, $subject = '')
    {
        if ($mailing = Mailings::findOne(['name_form' => $name_form]) and $mailing->mails) {
            $mail_list = explode(',', trim($mailing->mails));

            foreach ($mail_list as $email) {
                $email = trim($email);

                if ($mailing->title != '') {
                    $subject = $mailing->title;
                }

                $from = [];

                if ($mailing->from_email != '') {
                    $from['email'] = $mailing->from_email;
                    $from['name'] = '';
                }
                if ($mailing->from_name != '') {
                    $from['name'] = $mailing->from_name;
                }

                $template = $name_form;

                if (!$this->_sendItemEmail($email, $subject, $model, $template, $from)) {
                    return false;
                }

            }

            return true;
        }

        return false;
    }

    /**
     * Функция отправки одного email
     * @param $email
     * @param $subject
     * @param Model $model
     * @param $layout шаблон письма common/mail
     * @param array $from
     * @return bool
     */
    private function _sendItemEmail($email, $subject, $model, $layout, $from)
    {
        $data = Yii::$app->mailer
            ->compose($layout, ['model' => $model])
            ->setTo($email)
            ->setSubject($subject);

        if (isset($from['email']) && $from['email'] != '') {
            $data->setFrom([$from['email'] => $from['name']]);
        }

        return $data->send();
    }

}