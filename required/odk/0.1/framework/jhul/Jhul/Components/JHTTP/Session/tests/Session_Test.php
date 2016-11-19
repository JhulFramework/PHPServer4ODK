<?php

require( dirname(__DIR__).'/Session.php' );

class Session_Test extends \mwapp\components\tester\Test
{

	public function TOClass()
	{
		return '\\mwapp\\components\\mhttp\\session\\Session';
	}

	public function obj()
	{
		if( NULL == $this->_TO )
		{
			$class = $this->TOClass();
			$to = new $class ; 
			$this->_TO = $to->_substitute();
		}

		return $this->_TO;
	}

	public function test_start()
	{
		return $this->obj()->start();
	}


	public function test_set()
	{
	
		$this->test_start();
	
		//$this->obj()->set( 'testKey', 'TestValue' );

		$this->kdump( $_SESSION );
	}

	public function test_get()
	{
		$this->obj()->get( 'testKey' );
	}

	public function test_flash_set()
	{
		$this->obj()->flash()->set('msg', 'Hello');
		$this->obj()->flash()->set('msg2', 'Helloa');
		//\Kint::dump( $_SESSION );
		echo $this->arrayToHtml($_GET);
	}

	public function test_flash_get()
	{
		$this->test_start();
		$this->test_set();
		$this->test_flash_set();
		//\Kint::dump( $this->obj()->flash()->map() );
		//\Kint::dump( $this->obj()->flash()->get('msg') );
		//\Kint::dump( $_SESSION );
		echo $this->arrayToHtml($_SESSION);
	}
}
