<?php
return array(
    'name'=>'Diveev Environment',

    //'onBeginRequest' => array('SessionHelper', 'initSession'),

    'components'=>array(
        'user'=>array(
            // enable cookie-based authentication
            'allowAutoLogin'=>true,
        ),
        'db'=>array(
              'connectionString' => 'mysql:host=localhost;dbname=stalker',
              'emulatePrepare' => true,
              'username' => 'root',
              'password' => '757228',
              'charset' => 'utf8',
        ),

        'urlManager'=>array(
            'urlFormat'=>'path',
            'showScriptName'=>false,
            'rules'=>array(
                'bot/voensklad.php' => 'bot/svalka',
                'bot/kordon.php' => 'bot/svalka',
                'bot/base.php' => 'bot/svalka',
                'bot/svalka.php' => 'bot/svalka',
                'bot/zona.php' => 'bot/svalka',
                'bot/reg.php' => 'bot/svalka',
                'bot/index.php' => 'bot/svalka',
                'bot/agroprom.php' => 'bot/svalka',
                'bot/yantar.php' => 'bot/svalka',

                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ),
        ),
        /*'components' => array(
            'session' => array(
                'cookieMode' => 'allow',
                'cookieParams' => array(
                    'domain' => 'site.ru',
                    'httponly' => true,
                ),
            ),
        ),*/

        /*'CURL' =>array(
            'class' => 'application.extensions.gCurl.gCurl.class',
            //you can setup timeout,http_login,proxy,proxylogin,cookie, and setOPTIONS
        ),*/
    ),
);