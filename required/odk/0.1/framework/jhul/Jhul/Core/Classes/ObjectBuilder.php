<?php namespace Jhul\Core\Classes;

/* @Author : Manish Dhruw [eskylite@gamil.com]
+=====================================================================================================================+=
| @Created : Tue 05 Apr 2016 05:27:33 PM IST
+---------------------------------------------------------------------------------------------------------------------*/


abstract class ObjectBuilder
{
	protected $_object;

	public function __construct( $object, $configurations = [] )
	{
		$this->_object = $object;

		$this->_configurations = $configurations;
	}

	public static function I( $object, $configurations = [] )
	{
		return new static( $object, $configurations );
	}

	abstract protected function build();

	public function O()
	{
		return $this->_object;
	}

	public function C()
	{
		return $this->_configurations;
	}
}
