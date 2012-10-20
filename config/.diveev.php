<?php
return array(
    'name'=>'Diveev Environment',

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
              'enableProfiling' => true,
        ),

        'shard0' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=stalker_shard1',
            'username' => 'root',
            'password' => '757228',
            'autoConnect' => false,
            'charset' => 'utf8',
        ),
        'shard1' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=stalker_shard2',
            'username' => 'root',
            'password' => '757228',
            'autoConnect' => false,
            'charset' => 'utf8',
        ),

        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CProfileLogRoute',
                    'levels'=>'profile',
                    'enabled'=>false,
                ),
            ),
        ),

        'RediskaConnection'=>array(
            'class'=>'application.components.RediskaConnection',
            'options'=>array(
                'servers' => array(
                    'server1' => array(
                        'host'=>'127.0.0.1',
                        'port'=>'6379',
                        'timeout'=>'3', // in seconds
                        'readTimeout'=>'3', // in seconds
                    ),
                ),
                'serializerAdapter'=>'json',
            ),
        ),
    ),

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params'=>require(__DIR__.'/params.php'),
);