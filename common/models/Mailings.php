<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mailings".
 *
 * @property integer $id
 * @property string $title
 * @property string $name_form
 * @property string $mails
 * @property string $email_from [varchar(50)]  e-mail в поле from письма
 * @property string $from_email [varchar(200)]  поле from для писем
 * @property string $from_name [varchar(200)]  поле from для писем
 */
class Mailings extends \yii\db\ActiveRecord
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
            [['title', 'name_form', 'mails'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'заголовок письма',
            'name_form' => 'форма рассылки',
            'mails' => 'список e-mail для рассылки через звпятую',
        ];
    }
}
