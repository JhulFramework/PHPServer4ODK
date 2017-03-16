<?php namespace Jhul\Components\Database\Store\Data;


class DataBag
{
	protected $_data = [];

	protected $_entity;

	public function __construct( $entity )
	{
		$this->_entity = $entity;
	}

	public function entity()
	{
		return $this->_entity;
	}

	public function keys()
	{
		return array_keys( $this->_data );
	}

	public function isEmpty() { return empty($this->_data) ; }

	public function write( $key, $value ){ $this->_data[$key] = $value; }

	public function read( $key )
	{
		return $this->_data[$key] ;
	}

	public function has( $key ) { return array_key_exists( $key, $this->_data ); }

	public function hasValue( $key ){ return !empty( $this->_data[$key] ); }

	//return deflated data
	public function _get() { return $this->_data; }

	public function _set( $key, $value = NULL )
	{
		if( is_array($key) )
		{
			foreach ( $key as $k => $v)
			{
				$this->_set($k, $v );
			}

			return;
		}

		$this->_data[$key] = $value;
	}
}
