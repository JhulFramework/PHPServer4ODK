<?php namespace Jhul\Core\Application;

/* @Author : Manish DHruw [1D3N717Y12@gmail.com]
+=======================================================================================================================
| @author Manish Dhruw < 1D3N717Y12@gmail.com >
|
| $this->set( 'name', $value );
| $this->get('name');
| $this->flash()->set( 'msg', 'Hello' );
| $this->flash()->get( 'msg');
| $this->flash()->map();
|
| Friday 21 November 2014 07:57:11 PM IST
| @Updated : [ Mon 25 Jan 2016 04:09:43 PM IST, 2017-01-31 ]
+---------------------------------------------------------------------------------------------------------------------*/


class Session
{

	protected $_ifStarted = FALSE;

	protected $_session_key_prefix;

 	public function __construct( $session_key_prefix  )
 	{
		$this->_session_key_prefix = $session_key_prefix;
 		$this->start();
 	}

	public function pull( $key )
	{
		$value = $this->get($key);

		$this->remove( $key );

		return $value;
	}

	public function has( $key )
	{
		return isset( $_SESSION[ $this->prefixKey( $key ) ] );
	}

	public function regenerateKey()
	{
		session_regenerate_id();
	}

	public function set( $key, $value )
	{
		$_SESSION[ $this->prefixKey($key) ] = $value;
	}

	public function get( $key, $required = FALSE )
	{
		if( $this->has($key) )
		{
			return $_SESSION[ $this->prefixKey( $key ) ];
		}

		if( $required )
		{
			throw new \Exception( 'Session with key "'.$key.'" does not exists' , 1);
		}
	}

	public function remove( $key )
	{
		unset( $_SESSION[ $this->prefixKey($key) ] ) ;
	}

	public function prefixKey( $key )
	{
		return $this->_session_key_prefix.'_'.$key;
	}

	public function start()
	{
		if( ! $this->_ifStarted )
		{
			$this->_ifStarted = session_start();

			if( $this->_ifStarted ) return TRUE;

			throw new \Exception('Failed to start the session', 1);
		}

	}
}
