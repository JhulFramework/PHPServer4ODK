<?php namespace Jhul\Components\Mailer;

class Mailer
{
	public $host ;

	public $port ;

	public $username ;

	public $password ;

	public $transport = 'smtp';

	public $from ;

	public $boundary ;

	public function _configure()
	{
		return array(

			'host' => '',

			'port' => '',

			'username' => '',

			'password' => '',

			'transport' => '',

			'from' => '',

			'boundary' => ''

		);
	}

	public function newMessage()
	{
		return Adapters\SwiftMessage::createNew( $this->transport, $this->host, $this->port, $this->username, $this->password )

		->setFrom( array( $this->username => $this->from ) )

		->setBoundary( 'leafpad_'.time() ) ;
	}
	
	public function isSingleton()
	{
		return TRUE;
	}
}
