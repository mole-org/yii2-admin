<?php
$config = [
    'id' => 'Admin',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'system',
        'log',
        [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'text/html' => \yii\web\Response::FORMAT_HTML,
                'text/grid' => \yii\web\Response::FORMAT_HTML,
                'application/json' => \yii\web\Response::FORMAT_JSON
            ]
        ],
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'NHsZuT6XkMOBYIzh2iKcl9hWbiPfVur5',
            'enableCsrfValidation' => false,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\helpers\UserIdentity',
            'enableAutoLogin' => false,
        ],
        'errorHandler' => [
//             'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'system' => 'app\helpers\System',
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'except' => ['yii\web\HttpException*'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<action:(login|logout|about|phpinfo|test)>' => 'site/<action>'
            ]
        ],
        'assetManager' => [
            'class' => 'app\helpers\AssetManager',
            'isPublish' => false,
            'bundles' => [
                'yii\web\JqueryAsset' => false,
                'yii\web\YiiAsset' => false,
                'yii\grid\GridViewAsset' => false,
                'yii\widgets\ActiveFormAsset' => false,
                'yii\validators\ValidationAsset' => false
            ]
        ],
        'menu' => [
            'class' => 'app\helpers\Menu'
        ]
    ],
    'params' => require(__DIR__ . '/params.php'),
    'name' => '后台管理系统',
    'language' => 'zh-CN',
    'aliases' => [
        '@assertUrl' => 'http://assert.mole.com'
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '192.*', '10.*'],
        'historySize' => 30,
        'on beforeAction' => function($event) {
            Yii::$app->getResponse()->format = 'html';
        }
    ];

    $config['on beforeAction'] = function($event) {
        Yii::$app->getView()->off('endBody', [\yii\debug\Module::getInstance(), 'renderToolbar']);
    };

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'newFileMode' => 0644,
        'newDirMode' => 0755,
        'generators' => [
            'model' => [
                'class' => 'app\helpers\gii\model\Generator',
                'ns' => 'app\models',
                'useTablePrefix' => true,
                'generateLabelsFromComments' => true,
                'enableI18N' => false,
                'template' => 'base',
                'templates' => [
                    'base' => '@app/helpers/gii/model/base'
                ]
            ],
            'crud' => [
                'class' => 'yii\gii\generators\crud\Generator',
                'baseControllerClass' => 'app\helpers\Controller',
                'template' => 'base',
                'templates' => [
                    'base' => '@app/helpers/gii/crud/base'
                ]
            ]
        ]
    ];

    function _debug($var, $tags = null)
    {
        if (PhpConsole\Connector::getInstance()->isActiveClient()) {
            PhpConsole\Connector::getInstance()->getDebugDispatcher()->dispatchDebug($var, $tags, 1);
        }
    }
} else {
    function _debug($var, $tags = null)
    {
        // nothing
    }
}

return $config;
