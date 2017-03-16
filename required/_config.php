<?php return
[
	//SERVER URL
	'url'			=> '',

	// Relative directory where forms will be uplaoded by admin
	'xform_dir'		=> 'uploads/xforms',

	//WEBSITE NAME
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



		'adapter'	=> 'mysql',

		'host'	=> 'localhost',

		'pdoConf' 	=>
		[
			'emulatePrepare' => TRUE
		],

	],


];
