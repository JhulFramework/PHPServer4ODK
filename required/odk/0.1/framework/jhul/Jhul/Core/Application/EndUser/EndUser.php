<?php namespace Jhul\Core\Application\EndUser;

class EndUser
{

	protected $_adapter;

	protected $_adapters = [];

	protected static $_I;

	private function __construct()
	{
		$this->_adapters = require(__DIR__.'/_adapters.php');
	}

	protected function makeAdapter( $adapter )
	{
		$adapter = strtolower( $adapter );

		if( isset( $this->_adapters[ $adapter ] ) )
		{
			$adapterClass = $this->_adapters[ $adapter ];

			return new $adapterClass();
		}

		throw new \Exception( 'Client Adapter "'.$adapter.'" Not Found !' , 1);
	}

	static function make( $name )
	{
		if( empty(static::$_I) )
		{
			static::$_I = new static();
		}

		return static::$_I->makeAdapter( $name );
	}


}
