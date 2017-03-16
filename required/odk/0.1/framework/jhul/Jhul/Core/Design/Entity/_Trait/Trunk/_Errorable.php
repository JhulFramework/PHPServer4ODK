<?php namespace Jhul\Core\Design\Trunk\Traits;

/* @Author: Manish Dhruw
======================================================================================================================
| @Created : 2016-July-23
| Trunk having multiple errorable entities
----------------------------------------------------------------------------------------------------------------------*/
trait _Errorable
{
	protected $_attributeEntities = [];

	function hasError()
	{
		foreach ($$this->_attributeEntities as $attributes)
		{
			# code...
		}
	}

	function error( $name )
	{
		$this->_attributeEntities[$name]->error();
	}

	protected $_errors = [];

	function errors( $name = NULL )
	{
		if( !empty($name) )
		{
			$this->_attributeEntities[$name]->errors();
		}
	}
}
