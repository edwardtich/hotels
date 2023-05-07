<?php

namespace frontend\widgets\photoLightBox;

use yii\base\Widget;
use yii\db\Query;

class photoLightBox extends Widget
{
    public $gallery;
    public $view;
    public $gallery_id;

    public function run()
    {
        if (!isset($this->gallery_id)) {
            $gallery_image = (new Query())->from('{{%content_gallery}}')
                ->where(['gallery' => $this->gallery])
                ->orderBy('sort')
                ->all(); // получение фотографий
        } else {
            $gallery_id = (new Query())
                ->select(['t1.gallery'])
                ->from(['t1' => '{{%content}}'])
                ->where([
                    't1.id' => $this->gallery,
                    't1.status' => 1,
                ])
                ->leftJoin(['t2' => '{{%content_categories}}'], 't2.id = t1.cat')
                ->one(); // берем значение столбца галлерея
            $gallery_image = (new Query())->from('{{%content_gallery}}')
                ->where(['gallery' => $this->gallery_id])
                ->orderBy('sort')
                ->all(); // получение фотографий
        }
        return $this->render($this->view, ['gallery' => $gallery_image]);

    }
}