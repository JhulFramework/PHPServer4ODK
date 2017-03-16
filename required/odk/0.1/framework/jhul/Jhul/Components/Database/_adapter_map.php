<?php

$namespace = '\\Jhul\\Components\\Database';

return
[
	'mysql' => $namespace.'\\Adapter\\MariaDB\\MariaDB',
	'pgsql' => $namespace.'\\Adapter\\PG\\PG',
];
