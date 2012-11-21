<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
$config = array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

	// preloading 'log' component
	'preload'=>array('log'),
	
	'import'=>array(
		//'application.models.*',
		'ext.server.components.CustomException',
	),

	// application components
	'components'=>array(
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		/*
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=testdrive',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		*/
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
		
		'server' => array(
		    'class'=>'ext.server.Server',
		),
	),
);


if (defined('YII_ENVIRONMENT') && file_exists(dirname(__FILE__). '/.'.YII_ENVIRONMENT.'.php')){
    $custom = include(dirname(__FILE__). '/.'.YII_ENVIRONMENT.'.php');
    $config = CMap::mergeArray($config,$custom);
}
return $config;