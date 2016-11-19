<?php namespace Jhul\Components\MHttp\SSession;

class Session
{
	private $_session;

	public function __construct( )
	{
		$this->_session = new \Symfony\Component\HttpFoundation\Session\Session;

		$this->_session->start();
	}

	public function set( $key, $val)
	{
		$this->_session->set($key, $val);
	}

	public function get( $key )
	{
		return $this->_session->get($value);
	}

	
}
