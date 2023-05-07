<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Query;
use yii\web\NotFoundHttpException;
use yii\data\Pagination;
use common\components\InlineWidgetsBehavior;

class ContentController extends Controller
{
    private $pathTemplate;

    function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config = []);
        $this->pathTemplate = Yii::getAlias('@frontend/views/content');
    }

    public function behaviors()
    {
        return [
            'InlineWidgetsBehavior' => [
                'class' => InlineWidgetsBehavior::class,
                //'namespace'=> 'frontend\widgets', // default namespace (optional)
                'widgets' => Yii::$app->params['runtimeWidgets'],
                'startBlock' => '[[',
                'endBlock' => ']]',
            ],
        ];
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionIndex($id = null, string $cat = null)
    {
        if ($id && $id !== 'home') {
            $page = $this->getItem($id, $cat);

            if ($page) {
                if ($page['template'] && file_exists($this->pathTemplate . '/item.php')) {
                    return $this->render($page['template'] . '/item', ['item' => $page]);
                }
                return $this->render('item', ['item' => $page]);
            }
            return $this->getItems($id, true);
        }

        if ($cat) {
            return $this->getItems($cat);
        }
        throw new NotFoundHttpException;
    }

    /**
     * Получаем страницы категории (по алиасу или id)
     * @param $cat
     * @param string $alias
     * @param null $item
     * @return string
     * @throws NotFoundHttpException
     */
    private function getItems($cat, $alias = false, $item = null)
    {
        $category = (new Query())
            ->where(['alias' => $cat])
            ->from('{{%content_categories}}')
            ->one();

        $catQuery = (new Query())
            ->select(['t1.id',
                't1.title',
                't1.description',
                't1.text',
                't1.cat',
                't1.alias',
                't1.img',
                't1.logo',
                'DATE_FORMAT(t1.date,"%d-%m-%Y") AS date',
                't1.is_date_hidden',
                't1.gallery',
                't1.youtube',
                't1.seo_title',
                't1.seo_description',
                't1.seo_keywords',
                't2.template',
                't2.title AS cat_title',
                't2.alias AS cat_alias',
                't2.seo_title AS cat_seo_title',
                't2.seo_description AS cat_seo_description',
                't2.seo_keywords AS cat_seo_keywords',
            ])
            ->from(['t1' => '{{%content}}'])
            ->leftJoin(['t2' => '{{%content_categories}}'], 't2.id = t1.cat')
            ->orderBy('t1.date DESC,t1.id DESC');

        if ($alias) {
            $catQuery->where(['t2.alias' => $cat, 't2.status' => 1, 't1.status' => 1])
                ->andWhere('t2.template != "static"');// не отображать статьи для категории с алиасом "static" (статичные страницы)
        } else {
            $catQuery->where(['t1.cat' => $cat, 't2.status' => 1, 't1.status' => 1])
                ->andWhere('t2.template != "static"');// не отображать статьи для категории с алиасом "static" (статичные страницы)
        }

        $countPagination = $catQuery->count();
        $pagination = new Pagination([
            'totalCount' => $countPagination,
            'defaultPageSize' => Yii::$app->params['content']['pagination'],
        ]);
        $pagination->route = 'content/index';

        $cat = $catQuery->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        if ($cat) {
            if ($cat[0]['template'] && file_exists($this->pathTemplate . '/' . $cat[0]['template'] . '/items.php')) {
                return $this->render($cat[0]['template'] . '/items', ['items' => $cat, 'pagination' => $pagination, 'item' => $item, 'category' => $category]);
            }
            return $this->render('items', ['items' => $cat, 'pagination' => $pagination,]);
        }

        throw new NotFoundHttpException;
    }

    /** Получаем страницу по алиасу или id
     * @param $id
     * @param string|null $cat
     * @return array
     */
    private function getItem($id, string $cat = null)
    {
        $query = (new Query())
            ->select(['t1.title',
                't1.id',
                't1.description',
                't1.text',
                't1.alias',
                't1.cat',
                't1.img',
                't1.logo',
                'DATE_FORMAT(t1.date,"%d-%m-%Y") AS date',
                't1.is_date_hidden',
                't1.gallery',
                't1.youtube',
                't1.seo_title',
                't1.seo_description',
                't1.seo_keywords',
                't2.title AS cat_title',
                't2.alias AS cat_alias',
                't2.template',
            ])
            ->from(['t1' => '{{%content}}'])
            ->leftJoin(['t2' => '{{%content_categories}}'], 't2.id = t1.cat')
            ->where(['t1.alias' => $id, 't1.status' => 1, 't2.status' => 1])
            ->orWhere(['t1.id' => $id]);

        if ($cat) {
            $query->andWhere(['t2.alias' => $cat]);
        } else {
            $query->andWhere('t2.template = "static"');
        }

        return $query->one();
    }
}
