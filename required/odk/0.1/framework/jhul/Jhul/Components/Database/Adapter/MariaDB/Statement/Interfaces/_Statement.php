<?php namespace Jhul\Components\Database\Adapter\MariaDB\Statement\Interfaces;

interface _Statement
{
	//function readDBEntity( $DBEntity );
	function make();
	function values();
}
