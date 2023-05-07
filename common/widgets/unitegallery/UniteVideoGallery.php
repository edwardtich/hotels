<?php
/**
 * Created by PhpStorm.
 * User: GerasinIG
 * Date: 26.06.15
 * Time: 14:06
 */

namespace common\widgets\unitegallery;

use yii\base\Widget;
use yii\helpers\Json;
use yii\db\Query;
use common\widgets\unitegallery\AssetVideo;

class UniteVideoGallery extends Widget
{
    public $clientOptions = [];

    public $options = [];

    public $cat;

    public function init()
    {
        parent::init();
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->registerClientScript();
        return $this->render('index', ['data' => $this->video(), 'id' => $this->options['id']]);
    }

    /**
     * Registers the client script required for the plugin
     */
    public function registerClientScript()
    {
        $view = $this->getView();
        AssetVideo::register($view);
        $id = $this->options['id'];
        $options = Json::encode($this->clientOptions);
        $js = "jQuery('#$id').unitegallery($options);";
        $view->registerJs($js);
    }

    private function video($cat = '')
    {
        $cat = $this->cat;
        if ($cat) {
            $rows = (new Query())->from('{{%video}}')
                ->where(['status' => 1, 'cat' => $cat])
                ->orderBy('create_time DESC')
                ->all();
        } else {
            $rows = (new Query())->from('{{%video}}')
                ->where(['status' => 1])
                ->orderBy('create_time DESC')
                ->all();
        }

        return $rows;
    }
} 