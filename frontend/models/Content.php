<?php
/**
 * Created by PhpStorm.
 * User: gerasinig
 * Date: 24.08.15
 * Time: 13:21
 */

namespace frontend\models;

use yii\helpers\Url;

class Content
{
    /**
     * Возвращает ссылку на материал по алиасу или по id
     *
     * @param $item
     * @param bool $canonical - каноническая ссылка
     * @return string
     */
    public static function url($item, bool $canonical = false): string
    {
        if ($item instanceof \backend\models\Content) {
            $item = [
                'template' => $item->categories->template,
                'cat_alias' => $item->categories->alias,
                'id' => $item->id,
                'alias' => $item->alias
            ];
        }
        if ($item['template'] !== 'static' && $item['cat_alias']) {
            return Url::toRoute(['content/index',
                'id' => $item['id'],
                'cat' => $item['cat_alias'],
                'alias' => $item['alias'] && !$canonical ? $item['alias'] : null
            ]);
        }
        if ($item['alias']) {
            return Url::toRoute(['content/index', 'id' => $item['alias']]);
        }
        return Url::toRoute(['content/index', 'id' => $item['id']]);
    }

    /**
     * @param $item
     * @return string
     */
    public static function urlCanonical($item): string
    {
        return Url::to(self::url($item, true), true);
    }

    public static function urlCanonicalCategory($category)
    {
        return Url::toRoute(['content/index',
            'id' => $category['alias'] ?: null,
            'page' => isset($_GET['page']) && (int) $_GET['page'] ? (int) $_GET['page'] : null
        ]);
    }
} 