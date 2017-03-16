<?php namespace Jhul\Core\Design\Entity\_Trait;

/* @Author : Manish Dhruw [ eskylite@gmail ]
+=======================================================================================================================
| Trait for objects which needs
+---------------------------------------------------------------------------------------------------------------------*/

trait Configurable
{
	private $_config = [];

	public function get( $key, $if_required = TRUE )
	{
		if( array_key_exists($key, $this->_config) ) return $this->_config[$key];

		if( $required ) throw new \Exception( 'Configuration "'.$key.'" is required for "'.static::class.'" ', 1);
	}


	public function add( $key, $value = NULL , $overwrite = TRUE )
	{
		if( is_array($key) )
		{
			foreach ( $key as $k => $v )
			{
				$this->add($k, $v, $overwrite);
			}

			return TRUE;
		}

		if( !isset( $this->_config[$key] ) || $overwrite )
		{
			$this->_config[$key] = $value;
		}

		return TRUE;
	}

	public function config()
	{
		return $this->_config;
	}
}
