<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;
use common\components\UploadFileBehavior;
use common\components\UniqueAliasValidator;
use yii\db\BaseActiveRecord;

/**
 * This is the model class for table "{{%content}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property integer $cat
 * @property string $description
 * @property string $text
 * @property string $img
 * @property string $date
 * @property integer $is_date_hidden
 * @property integer $status
 * s@property string $gallery
 * @property integer $sort
 * @property string $seo_title
 * @property string $seo_description
 * @property string $seo_keywords
 * @property integer $create_user_id
 * @property integer $update_user_id
 * @property integer $create_time
 * @property integer $update_time
 * @property string $logo [varchar(255)]  миниатюра
 * @property string $youtube [varchar(20)]
 * @property int $on_main [int(1)]
 * @property ContentCategories $categories
 */
class Content extends \yii\db\ActiveRecord
{
    public $imgCrop;
    public $logoCrop;
    public $images;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%content}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'cat', 'gallery'], 'required'],
            [['cat', 'status', 'sort', 'is_date_hidden'], 'integer'],
            [['text', 'description'], 'string'],
            [['date'], 'date', 'format' => 'php:d-m-Y'],
            [['title', 'alias', 'seo_title', 'seo_description', 'seo_keywords', 'gallery'], 'string', 'max' => 255],
            [['youtube'], 'string', 'max' => 20],
            [['alias'], UniqueAliasValidator::class, 'tables' => ['{{%content}}', '{{%content_categories}}']],
            ['alias', 'match', 'pattern' => '/^([\w-]+)$/i'],
            [['img', 'logo'], 'file', 'extensions' => 'gif, jpg, png,jpeg'],
            [['images'], 'file', 'extensions' => 'gif, jpg, png,jpeg', 'maxSize' => 10 * 1024 * 1024],
            [['create_user_id', 'update_user_id', 'create_time', 'update_time', 'imgCrop', 'logoCrop', 'store_id', 'date_sale_end'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'alias' => 'Alias',
            'cat' => 'Категория',
            'description' => 'Короткое описание',
            'text' => 'Полное описание',
            'img' => 'Изображение',
            'logo' => 'Превью',
            'youtube' => 'Код Youtube',
            'date' => 'Дата публикации',
            'is_date_hidden' => 'Скрыть дату публикации',
            'status' => 'Показать / Скрыть',
            'sort' => 'Сортировка',
            'seo_title' => 'Seo Title',
            'seo_description' => 'Seo Description',
            'seo_keywords' => 'Seo Keywords',
            'create_user_id' => 'Create User ID',
            'update_user_id' => 'Update User ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'gallery' => 'gallery',
            'store_id' => 'Привязка акции к магазину',
            'date_sale_end' => 'Дата окончания акции'
        ];
    }

    /**
     * relation with ContentCategories
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasOne(ContentCategories::class, ['id' => 'cat']);
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => 'create_time',
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => 'update_time',
                ],
            ],
            'attributeStamp' => [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => 'create_user_id',
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => 'update_user_id',
                ],
                'value' => function ($event) {
                    return Yii::$app->user->id;
                },
            ],
            'date' => [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => 'date',
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => 'date',
                ],
                'value' => function ($event) {
                    return Yii::$app->formatter->asDatetime($this->date . ' 00:00:00', 'php:Y-m-d 00:00:00');
                },
            ],
            'file' => [
                'class' => UploadFileBehavior::class,
                'attributeName' => 'img',
                'cropCoordinatesAttrName' => 'imgCrop',
                'savePath' => Yii::$app->params['content']['preview']['dir'],
                'generateNewName' => true,
                'protectOldValue' => true,
                'defaultCrop' => Yii::$app->params['content']['preview']['defaultCrop'],
                'crop' => Yii::$app->params['content']['preview']['crop']
            ],
            'logo' => [
                'class' => UploadFileBehavior::class,
                'attributeName' => 'logo',
                'cropCoordinatesAttrName' => 'logoCrop',
                'savePath' => Yii::$app->params['content']['logo']['dir'],
                'generateNewName' => true,
                'protectOldValue' => true,
                'defaultCrop' => Yii::$app->params['content']['logo']['defaultCrop'],
                'crop' => Yii::$app->params['content']['logo']['crop']
            ],
        ];
    }
}
