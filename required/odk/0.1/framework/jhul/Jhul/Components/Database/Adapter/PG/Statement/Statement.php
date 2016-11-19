<?php namespace Jhul\Components\Database\Adapter\PG\Statement;

/* @Author : MANISH DHRUW [ 1D3N717Y12@gmail.com ]
+-----------------------------------------------------------------------------------------------------------------------
| @Created : 2016-July-07
|
| @Updated : 2016-July-08
+=====================================================================================================================*/

class Statement
{
	protected static $_map = [];

	function __construct()
	{
		if( empty( static::$_map ) )
		{
			static::$_map = require( __DIR__.'/_map.php' );
		}
	}


	static function I()
	{
		return new static();
	}

	function make( $type = 'custom' )
	{

		if( isset( static::$_map[$type] ) )
		{
			$statement = static::$_map[ $type ];

			if( FALSE === strpos( $statement, '\\' ) )
			{
				return static::make()->setQuery( $statement );
			}

			return new $statement ;
		}
		else
		{
			return static::make()->setQuery( $type );
		}
	}
}
