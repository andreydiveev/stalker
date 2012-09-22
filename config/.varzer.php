<?php
return array(
    'name'=>'Varzer Environment',


    'components'=>array(
        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=stalker',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '12345678',
            'charset' => 'utf8',
        ),
    ),
);