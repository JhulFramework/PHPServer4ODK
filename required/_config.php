<?php return
[
	// SERVER URL with http
	// example : http://myserver.com or https://myserver.com
	'url'			=> '',

	// Relative to public_html directory( or www or htdocs ) where xml forms will be uploadded by admin
	// example : public_html/upload/xforms
	// this ditrectory MUST EXIST
	'xform_dir'		=> 'uploads/xforms',

	//Name it whatever you want
	'name'		=> 'ODK Server',


	//Database configuration
	'database' =>
	[
		//database name
		'name' 	=> '',

		//database user name
		'username'	=> '',

		//database password
		'password'	=> '',


		// DONT CHANGE below configurations
		'adapter'	=> 'mysql',

		'host'	=> 'localhost',

		'pdoConf' 	=>
		[
			'emulatePrepare' => TRUE
		],

	],


];
