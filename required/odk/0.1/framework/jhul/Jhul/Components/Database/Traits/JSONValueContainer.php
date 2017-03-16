<?php namespace Jhul\Components\Database\Traits;

trait JSONValueContainer
{
	//protected $_JSONDecodedValues = [];

	// Sets values directly
	function _set( $field, $value )
	{
		if( in_array( $field, $this->JSONDataFields() ) )
		{
			$value = json_encode($value);
		}

		return parent::_set( $field, $value );
	}


	abstract function JSONDataFields();
}
