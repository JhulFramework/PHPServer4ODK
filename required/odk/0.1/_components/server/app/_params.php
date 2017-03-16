<?php

$config = require( JHUL_REQUIRED_DIR.'/_config.php' );

$c =
[


	'url_map'		=> __DIR__.'/_urlmap.php',

	'public_js_dir'	=> 'resources/js',

	'public_css_dir'	=> 'resources/css',

	'public_image_dir' => 'resources/images',


	'charSet'		=> 'UTF-8',

	//default languageCode
	//https://en.wikipedia.org/wiki/ISO_639-3
	'language'		=> 'eng',

	'defaultActivity'	=> 'index',


	//which database to use from database configuration file
	'database' => 'default',

	'session_key_prefix'	=> '_._odk_',
];

return array_merge( $c, $config );
