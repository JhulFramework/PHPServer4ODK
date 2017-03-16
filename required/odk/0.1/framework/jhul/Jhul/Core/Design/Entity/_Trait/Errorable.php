<?php namespace Jhul\Core\Design\Entity\_Trait;

trait Errorable
{
	protected $_errors = [];

	function error()
	{
		if( isset($this->_erros[0]) )
		{
			return $this->_errors[0];
		}
	}

	function errors()
	{
		return $this->_errors;
	}

	function addError( $error )
	{
		return $this->_errors[] = $error;
	}

	function isValid()
	{
		return empty( $this->_errors );
	}
}
