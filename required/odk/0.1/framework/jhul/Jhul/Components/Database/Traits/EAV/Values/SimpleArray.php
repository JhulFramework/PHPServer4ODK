<?php namespace Jhul\Components\Database\Traits\EAV\Values;

trait SimpleArray
{
	use Base;

	protected $_name;

	protected $_entity;

	protected $_simpleArraySeperator = '|';

	protected $_asArray = [];

	function __construct( $name, $entity )
	{
		$this->_name = $name;

		$this->_entity = $entity;

		$thia->_asArray = explode( $this->_simpleArraySeperator, $this->raw() );
	}

	function name()
	{
		return $this->_name;
	}

	function raw()
	{
		return $this->entity()->_r( $this->name() );
	}

	function entity()
	{
		return $this->_entity;
	}

	function asString()
	{
		return implode(  )
	}
}
