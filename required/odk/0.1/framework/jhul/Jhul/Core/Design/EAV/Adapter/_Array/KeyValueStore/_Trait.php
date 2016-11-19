<?php namespace Jhul\Core\Design\EAV\Adapter\Array\KeyValueStore;

trait _Trait
{
	protected $_seperator = '|';

	protected $_map = NULL ;

	abstract public function inputData();

	protected function inflate()
	{
		$data = [];

		$pairs = explode( $this->_seperator, $this->inputData() );

		foreach ( $pairs as  $pair )
		{
			$p = explode( '=', $pair  );
			$data[$p[0]] = $p[1];
		}

		return $data;
	}

	public function __toString()
	{
		$pairs = [];

		foreach ($this->_map as $key => $value)
		{
			$pairs[] = $key.'='.$value;
		}

		return implode( $this->_seperator, $pairs );
	}

	public function getKey( $value )
	{
		return array_search( $value, $this->map() );
	}

	//by key
	public function hasKey( $key )
	{
		return isset( $this->map()[$key] );
	}

	public function hasValue( $value )
	{
		return NULL != $this->getKey($value);
	}

	public function add( $key, $value )
	{
		$this->map()[$key] = $value;
	}

	public function remove( $key )
	{
		if( $this->hasKey( $key ) )
		{
			unset( $this->map()[$key] );
		}
	}

	public function countItems()
	{
		return count( $this->map() );
	}

	public function getValue( $key )
	{
		return $this->map()[ $key ];
	}

}
