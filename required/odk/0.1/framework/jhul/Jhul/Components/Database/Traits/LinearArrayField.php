<?php namespace Jhul\Components\Database\Traits;

trait LinearArrayField
{
	protected $_linearArrayFields = [];

	protected $_arrayValuesSeperator = '|';

	// @Override
	// Read Array Value
	function readArrayValue( $field, $onFail = FALSE)
	{
		$value = $this->r( $field );

		if( in_array( $field, $this->linearArrayFields() ) )
		{
			if( isset( $this->_linearArrayFields[$field] ) )
			{
				return $this->_linearArrayFields[$field];
			}

			return $this->_linearArrayFields[$field] = explode( $this->_arrayValuesSeperator, $value );
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

			if( isset($this->_linearArrayFields[$field]) )
			{
				unset( $this->_linearArrayFields[$field] );
			}
		}

		return parent::_w( $field, $value );
	}

	abstract function linearArrayFields();
}
