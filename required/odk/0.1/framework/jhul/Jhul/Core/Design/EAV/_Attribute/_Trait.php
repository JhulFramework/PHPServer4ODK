<?php namespace Jhul\Core\Design\EAV\_Attribute;

trait _Trait
{

	protected $_entity;

	protected $_name;

	protected $_value;

	public function __construct( $name, $entity )
	{
		$this->_name = $name;
		$this->_entity = $entity;
	}

	public function name()
	{
		return $this->_name;
	}

	public function entity()
	{
		return $this->_entity;
	}

}
