<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'api\models\User',
            'enableAutoLogin' => true,
            'enableSession'=>false,
//            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
//        'session' => [
//            // this is the name of the session cookie used for login on the backend
//            'name' => 'advanced-backend',
//        ],
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                /**
                 * RESTful 风格的API
                 * GET /users: 逐页列出所有用户
                 * HEAD /users: 显示用户列表的概要信息
                 * POST /users: 创建一个新用户
                 * GET /users/123: 返回用户 123 的详细信息
                 * HEAD /users/123: 显示用户 123 的概述信息
                 * PATCH /users/123: and PUT /users/123: 更新用户123
                 * DELETE /users/123: 删除用户123
                 * OPTIONS /users: 显示关于末端 /users 支持的动词
                 * OPTIONS /users/123: 显示有关末端 /users/123 支持的动词
                 **/
                ['class' => 'yii\rest\UrlRule',
                    'controller' => 'user',
                    //'pluralize' => false,    //设置为false 就可以去掉复数形式了
                    'extraPatterns'=>[
                        'GET send-email'=>'send-email',
                        'POST login'=>'login',
                    ],
                ],
            ],
        ],
        'response' => [
            'class' => 'yii\web\Response',
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                $response->data = [
                    'success' => $response->isSuccessful,
                    'code' => $response->getStatusCode(),
                    'message' => $response->statusText,
                    'data' => $response->data,
                ];
                $response->statusCode = 200;
            },
        ],
    ],
    'params' => $params,
];
