<?php return
[

	'class' => '\\app\\App',


	'init' => function( $app, $params )
	{




		$app->s( 'route', \Jhul::I()->cx('router')->match( \Jhul::I()->cx( 'http' )->Q()->path() ) );

		$app->s
		(
			'endUser',

			\Jhul\Core\Application\EndUser\EndUser::make
			(
				\Jhul::I()->cx( 'http' )->Q()->clientRequestedDataFormat()
			)
		);

		if( $app->endUser()->ifConsumes('json') )
		{
			$app->s( 'outputAdapter', new \Jhul\Core\Application\OutputAdapters\JSON\JSON );
		}
		else //its a webpage
		{
			$app->s( 'outputAdapter', new \Jhul\Core\Application\OutputAdapters\WebPage\WebPage );

			$app->outputAdapter()->mStyle()->embed('main');
		}



		$app->configLoader()->load( $app );


		$app->s
		(
			'moduleStore',

			new \Jhul\Core\Application\Module\Store
			(
				\Jhul::I()->fx()->loadConfigFile( 'app\\config\\_modules', FALSE )
			)
		);


		return $app;
	},
];
