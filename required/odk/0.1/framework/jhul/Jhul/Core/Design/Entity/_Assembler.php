<?php namespace Jhul\Core\Design\Entity;

abstract class _Assembler
{

	use \Jhul\Core\_AccessKey;

	protected $_object;

	public function __construct( $component, $configurations = [] )
	{
		$this->_object = $component;

		$this->_configurations = $configurations;
	}

	public static function I( $component, $configurations = [] )
	{
		return new static( $component, $configurations );
	}
	abstract protected function assemble();

	public function e()
	{
		return $this->_object;
	}

	public function c()
	{
		return $this->_configurations;
	}


}
