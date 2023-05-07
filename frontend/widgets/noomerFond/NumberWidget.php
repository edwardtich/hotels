<?php

namespace frontend\widgets\noomerFond;

use yii\base\Widget;
use yii\db\Query;

/**
 *
 * @property-read mixed $queryItems
 */
class NumberWidget extends Widget
{

    public function run()
    {
        $rooms = $this->getQueryItems();
        $room = [];
        foreach ($rooms as $item):{
            $room[$item['cat_title']][]= [
                'id'=>$item['id'],
                'floar'=>$item['cat_title'],
                'number'=>$item['title'],
                'description'=>$item['text'],
                'gallery'=>$item['gallery'],
            ];
        }
        endforeach;
        return $this->render('index', [
            'room'=>$room

        ]);
    }

    private function getQueryItems()
    {
        return (new Query())
            ->select([
                't1.id',
                't1.title',
                't1.description',
                't1.text',
                't1.cat',
                't1.img',
                't1.is_date_hidden',
                't1.gallery',
                't2.title AS cat_title',
            ])
            ->from(['t1' => '{{%content}}'])
            ->where([
                't1.status' => 1,
                't2.template' => 'rooms',
            ])
            ->leftJoin(['t2' => '{{%content_categories}}'], 't2.id = t1.cat')
            ->orderBy('t2.sort ASC')
            ->all();
    }
}
