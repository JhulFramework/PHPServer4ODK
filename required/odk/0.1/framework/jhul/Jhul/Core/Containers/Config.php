<?php namespace Jhul\Core\Containers;

//Data Container
class Config
{
	protected $_values = [];

	public function add( $key, $value = NULL, $overwrite = TRUE )
	{
		if( is_array($key) )
		{
			foreach ( $key as $k => $v )
			{
				$this->add( $k, $v );
			}

		}
		else if( empty( $this->_values[$key] ) || $overwrite )
		{
			$this->_values[$key] = $value;
		}
	}

	public function get( $key, $ifRequired = TRUE )
	{
		if( array_key_exists($key, $this->_values) ) return $this->_values[$key];

		if( $ifRequired ) throw new \Exception( 'Configuration "'.$key.'" is required ', 1);
	}

	public function has( $key )
	{
		return array_key_exists( $key, $this->_values );
	}
}
