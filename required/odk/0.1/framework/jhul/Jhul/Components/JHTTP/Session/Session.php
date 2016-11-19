<?php namespace Jhul\Components\JHTTP\Session;

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
| @Updated : Mon 25 Jan 2016 04:09:43 PM IST
+---------------------------------------------------------------------------------------------------------------------*/


 class Session extends \Symfony\Component\HttpFoundation\Session\Session
 {


 	public function __construct( )
 	{

		parent::__construct();
 		$this->start();
 	}

	public function pull( $key )
	{
		$v = $this->get($key);

		$this->remove( $key );

		return $v;

	}

	public function regenerateId()
	{
		$this->migrate();
	}

	public function flash()
	{

		return new Flash\SymfonyFlashBagWrapper( $this->getFlashBag() );
	}

	public function isSingleton()
	{
		return TRUE;
	}

 }
