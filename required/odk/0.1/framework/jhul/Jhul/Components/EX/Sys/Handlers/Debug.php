<?php namespace Jhul\Components\EX\Sys\Handlers ;

/*
------------------------------------------------------------------------------------------------------------------------
> @Author manish dhruw < 1D3N717Y12@gmail.com >


- Saturday 08 March 2014 09:00:58 PM IST
------------------------------------------------------------------------------------------------------------------------
*/

use Jhul\Components\EX\EX;

class Debug extends Handler
{


	public function handle( $exception )
	{

		$this->setException( $exception );

		$params = array(

			'displayTitle' => get_called_class(),

			'message'	=> $this->exception()->getMessage(),

			'screenShots' => $this->page()->snaps( $this->frames(), EX::I()->conf[ 'frameHeight']  ),

			'errorCode' => $this->exception()->getCode(),

			'errorName'	=> $this->exceptionName(),

		);

		$this->page()->render( 'debug', $params );

		return TRUE;

	}

}
