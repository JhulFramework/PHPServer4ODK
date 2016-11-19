<?php namespace Jhul\Components\Database\Adapter\PG\Statement\Traits;

trait Parameterized
{
	protected $_values;

	function bindValue( $name, $value )
	{
		$this->_values[ ':'.$name ] = $value ;
		return $this;
	}

	function bindValues( $values )
	{
		foreach ($values as $name => $value)
		{
			$this->bindValue( $name, $value );
		}

		return $this;
	}

	function showValues()
	{
		$string = '[';

		foreach ( $this->values() as $key => $value )
		{
			$string .= $key.'='.$value.'|';
		}

		return  trim( $string, '|' ) .']';
	}

	function values()
	{
		return $this->_values;
	}

	
}
