<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use common\components\UploadFileBehavior;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use common\components\UniqueAliasValidator;

/**
 * This is the model class for table "{{%content_categories}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $img
 * @property string $date
 * @property integer $status
 * @property string $template
 * @property integer $create_user_id
 * @property integer $update_user_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $alias [varchar(255)]
 * @property string $seo_title [varchar(255)]
 * @property string $seo_description [varchar(255)]
 * @property string $seo_keywords [varchar(255)]
 * @property int $create_time [int(11)]
 * @property int $update_time [int(11)]
 */
class ContentCategories extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%content_categories}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','date'], 'required'],
            [['description','alias','seo_title','seo_description','seo_keywords'], 'string'],
            [['date'], 'date','format'=>'php:Y-m-d 00:00:00'],
            [['create_time', 'update_time','create_user_id', 'update_user_id'], 'safe'],
            [['status'], 'integer'],
            [['template'], 'filter', 'filter' => function($value) {
                    return trim(htmlentities(strip_tags($value), ENT_QUOTES, 'UTF-8'));
            }],
            [['alias'],UniqueAliasValidator::className(),'tables'=>['{{%content}}','{{%content_categories}}']],
            [['title'], 'string', 'max' => 255],
            [['img'], 'file', 'extensions' => 'gif, jpg, png,jpeg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название категории',
            'description' => 'Описание',
            'img' => 'Изображение',
            'date' => 'Дата публикации',
            'status' => 'Показать / Скрыть',
            'template' => 'Шаблон отображения материала (/frontend/views/content/название_папки_шаблона)',
            'create_user_id' => 'Создал',
            'update_user_id' => 'Изменил',
            'create_time' => 'Дата создания',
            'update_time' => 'Дата изменения',
        ];
    }

    public static function getCat($id = false){
        if($id){
            $cat = (new Query())->select(['title'])
                ->from('{{%content_categories}}')
                ->where(['id'=>(int)$id])
                ->one();
            return $cat['title'];
        }
        else{
            $cat = (new Query())->select(['id','title'])
                ->from('{{%content_categories}}')
                ->all();
            return ArrayHelper::map($cat,'id','title');
        }
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'create_time',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'update_time',
                ],
            ],
            'attributeStamp' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'create_user_id',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'update_user_id',
                ],
                'value' => function ($event) {
                        return Yii::$app->user->id;
                    },
            ],
            'file' => [
                'class' => UploadFileBehavior::className(),
                'attributeName' => 'img',
                'savePath' => Yii::$app->params['catContent']['preview']['dir'],
                'generateNewName' => true,
                'protectOldValue' => true,
                'defaultCrop' => Yii::$app->params['catContent']['preview']['defaultCrop'],
                'crop'=>Yii::$app->params['catContent']['preview']['crop']
            ],
        ];
    }

    /**
     * получаем имена шаблонов (дирректорий) в frontend/views/content
     * @return array
     */
    public function getTemplates(){
        $dir = Yii::getAlias('@frontend/views/content');
        $dirOpen = opendir($dir);
        $template = [];
        while($file = readdir($dirOpen)) {
            if (is_dir($dir.'/'.$file) && $file != '.' && $file != '..') {
                $template[$file] = $file;
            }
        }
        closedir($dirOpen);
        return $template;
    }
}
