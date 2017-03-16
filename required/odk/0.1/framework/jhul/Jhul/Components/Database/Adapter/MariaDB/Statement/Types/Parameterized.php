<?php namespace Jhul\Components\Database\Adapter\MariaDB\Statement\Types;

class Parameterized extends _Abstract
{

	use Jhul\Components\Database\Adapter\MariaDB\Statement\Traits\Where;

	protected $_p;

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
