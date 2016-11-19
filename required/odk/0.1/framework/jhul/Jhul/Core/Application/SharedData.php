<?php namespace Jhul\Core\Application;

/* @Author : Manish Dhruw [1D3N717Y12@gmail.com]
+=======================================================================================================================
| @Created : Sun 07 Feb 2016 05:49:54 PM IST
+---------------------------------------------------------------------------------------------------------------------*/

class SharedData
{

	use \JHul\Core\_AccessKey;

	//Internally saved data for sharing between nodes
	private $_safe = [];

	public function safe()
	{
		return $this->_safe;
	}

	//@Param [string] $argKey (KEY) = whose value( DATA ) is requested
	//@Param [string] $type (TYPE of DATA) = type of the raw value for validation
	//@Param [array] $rules (FILTERS) = addition validation boundaries for value( e.g. length limit)
	public function loadFromURI( $argKey )
	{
		if( isset( $this->safe[$argKey] ) )
		{
			return $this->safe[$argKey] ;
		}

		return $this->_safe[$argKey] = $this->getApp()->route()->getData( $argKey );
	}

	public function get( $key )
	{
		if( isset( $this->_safe[$key] ) )
		{
			return $this->_safe[$key];
		}
	}

	public function add( $key, $value )
	{
		if( !isset( $this->_safe[$key] ) )
		{
			return $this->_safe[$key] = $value;
		}
	}

	public function map()
	{
		return $this->safe();
	}
}
