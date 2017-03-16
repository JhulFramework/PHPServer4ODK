<?php return
[

	'class' => '\\app\\App',

	'init' => function( $app, $params )
	{

		//loading Sesson
		$app->s( 'session', new \Jhul\Core\Application\Session( $app->config( 'session_key_prefix' ) ) ) ;

		//loading user
		$app->s( 'user', new \app\User( $params['url'] ) );

		//registering resources
		$app->configLoader()->mapResources( $app->path() );

		//registering pages
		$app->configLoader()->registerPages( $app->path() );

		//registering Handlers
		$app->configLoader()->registerHandlers( $app->path() );


		//registering modules
		$app->s
		(
			'moduleStore',

			new \Jhul\Core\Application\Module\Store
			(
				\Jhul::I()->fx()->loadConfigFile(  $app->path().'/_config/_modules' )
			)
		);


		return $app;
	},
];
