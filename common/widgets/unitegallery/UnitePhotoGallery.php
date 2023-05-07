<?php
/**
 * Created by PhpStorm.
 * User: gerasinig
 * Date: 11.09.15
 * Time: 16:05
 */

namespace common\widgets\unitegallery;

use yii\base\Widget;
use yii\helpers\Json;
use yii\db\Query;
use common\widgets\unitegallery\AssetPhoto;

class UnitePhotoGallery extends Widget
{

    public $clientOptions = [];

    public $options = [];

    public $gallery;

    public function init()
    {
        parent::init();
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }

        if (!isset($this->clientOptions['slider_scale_mode']))
            $this->clientOptions['slider_scale_mode'] = 'fit';
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->registerClientScript();
        return $this->render('photo', ['data' => $this->photo(), 'id' => $this->options['id']]);
    }

    /**
     * Registers the client script required for the plugin
     */
    public function registerClientScript()
    {
        $view = $this->getView();
        AssetPhoto::register($view);
        $id = $this->options['id'];

        $options = Json::encode($this->clientOptions);
        $js = "jQuery('#$id').unitegallery($options);";
        $view->registerJs($js);
    }

    private function photo($gallery = '')
    {
        $gallery = $this->gallery;
        if ($gallery) {
            $rows = (new Query())->from('{{%content_gallery}}')
                ->where(['gallery' => $gallery])
                ->all();
            return $rows;
        }
    }
} 