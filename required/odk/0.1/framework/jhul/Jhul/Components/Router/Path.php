<?php namespace Jhul\Components\Router ;

/* @Author : Manish Dhruw [1D3N717Y12@gmail.com]
+=======================================================================================================================
| @Created : Sun 07 Feb 2016 06:45:57 PM IST
|
| Requested URI Node
|
+---------------------------------------------------------------------------------------------------------------------*/

class Path
{

	private $_pieces = [];

	private $_value = '' ;

	public function __construct( $path )
	{
		$this->_value = $path['V'];

		foreach ($path['P'] as $key => $P)
		{
			$this->_pieces[$key] = urlDecode($P);
		}

	}

	public function value()
	{
		return $this->_value;
	}

	public function last()
	{
		return end($this->_pieces);
	}

	public function get( $pointer )
	{
		if( isset( $this->_pieces[$pointer] ) )
		{
			return $this->_pieces[$pointer] ;
		}
	}

	public function __toString()
	{
		return $this->value();
	}

	public function map()
	{
		return $this->_pieces;
	}

	function getFrom( $fromIndex, $preserveKeys = TRUE )
	{
		return array_slice( $this->map(), $fromIndex, NULL, $preserveKeys );
	}
}
