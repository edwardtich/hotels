<?php
/**
 * Created by PhpStorm.
 * User: gerasinig
 * Date: 07.09.15
 * Time: 12:10
 */

namespace frontend\widgets\contentBlock;

use common\components\InlineWidgetsBehavior;
use yii\base\Widget;
use yii\db\Query;

class ContentBlock extends Widget
{
    /**
     * id block
     * @var
     */
    public $id = null;

    public function behaviors()
    {
        return [
            'InlineWidgetsBehavior' => [
                'class' => InlineWidgetsBehavior::class,
                'widgets' => \Yii::$app->params['runtimeWidgets'],
                'startBlock' => '[[',
                'endBlock' => ']]',
            ],
        ];
    }

    public function run()
    {
        if ($this->id) {
            $row = (new Query())->select(['id', 'text'])
                ->from('{{%content_block}}')
                ->where(['id' => $this->id])
                ->one();
            if ($row) {
                return $this->decodeWidgets($row['text']);
            }
            return 'Блок не найден в базе.';
        }
        return 'Задайте id блока.';
    }

    public function decodeWidgets($text)
    {
        $behavior = $this->getBehavior('InlineWidgetsBehavior');
        return $behavior ? $behavior->decodeWidgets($text) : $text;
    }
}
