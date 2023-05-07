<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;

/**
 * This is the model class for table "{{%content_block}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $text
 * @property integer $redactor
 * @property integer $create_user_id
 * @property integer $update_user_id
 * @property integer $create_time
 * @property integer $update_time
 */
class ContentBlock extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%content_block}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','text'], 'required'],
            [['text'], 'string'],
            [['redactor'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['create_user_id', 'update_user_id', 'create_time', 'update_time'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название блока',
            'text' => 'Текст',
            'redactor' => 'Редактор',
            'create_user_id' => 'Создал',
            'update_user_id' => 'Изменил',
            'create_time' => 'Дата создания',
            'update_time' => 'Дата изменения',
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => 'create_time',
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => 'update_time',
                ],
            ],
            'attributeStamp' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => 'create_user_id',
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => 'update_user_id',
                ],
                'value' => function ($event) {
                    return Yii::$app->user->id;
                },
            ],
        ];
    }
}
