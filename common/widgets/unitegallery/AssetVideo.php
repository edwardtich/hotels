<?php
/**
 * Created by PhpStorm.
 * User: GerasinIG
 * Date: 26.06.15
 * Time: 14:11
 */

namespace common\widgets\unitegallery;

use yii\web\AssetBundle;


class AssetVideo extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@common/widgets/unitegallery/assets';

    /**
     * @inheritdoc
     */
    public $css = [
        'css/unite-gallery.css',
        'themes/video/skin-right-thumb.css'
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        'js/unitegallery.min.js',
        'themes/video/ug-theme-video.js'
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset'
    ];

} 