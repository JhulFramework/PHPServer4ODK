<?php namespace Jhul\Components\Database\Adapter\PG\Statement;

return
[
	'create'		=> __NAMESPACE__.'\\Types\\Create',

	'delete'		=> __NAMESPACE__.'\\Types\\Delete',

	'select'		=> __NAMESPACE__.'\\Types\\Select',

	'update'		=> __NAMESPACE__.'\\Types\\Update',

	'custom'		=> __NAMESPACE__.'\\Types\\Custom',

	'show_columns' => __NAMESPACE__.'\\Types\\ShowColumns',

	'insert'		=> __NAMESPACE__.'\\Types\\Insert',
];
