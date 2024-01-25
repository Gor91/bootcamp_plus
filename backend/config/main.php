<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'bootcamp-backend',
    'name' => 'Bootcamp Dashboard',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'defaultRoute' => 'admin/index',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend-bootcamp',
        ],
        'user' => [
            'identityClass' => 'backend\models\Admin',
            'enableAutoLogin' => true,
            'loginUrl' => ['admin/login']
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'bootcamp-backend',
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
            'errorAction' => 'admin/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'login' => 'admin/login',
                'logout' => 'admin/logout',
                'profile' => 'admin/profile',
                'settings' => 'admin/settings',
                'change-password' => 'admin/change-password',
                'dashboard' => 'admin/index',
                'gallery/<id:\d+>/order' => 'gallery/order'
            ]
        ]
    ],
    'params' => $params,
];
