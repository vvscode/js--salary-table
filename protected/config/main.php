<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Таблица ЗП',
    'theme'=>'bootstrap',
    'language'=>'ru',
    'sourceLanguage'=>'ru',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
        'api',
	),

	// application components
	'components'=>array(
        'clientScript' => array(
            'scriptMap' => array(
                'jquery.js' => false,
                'jquery.min.js' => false,
            )
        ),
		'user'=>array(
			'allowAutoLogin'=>true,
		),
        'bootstrap'=>array(
            'class'=>'bootstrap.components.Bootstrap',
        ),
		'urlManager'=>array(
			'urlFormat'=>'path',
            'showScriptName' => FALSE,
			'rules'=>array(
                ''=>'site',
                'login' => 'site/login',
                '<view:\w+>' => 'site/page',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                // REST
                'api/<controller:\w+>/<action:\w+>/<id:\d+>' => 'api/<controller>/<action>/id/<id>',
                array('api/<controller>/<action>', 'pattern'=>'api/<controller:\w+>/<action:\w+>', 'verb'=>'PUT,GET,POST,DELETE'),

			),
		),
        'db'=> require(dirname(__FILE__).DIRECTORY_SEPARATOR.'db_conf.php'),
		'errorHandler'=>array(
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		'defaultRoute' => array('/workers/')
	),
);