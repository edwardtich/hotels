<?php
/**
 * Created by PhpStorm.
 * User: gerasinig
 * Date: 24.08.15
 * Time: 11:50
 */

namespace frontend\widgets\content;

use yii\base\Widget;
use yii\db\Query;

/**
 * Class Content
 * @package frontend\widgets\content
 * Выводит блоки контента из категории
 */
class ContentWidget extends Widget
{
    /**
     * @var
     * id категории из которой выводить
     */
    public $cat_id;

    public $id = null;

    /**
     * @var int
     * Количество
     */
    public $limit = '*';

    /**
     * @var int
     * Название шаблона
     */
    public  $template = 'news';

    public function run()
    {
        if ($items = $this->getQueryItems()) {
            return $this->render($this->template, [
                'items' => $items,
            ]);
        }

        return '';
    }

    /*
     * формируем запрос по категориям
     */
    private function getQueryItems()
    {
        return (new Query())
            ->select([
                't1.*',
                'DATE_FORMAT(t1.date,"%d-%m-%Y") AS date_public',
                't2.template',
                't2.title AS cat_title',
                't2.alias AS cat_alias',
            ])
            ->from(['t1' => '{{%content}}'])
            ->where([
                't1.status' => 1,
                't1.cat' => $this->cat_id,
            ])
            ->andFilterWhere(['t1.id' => $this->id])
            ->leftJoin(['t2' => '{{%content_categories}}'], 't2.id = t1.cat')
            ->orderBy(' t1.id ASC')
            ->limit($this->limit)
            ->all();
    }
}
