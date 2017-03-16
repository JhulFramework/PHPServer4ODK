<?php namespace Jhul\Components\Mailer;

class Mailer
{
	protected $_p = [];

	public function __construct( $p )
	{
		$this->_p = $p;
	}

	public function newMessage()
	{
		return Adapters\SwiftMessage::createNew( $this->_p['transport'], $this->_p['host'], $this->_p['port'], $this->_p['username'], $this->_p['password'] )

		->setFrom( [ $this->_p['username'] => $this->_p['from'] ] )

		->setBoundary( $this->_p['boundary'].'_'.time() ) ;
	}

}
