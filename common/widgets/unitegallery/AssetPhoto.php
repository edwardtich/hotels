<?php
/**
 * Created by PhpStorm.
 * User: GerasinIG
 * Date: 26.06.15
 * Time: 14:11
 */

namespace common\widgets\unitegallery;

use yii\web\AssetBundle;


class AssetPhoto extends AssetBundle
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
        'themes/default/ug-theme-default.css'
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        'js/unitegallery.min.js',
        'themes/default/ug-theme-default.js'
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset'
    ];

} 