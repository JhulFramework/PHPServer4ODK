<?php namespace Jhul\Components\Application\JSON;

class JSON
{
	private static $_JSON_Objects;

	public function __construct()
	{
		static::$_JSON_Objects = new \stdClass();
	}

	public function add( $key, $value )
	{

		if( !isset( static::$_JSON_Objects->$key ) )
		{
			static::$_JSON_Objects->$key = $value;
			return TRUE;
		}

		return FALSE;

	}

	public function make()
	{
		return $this->json() ;
	}

	public function isEmpty()
	{
		return empty( static::$_JSON_Objects );
	}

	public function json()
	{
		return json_encode( static::$_JSON_Objects );
	}

	public function send()
	{
		$this->http()->R->headers->set('Content-Type', 'application/json');

		if( $this->J()->com('JData')->isEmpty() )
		{
			$this->http()->R->setStatusCode(404);
		}

		$this->http()->R->setContent( $this->J()->com('JData')->make()  );

		$this->http()->R->send();

		return $this->http()->R->getStatusCode() ;
	}
}
