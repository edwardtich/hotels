<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "mailings".
 *
 * @property integer $id
 * @property string $title
 * @property string $name_form
 * @property string $mails
 */
class Mailings extends \common\models\Mailings
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mailings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_form', 'mails'], 'required'],
            [['title', 'name_form', 'mails'], 'string', 'max' => 255],
            [['from_email', 'from_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок письма',
            'from_email' => 'Email отправителя',
            'from_name' => 'Имя отправителя',
            'name_form' => 'Имя формы рассылки',
            'mails' => 'Список e-mail для рассылки через звпятую',
        ];
    }
}
