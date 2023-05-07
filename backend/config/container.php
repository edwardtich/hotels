<?php

return [
    'definitions' => [
        'yii\grid\GridView' => [
            'tableOptions' => ['class' => 'table table-striped'],
            'layout' => '{items}{summary}{pager}',
        ],
    ],
    'singletons' => [
        // Dependency Injection Container singletons configuration
    ]
];