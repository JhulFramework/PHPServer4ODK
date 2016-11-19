<?php

require( dirname(__DIR__).'/Adapter_Session.php');

$t = new mwapp\components\mhttp\session\Adapter_Session;

$t->start();

$t->set( 'd', 'm' );

echo '<pre>'.__FILE__;
var_dump($_SESSION);
echo'</pre>';

