<?php
$dbSettings = require(dirname(__FILE__).DIRECTORY_SEPARATOR.'db_conf.php');
if(!isset($dbSettings['tablePrefix'])){
    $dbSettings['tablePrefix'] = "";
};

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

	// preloading 'log' component
	'preload'=>array('log'),

	// application components
	'components'=>array(
        'db'=> $dbSettings,
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
    // Command Map
    'commandMap'=>array(
        'migrate'=>array(
            'class'=>'system.cli.commands.MigrateCommand',
            'migrationPath'=>'application.migrations',
            'migrationTable'=>$dbSettings['tablePrefix'].'migration',
            'connectionID'=>'db',
            'templateFile'=>'application.migrations.template',
        ),
    ),
);