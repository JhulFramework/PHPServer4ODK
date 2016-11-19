<?php namespace Jhul\Components\Excep\Sys ;

use Jhul\Components\Excep\Sys\Types\ErrorException;

use Jhul\Components\Excep\Sys\Types\FatalErrorException;

use Jhul\Components\Excep\Sys\Handlers\CallBack;


class RealHandler
{

		/**
	- Enable  error handler( self ).
	- @return self
	*/
	protected function _enable( $mode = 'World' )
	{

		if( $this->enabled ) return $this;

		//ini_set('display_errors', 0);

		$this->createDefaultHandlers();
		
		static::$page = new Page();

		/*
		- Workaround PHP bug 42098
		- https://bugs.php.net/bug.php?id=42098
		*/
		class_exists("\\Jhul\\Components\\Excep\\Sys\\Types\\ErrorException");

		set_error_handler(array($this, 'handleError'));
		set_exception_handler(array($this, 'handleException'));
		register_shutdown_function(array($this, 'handleShutdown'));

		$this->enabled = true;

		return $this;
	}

	public function handleError($level, $message, $file = null, $line = null)
	{
	
		if( in_array($level, $this->muteErrors) ) return;

		throw new ErrorException($message, $level, 0, $file, $line);
	}


	/* Since shut down functions can be called on exit(), so its not alway because of errors */
	public function handleShutdown()
	{
		static::$shutDownMode = true;

	

		if( ($err = error_get_last() ) == null ) return;

		$exception = new FatalErrorException( $err['message'], $err['type'], 0, $err['file'], $err['line'] );

		$this->callHandlers( $exception );
	}

	private function callHandlers( $exception )
	{
		
		while( ( $handler = $this->popHandler() ) != null && static::$callNextHandler )
		{
			$handler->handle( $exception );
		}

		/*
		- Cleaning up all other output buffers before sending our exception output:
		*/
		//while (ob_get_level() > 0) ob_end_clean();

		/* output */
		static::page()->display();
	}

	public function handleException( $exception ) { $this->callHandlers($exception); }

}
