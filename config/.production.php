<?php
return array(
    'name'=>'Stalker Wars Environment',

    'components'=>array(
        'user'=>array(
            // enable cookie-based authentication
            'allowAutoLogin'=>true,
        ),
        'db'=>array(
              'connectionString' => 'mysql:host=localhost;dbname=schemata_stlk',
              'emulatePrepare' => true,
              'username' => 'root',
              'password' => '9onZpG2h',
              'charset' => 'utf8',
        ),
    ),
);