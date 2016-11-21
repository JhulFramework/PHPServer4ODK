<?php return
[
	'connections'	=>
	[
		'default' =>
		[
			'adapter'	=> 'mysql', //Dont change it

			'host'	=> 'localhost',

			'name' 	=> 'Your Database Name',

			'username'	=> 'database user name',

			'password'	=> 'database password',

			'pdoConf' 	=>
			[
				'emulatePrepare' => TRUE
			],
		],
	]


];
