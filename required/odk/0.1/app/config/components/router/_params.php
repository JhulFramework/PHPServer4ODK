<?php return
[
	'routes' =>
	[
		':index'					=> 'main:index',

		'data'					=>'main:data',

		'formList'					=> 'main:form_list',

		'submission'				=> 'main:form_submit',

		'login'					=> 'user:login',

		'logout'					=> 'user:logout',

		'manage_forms'				=> 'user:manage_forms',

		'xform'					=> 'main:xform',

		'change_password'				=> 'user:change_password',
	],
];
