<?php namespace Jhul\Core\Application\DataType\_Attribute;

interface _Interface
{
	//returns value object if value is valid
	public function filter( $value );

	//return Error Code Manager
	public function mErrorCode();

	//retursn value entity object
	public function make( $value );

	public function type();
}
