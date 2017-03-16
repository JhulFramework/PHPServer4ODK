<?php namespace Jhul\Components\Database\Traits\Values\SimpleArray;

//Used to read imploded array values

trait Read
{
	protected $_simpleArrayValues = [];

	protected $_arrayValuesSeperator = '|';

	// @Override
	// Read Array Value
	function _r( $field, $onFail = FALSE)
	{
		$value = $this->_r( $field );

		if( in_array( $field, $this->linearArrayFields() ) )
		{
			if( isset( $this->_simpleArrayValuess[$field] ) )
			{
				return $this->_simpleArrayValuess[$field];
			}

			return $this->_simpleArrayValuess[$field] = explode( $this->_arrayValuesSeperator, $value );
		}

		return $value;
	}

	// @Override
	// Sets values directly
	function writeArrayValue( $field, $value )
	{
		if( in_array( $field, $this->linearArrayFields() ) )
		{
			$value = implode( $this->_arrayValuesSeperator, $value );

			//since value is changed , we need to resync the loaded value

			if( isset($this->_simpleArrayValuess[$field]) )
			{
				unset( $this->_simpleArrayValuess[$field] );
			}
		}

		return parent::_w( $field, $value );
	}

	abstract function linearArrayFields();
}
