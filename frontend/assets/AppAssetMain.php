<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class AppAssetMain extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/style.min.css',
        'css/site.css',
        'css/owl.carousel.min.css',
        'css/owl.theme.default.min.css',
        'css/magnific-popup.css',
        'css/lightbox.css',
    ];
    public $js = [
        'js/jquery-3.6.4.js',
        'js/owl.carousel.js',
        'js/lightbox.js',
    ];
    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];
    public $depends = [
    ];
}