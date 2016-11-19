<?php namespace Jhul\Components\EX\Sys\Handlers;
/*
------------------------------------------------------------------------------------------------------------------------
> @ Copyright (c) 2013-2014 Manish Dhruw [ 1D3N717Y12@gmail.com ]
> @ License see LICENSE
- Wednesday 05 February 2014 11:51:12 AM IST
------------------------------------------------------------------------------------------------------------------------
*/
class CallBack extends Handler
{

	private $_handle;

	public static function I()
	{
		return new static();
	}

	public function setHandle( $callable )
	{
		if( is_callable($callable) == false) throw new \Exception('Please provide valid callback');
		$this->_handle = $callable;
		return $this;
	}

	public function handle( $exception )
	{
		$this->setException($exception);
		return call_user_func( $this->_handle, $this );
	}

}
