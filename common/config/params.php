<?php
return [
    'contentRedactor' => [
        'url' => '/upload/contentRedactor',
        'path' => '@frontend/web/upload/contentRedactor',
    ],
    'content' => [
        'preview' => [
            'dir' => '@frontend/web/upload/content/',
            'urlDir' => '/upload/content/',
            'defaultCrop' => [100, 100],
            'crop' => [
                [80, 80, 'q', 'fit'],
                [400, 0, 'min', 'fit'],
                [1200, 0, 'max', 'fit'],
            ]
        ],
        'logo' => [
            'dir' => '@frontend/web/upload/logo/',
            'urlDir' => '/upload/logo/',
            'defaultCrop' => [100, 75],
            'crop' => [
                [80, 80, 'q', 'fit'],
                [400, 0, 'min', 'fit'],
                [1200, 0, 'max', 'fit'],
            ]
        ],
        'pagination' => 10
    ],
    'catContent' => [
        'preview' => [
            'dir' => '@frontend/web/upload/cat_content/',
            'urlDir' => '/upload/cat_content/',
            'defaultCrop' => [100, 75],
            'crop' => [
                [400, 576, 'min', 'fit'],
                [1200, 0, 'max', 'widen'],
            ]
        ]
    ],
    'runtimeWidgets' => [
        'frontend\widgets\contentBlock\ContentBlock',
        'frontend\widgets\noomerFond\NumberWidget',
        'frontend\widgets\content\ContentWidget',
        'frontend\widgets\photoSlider\PhotoSlider',
//        'common\widgets\unitegallery\UnitePhotoGallery',
        'frontend\widgets\forms\feedback\FeedbackWidget',
    ],
    'gallery' => [
        'dir' => '@frontend/web/upload/gallery/',
        'urlDir' => '/upload/gallery/',
        'default' => ['w' => 100, 'h' => 75, 'type' => 'fit'],
        'min' => ['w' => 1000, 'h' => 570, 'type' => 'fit'],
        'max' => ['w' => 1440, 'h' => 900, 'type' => 'widen']
    ],
];
