<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    //'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    // JLCR: Añadir los módulos'
    'modules' => [
        'v1' => [
            'class' => 'app\modules\v1\Module',
        ],
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'OCZuuHL-tBFPrNGr102L1GHW5HP7B-SS',
            // JLCR: Para admitir json como entrada de la API
            'parsers' => [
                'application/json' => 'yii\web\JsonParser', 
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => false,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => $db,
        // JLCR: Configurar las urls para la API
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 
                 'controller' => 'v1/alergeno',
               ],
               ['class' => 'yii\rest\UrlRule', 
                 'controller' => 'v1/ingrediente',
                 'extraPatterns' => [
                    '{id}/alergenos' => 'mod-alergenos', //de IngredienteController
                    /*
                    'PUT,PATCH ingredientes/<id>' => 'ingrediente/update',
                    'DELETE ingredientes/<id>' => 'ingrediente/delete',
                    'GET,HEAD ingredientes/<id>' => 'ingrediente/view',
                    'POST ingredientes' => 'ingrediente/create',
                    'GET,HEAD ingredientes' => 'ingrediente/index',
                    'ingredientes/<id>' => 'ingrediente/options',
                    'ingredientes' => 'ingrediente/options',
                    */
                   ]
               ],
               ['class' => 'yii\rest\UrlRule', 
                 'controller' => 'v1/plato',
                 'extraPatterns' => [
                    '{id}/ingredientes' => 'mod-ingredientes', //de PlatoController
                    /*
                    'PUT,PATCH platos/<id>' => 'plato/update',
                    'DELETE platos/<id>' => 'plato/delete',
                    'GET,HEAD platos/<id>' => 'plato/view',
                    'POST platos' => 'plato/create',
                    'GET,HEAD platos' => 'plato/index',
                    'platos/<id>' => 'plato/options',
                    'platos' => 'plato/options',
                    */
                   ]
               ],
            ],
        ],
        // JLCR: Configurar la respuesta de la API a json
        'response' => [
            'formatters' => [
                \yii\web\Response::FORMAT_JSON => [
                    'class' => 'yii\web\JsonResponseFormatter',
                    'prettyPrint' => YII_DEBUG, // use "pretty" output in debug mode
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
        ],

    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
