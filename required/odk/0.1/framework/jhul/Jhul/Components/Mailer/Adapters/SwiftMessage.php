<?php namespace Jhul\Components\Mailer\Adapters;

/*----------------------------------------------------------------------------------------------------------------------
 * @author Manish Dhruw < 1D3N717Y12@gmail.com >
 *
 *
 *
 *--------------------------------------------------------------------------------------------------------------------*/

class SwiftMessage extends \Swift_Message
{

	private $_transport;

	private function _prepareTransport( $transportType = 'smtp', $host, $port, $username, $password )
	{
		if( $transportType == 'smtp' )
		{
			$this->_transport = \Swift_SmtpTransport::newInstance( $host, $port );
		}

		$this->_transport->setUsername( $username )->setPassword( $password ) ;
	}

	public static function createNew( $transportType, $host, $port, $username, $password )
	{
		$msg = new static();

		$msg->_prepareTransport( $transportType, $host, $port, $username, $password ) ;

		return $msg;
	}

	public function dispatch()
	{
		return \Swift_Mailer::newInstance( $this->_transport )->send( $this );
	}
}
