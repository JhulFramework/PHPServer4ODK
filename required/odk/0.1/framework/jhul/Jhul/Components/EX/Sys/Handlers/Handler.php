<?php namespace Jhul\Components\EX\Sys\Handlers;

/*
------------------------------------------------------------------------------------------------------------------------
> @ Copyright (c) 2013-2014 Manish Dhruw [ 1D3N717Y12@gmail.com ]
> @ License see LICENSE

> Wednesday 05 February 2014 11:49:15 AM IST
------------------------------------------------------------------------------------------------------------------------
*/

use \Jhul\Components\EX\Sys\Types\MException ;

use \Jhul\Components\EX\EX;

abstract class Handler implements HandlerInterface
{
	private $_exception;

	public function exception() { return $this->_exception ; }

	public function endHandling() { static::$callNextHandler = false ; }

	public function setException( $exception )
	{
		$this->_exception = $exception ;
		return $this;
	}

	/*  */
	public abstract function handle( $exception );


	/* formats frames*/
	public function frames()
	{

		if( $this->exception() instanceof MException )
		{

			$frames = $this->exception()->trace() ;
		}

		elseif( $this->exception() instanceof FatalErrorException ) return array( $this->firstFrame() );

		else
		{

			$frames = $this->exception()->getTrace();

			$frames[0] = $this->firstFrame();
		}


		foreach($frames as $key => $frame)
		{
			if( !isset($frame['file'])  ) unset($frames[$key]);

			foreach( EX::I()->removeTracesFrom  as $rtf )
			{
				if( mb_strpos( $frame['file'], $rtf, 0, '8bit' ) === 0  ) unset($frames[$key]);
			}
		}


		return array_slice( $frames, 0, EX::I()->conf[ 'maxFrames' ] );;
	}

	protected function firstFrame()
	{
		return array(

			'file'  => $this->exception()->getFile(),

			'line'  => $this->exception()->getLine(),

			'class' => get_class( $this->exception() ),

			'args'  => array(),
		);
	}

	public function exceptionName()
	{
		$names =
		[

			E_ERROR              => 'Error(Fatal)',
			E_WARNING            => 'Warning',
			E_PARSE              => 'Parsing Error',
			E_NOTICE             => 'Notice',
			E_CORE_ERROR         => 'Core Error',
			E_CORE_WARNING       => 'Core Warning',
			E_COMPILE_ERROR      => 'Compile Error',
			E_COMPILE_WARNING    => 'Compile Warning',
			E_USER_ERROR         => 'User Error',
			E_USER_WARNING       => 'User Warning',
			E_USER_NOTICE        => 'User Notice',
			E_STRICT             => 'Runtime Notice',
			E_RECOVERABLE_ERROR  => 'Catchable Fatal Error'
		];

		$name = 'Unknown';

		if( isset( $names[ $this->exception()->getCode() ] ) ) $name = $names[$this->exception()->getCode()];

		return $name.' - '. $this->exception()->getCode() ;
	}

	protected function page()
	{
		return EX::I()->page ;
	}
}
