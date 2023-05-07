<?php

namespace frontend\controllers;

use backend\models\Content;
use frontend\helpers\sitemap\MapItem;
use frontend\helpers\sitemap\Sitemap;
use yii\caching\DbDependency;
use yii\caching\Dependency;
use yii\db\Query;
use yii\helpers\Url;
use yii\web\Controller;

class SitemapController extends Controller
{
    private $sitemap;

    public function __construct($id, $module, Sitemap $sitemap, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->sitemap = $sitemap;
    }

    public function actionIndex()
    {
//        var_dump($this->getContentData());

         $this->renderSitemap('sitemap123', function () {
            return $this->sitemap->generateMap(array_map(function ($row) {
                return new MapItem(
                    Url::to(\frontend\models\Content::url($row), true),
                    $row['update_time'],
                    MapItem::WEEKLY
                );
            }, $this->getContentData()));
        }, new DbDependency(['sql' => $this->getContentDataDependency()]));
    }

    private function getContentDataDependency()
    {
        return (new Query())
            ->select(['GREATEST(IFNULL(create_time, 0), IFNULL(update_time, 0)) update_time'])
            ->from(Content::tableName())
            ->where('alias != "home" AND status = 1')
            ->orderBy(['update_time' => SORT_DESC])
            ->limit(1)
            ->createCommand()
            ->rawSql;
    }

    private function getContentData()
    {
        return (new Query())
            ->select([
                't1.id',
                't1.cat',
                't1.alias',
                't2.template',
                't2.alias AS cat_alias',
                'GREATEST(IFNULL(t1.create_time, 0), IFNULL(t1.update_time, 0)) AS update_time',
            ])
            ->from(['t1' => Content::tableName()])
            ->where('t1.alias != "home" AND t1.status = 1')
            ->leftJoin(['t2' => '{{%content_categories}}'], 't2.id = t1.cat')
            ->orderBy(['update_time' => SORT_DESC])
            ->all();
    }

    private function renderSitemap($key, callable $callback, Dependency $dependency = null)
    {
        return \Yii::$app->response->sendContentAsFile(\Yii::$app->cache->getOrSet($key, $callback, null, $dependency), Url::canonical(), [
            'mimeType' => 'application/xml',
            'inline' => true
        ]);
    }
}