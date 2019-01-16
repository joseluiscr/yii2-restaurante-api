<?php
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/test_db.php';

/**
 * Application configuration shared by all test types
 */
return [
    'id' => 'basic-tests',
    'basePath' => dirname(__DIR__),
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
    'language' => 'en-US',
    'components' => [
        'db' => $db,
        'mailer' => [
            'useFileTransport' => true,
        ],
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
        ],
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
            // but if you absolutely need it set cookie domain to localhost
            /*
            'csrfCookie' => [
                'domain' => 'localhost',
            ],
            */
        ],
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
