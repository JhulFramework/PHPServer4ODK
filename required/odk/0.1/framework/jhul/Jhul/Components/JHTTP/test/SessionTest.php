<?php namespace mwapp\components\mhttp\test;

use \mwapp\components\mhttp\Session;

class SessionTest extends PHPUnit_Framework_TestCase
{

	public function testSessionAutoStartEnable()
	{
		$session = new Session;

		//$session->autoStart = TRUE ;

		$session->_init();

		$this->assertTRUE( $session->isActive() );
	}

	public function testSessionAutoStartDisable()
	{
		$session = new Session;

		$session->autoStart = FALSE ;

		$session->_init();

		$this->assertFALSE( $session->isActive() );
	}
}
