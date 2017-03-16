<?php namespace Jhul\Core\Classes;

/* @Author : Manish Dhrue [eskylite@gamil.com]
+=====================================================================================================================+=
| @Created : Tue 05 Apr 2016 05:18:15 PM IST
+---------------------------------------------------------------------------------------------------------------------*/

abstract class ConfigurableComponent implements \Jhul\Core\Interfaces\Component
{
	public static function I( $params = NULL , $configurations = [] )
	{
		return new static( $params );
	}

	//@return class of Object which will build this object
	abstract function builderClass();
}
