<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "content_categories".
 *
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property string $description
 * @property string $img
 * @property string $template
 * @property string $date
 * @property integer $status
 * @property string $seo_title
 * @property string $seo_description
 * @property string $seo_keywords
 * @property integer $create_user_id
 * @property integer $update_user_id
 * @property integer $create_time
 * @property integer $update_time
 */
class ContentCategories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'content_categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['date'], 'safe'],
            [['status', 'create_user_id', 'update_user_id', 'create_time', 'update_time'], 'integer'],
            [['create_user_id', 'create_time'], 'required'],
            [['title', 'alias', 'img', 'template', 'seo_title', 'seo_description', 'seo_keywords'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'alias' => 'Alias',
            'description' => 'Description',
            'img' => 'Img',
            'template' => 'Template',
            'date' => 'Date',
            'status' => 'Status',
            'seo_title' => 'Seo Title',
            'seo_description' => 'Seo Description',
            'seo_keywords' => 'Seo Keywords',
            'create_user_id' => 'Create User ID',
            'update_user_id' => 'Update User ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
