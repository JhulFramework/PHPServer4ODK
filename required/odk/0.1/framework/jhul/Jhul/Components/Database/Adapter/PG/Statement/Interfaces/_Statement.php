<?php namespace Jhul\Components\Database\Adapter\PG\Statement\Interfaces;

interface _Statement
{
	//function readDBEntity( $DBEntity );
	function make();
	function values();
}
