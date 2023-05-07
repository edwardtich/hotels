<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'language' => 'ru-RU',
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['gii','debug'],
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['*']
        ],
        'debug' => [
            'class' => 'yii\debug\Module',
            'allowedIPs' => ['*']
        ],

        'rbac' => 'dektrium\rbac\RbacWebModule',

        'user' => [
            // following line will restrict access to admin page
            //'as backend' => 'dektrium\user\filters\BackendFilter',
            'class' => 'dektrium\user\Module',
            'enableRegistration'=>false,
            'enableFlashMessages' => false,
            //'enableGeneratingPassword' => true, // автоматически создавть пароль при регистраиции и отправлять на почту
            'enableConfirmation' => false,// подтверждение регистрации
            //'enableUnconfirmedLogin' => true, // разрешена авторизация без подтверждения учетной записи
            'enablePasswordRecovery' => false, // восстановление паролей
            'admins' => ['diir2015'],
        ],
    ],
    'components' => [
//        'user' => [
//            'identityCookie' => [
//                'name'     => '_backendIdentity',
//                'path'     => '/',
//                'httpOnly' => true,
//            ],
//        ],
//        'session' => [
//            'name' => 'BACKENDSESSID',
//            'cookieParams' => [
//                'httpOnly' => true,
//                'path'     => '/',
//            ],
//        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
    'container' => require(__DIR__ . '/container.php'),
];
