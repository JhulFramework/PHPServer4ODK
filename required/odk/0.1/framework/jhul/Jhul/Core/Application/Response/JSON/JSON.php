<?php namespace Jhul\Core\Application\Response\JSON;

class JSON
{
	use \Jhul\Core\_AccessKey;

	private static $_JSON_Objects;

	public function __construct()
	{
		static::$_JSON_Objects = new \stdClass();
		$this->cook("ifLoggedIn", !$this->getApp()->user()->isAnon() );
	}

	public function cook( $key, $value = "" )
	{

		if( is_array( $key ) )
		{
			foreach ($key as $k => $v)
			{
				$this->cook( $k, $v );
			}

			return ;
		}

		if( !isset( static::$_JSON_Objects->$key ) )
		{
			static::$_JSON_Objects->$key = $value;
		}
	}

	public function type(){ return 'json'; }


	public function isEmpty()
	{
		return empty( static::$_JSON_Objects );
	}

	public function make()
	{
		return json_encode( static::$_JSON_Objects );
	}


	public function contentTypeHeader()
	{
		return 'application/json';
	}
}
