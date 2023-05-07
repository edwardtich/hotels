<?php
/**
 * Created by PhpStorm.
 * User: gerasinig
 * Date: 21.09.15
 * Time: 15:18
 */

namespace common\widgets\cropper;

use yii\web\AssetBundle;

class Asset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@common/widgets/cropper/assets';

    /**
     * @inheritdoc
     */
    public $css = [
        'cropper.min.css'
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        'cropper.min.js'
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}
