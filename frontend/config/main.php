<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'frontend_sokol',
    'basePath' => dirname(__DIR__),
    'language' => 'ru-RU',
    'bootstrap' => ['log'],
    'layout' => 'main',
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
//        'rbac' => 'dektrium\rbac\RbacWebModule',
//        'user' => 'dektrium\user\Module',
    ],
    'components' => [
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => 'home/index',
                'gallery' => 'site/gallery',
                'sitemap.xml' => 'sitemap/index',
                'search.html' => 'site/search',
                '<cat:[-\w]+>/<id:[\d]+>-<alias:[-\w]+>' => 'content/index',
                '<cat:[-\w]+>/<id:[\d]+>' => 'content/index',
                '<id:[-\w]+>' => 'content/index',
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,   // do not publish the bundle
                    'js' => []
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
