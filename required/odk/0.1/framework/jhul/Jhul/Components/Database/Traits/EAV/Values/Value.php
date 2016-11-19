<?php namespace Jhul\Components\Database\Traits\EAV\Values;

trait Value
{
	protected $_name;
	protected $_entity;

	function __construct( $name, $entity )
	{
		$this->_name = $name;
		$this->_entity = $entity;
	}

	function name()
	{
		return $this->_name;
	}

	function value()
	{
		return $this->entity()->read( $this->name(), TRUE );
	}

	function entity()
	{
		return $this->_entity;
	}

	function __toString()
	{
		return $this->value();
	}
}
