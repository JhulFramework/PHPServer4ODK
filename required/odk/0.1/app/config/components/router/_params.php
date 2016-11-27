<?php return
[
	'routes' =>
	[
		':index'					=> 'main:index',

		'data'					=>'main:data',

		'formList'					=> 'main:form_list',

		'form_list'					=> 'main:form_list',

		'form_submit'				=> 'main:form_submit',

		'submission'				=> 'main:form_submit',


		'login'					=> 'user:login',

		'logout'					=> 'user:logout',

		'manage_forms'				=> 'user:manage_forms',

		'download'					=> 'main:form_download',

		'change_password'				=> 'user:change_password',
	],
];
