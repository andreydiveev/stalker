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
        ),
    ),
);