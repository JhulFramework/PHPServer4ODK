<?php namespace Jhul\Components\Application\Module;

/* @Author : Manish Dhruw
+=======================================================================================================================
| @Created : 7-Oct-2015 | Module Attribut whix can have value |
+-----------------------+-------------------------------------+
|
| @Updated :
| 2016-July-23
+---------------------------------------------------------------------------------------------------------------------*/

use \Jhul\Core\Design\Attribute\Definition;

abstract class _AttributeElement
{

      use \Jhul\Components\Application\Traits\Module_Access;

	use \Jhul\Core\Design\Entity\Traits\Configurable;


	protected $_definition;

	abstract public function entityClass();


	public function definition()
	{
		if( empty($this->definition) )
		{
			$this->_definition = new Definition( $this->g('definition') );
		}

		return $this->_definition;
	}

	function make( $value )
	{
		$class = $this->entityClass();
		return new $class( $value );
	}
}
