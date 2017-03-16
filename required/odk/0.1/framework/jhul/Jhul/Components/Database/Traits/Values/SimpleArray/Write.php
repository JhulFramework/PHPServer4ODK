<?php namespace Jhul\Components\Database\Traits\Values\SimpleArray;

trait Write
{
	use Read;
	use \Jhul\Components\Database\Traits\Write_Access;

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
