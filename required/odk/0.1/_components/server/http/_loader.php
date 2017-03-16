<?php return
[
	'class'	=> '\\Jhul\\Components\\JHTTP\\JHTTP',

	'create'	=> function( $http, $params )
	{
		$http->config()->add( $params );

		return $http;
	},

	'init'	=> function( $http )
	{

		$http->_s( 'Q', new \Jhul\Components\JHTTP\Request );

		$http->_s( 'R', new \Jhul\Components\JHTTP\Response );

		return $http;
	},
];
