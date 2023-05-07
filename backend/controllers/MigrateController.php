<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;

class MigrateController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['administrator']
                    ]
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $this->actionNews();
        $this->actionSmi();
        $this->actionVideo();
    }

    public function actionNews()
    {
        $this->execute('content', 1, 3);
    }

    public function actionSmi()
    {
        $this->execute('content', 2, 12);
    }

    public function actionVideo()
    {
        $this->execute('content', 22, 4);
    }

    public function actionOther()
    {
        $this->execute('content', 28, 3);
    }

    private function execute($table = 'content', $from_cat_id = 1, $to_cat_id = 3)
    {
        ini_set('max_execution_time', 360);

        $old = (new \yii\db\Query())
            ->from('{{%content}}')
            ->where(['catid' => $from_cat_id]) // news
//            ->limit(10)
//            ->andWhere(['id' => 2446])
            ->orderBy('id desc')
            ->all(Yii::$app->get('db2'));

        foreach ($old as $item) {
            $data = [
                'id' => $item['id'],
                'gallery' => uniqid('', false),
                'cat' => $to_cat_id,

                'title' => $item['title'],
                'alias' => $item['alias'],
                'description' => $item['introtext'],
                'text' => $item['introtext'] . $item['fulltext'],
                'logo' => '',
                'date' => $item['publish_up'],
                'status' => $item['state'] > 0 ? 1 : 0,

                'seo_title' => '',
                'seo_description' => $item['metadesc'],
                'seo_keywords' => mb_substr($item['metakey'], 0, 255),
                'create_user_id' => 1,
                'update_user_id' => $item['modified_by'] ? 1 : null,
                'create_time' => strtotime($item['created']),
                'update_time' => $item['modified'] > 0 ? strtotime($item['modified']) : null,
            ];

            if ($item['imgsrc'] && is_file($fromPath = \Yii::getAlias("@frontend") . '/web/' . $item['imgsrc'])) {
                $pathinfo = pathinfo(\Yii::getAlias("@frontend") . '/web/' . $item['imgsrc']);
                $data['logo'] = uniqid('', false) . '.' . $pathinfo['extension'];
                $toPath = \Yii::getAlias(Yii::$app->params['content']['logo']['dir']) . 'min_' . $data['logo'];
                copy($fromPath, $toPath);
            }

            Yii::$app->db->createCommand()->insert($table, $data)->execute();
            echo '<div>'.$data['id'].'</div>';
        }
        echo 'done';
    }
}
