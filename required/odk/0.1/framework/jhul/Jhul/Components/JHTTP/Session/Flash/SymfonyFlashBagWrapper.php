<?php namespace Jhul\Components\JHTTP\Session\Flash;

//TODO Use better Session and Flash

class SymfonyFlashBagWrapper
{
	protected $_bag;

	public function __construct( $bag )
	{
		$this->_bag = $bag ;
	}

	public function has( $key )
	{
		return $this->_bag->has($key);
	}

	public function get( $key )
	{
		$value = $this->_bag->get($key);

		if( !empty($value)  )
		{
			return $value[0];
		}
	}

	public function set( $key, $value )
	{
		return $this->_bag->set($key, $value);
	}
}
