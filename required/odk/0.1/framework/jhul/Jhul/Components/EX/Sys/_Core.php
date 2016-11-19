<?php namespace Jhul\Components\EX\Sys ;

/*
------------------------------------------------------------------------------------------------------------------------
> @ Copyright (c) 2013-2014 Manish Dhruw [ 1D3N717Y12@gmail.com ]

> @ License see LICENSE

> @Author manish dhruw [ 1D3N717Y12@gmail.com ]

- Wednesday 05 February 2014 11:51:33 AM IST
-updated Tuesday 24 March 2015 03:19:03 PM IST
------------------------------------------------------------------------------------------------------------------------
*/

use Jhul\Components\EX\Sys\Types\ErrorException;

use Jhul\Components\EX\Sys\Types\FatalErrorException;


use Jhul\Components\EX\Sys\Handlers\Debug ;

use Jhul\Components\EX\Sys\Handlers\World ;

use Jhul\Components\EX\Sys\Handlers\CallBack;


class _Core
{


/*----------------------------------------------------------------------------------------------------------------------
 API
----------------------------------------------------------------------------------------------------------------------*/

	public $conf;

	public $removeTracesFrom = [];

	public $shutDownMode = FALSE ;

	public $callNextHandler = TRUE;

	public $page ;

	public static function I()
	{
		if( static::$instantiated == FALSE )
		{
			static::$instance = new static();

			static::$instantiated = TRUE ;
		}

		return static::$instance;
	}

	public function activate()
	{
		$this->_enable();
	}


	/*
	 * eg. $this->mute('notices');
	 *eg. $this->mute('warnings');
	*/
	public function mute( $errorName )
	{
		if( isset( $this->errorTypes[ $errorName  ] ))
		{
			$this->muteErrors[ $errorName ] = $this->errorTypes[ $errorName  ] ;
		}
	}

	public function unmute( $errorName )
	{
		if( isset( $this->muteErrors[ $errorName ] ) )
			unset($this->muteErrors[$errorName ]);
	}

	public function ifDebugOn()
	{
		return $this->conf['debugMode'] == TRUE;
	}

/*----------------------------------------------------------------------------------------------------------------------
 INTERNAL
----------------------------------------------------------------------------------------------------------------------*/

	protected static $instance;

	protected static $instantiated = FALSE;

	protected function __construct()
	{
		$this->boot();
	}



	private $handlers = [];

	private $enabled = false;

	private $muteErrors = [];

	private $errorTypes =
	[
		'notices' => E_NOTICE,

		'warnings' => E_WARNING,

		'N' => E_NOTICE,

		'W' => E_WARNING,
	];

	protected function boot()
	{
		$this->conf = require( JHUL_EX_HANDLER_PATH.'/conf/conf.php' );
	}


	public function removeTracesFrom( $path )
	{
		static::$removeTracesFrom[] = $path;
	}

	public function pushHandler(  $handler ) { $this->handlers[] = $handler ; }

	/*
	- get handlers in reverse order
	- Handler created in first place will be called at last;
	*/
	public function popHandler() { return array_pop($this->handlers) ; }


	/*
	- Creates and push handler using callback
	*/
	public function createCallbackHandler( $callable, $callNextHandler = false )
	{
		$this->callNextHandler = $callNextHandler;

		$this->pushHandler( CallBack::I()->setHandle($callable) );
	}

	public function setDebug( $bool )
	{
		$this->conf['debugMode'] = ( TRUE == $bool ) ;
	}


	//Enable  error handler( self ).
	//@return self
	protected function _enable( $mode = 'World' )
	{

		if( $this->enabled ) return $this;

		//ini_set('display_errors', 0);

		$this->createDefaultHandlers();

		$this->page = new Page();

		/*
		- Workaround PHP bug 42098
		- https://bugs.php.net/bug.php?id=42098
		*/
		class_exists("\\Jhul\\Components\\EX\\Sys\\Types\\ErrorException");

		set_error_handler(array($this, 'handleError'));
		set_exception_handler(array($this, 'handleException'));
		register_shutdown_function(array($this, 'handleShutdown'));

		$this->enabled = true;

		return $this;
	}

	public function hideTracesFrom( $dir )
	{
		$this->hideTracesFrom[] = $dir;
	}



	public function createDefaultHandlers()
	{

		$this->pushHandler( new Debug  ) ;

		/*
		# testing
		# $this->createxcp( function( $self ){ $self->setCallNext(false); return "Error Quiting hahah"; } );
		*/
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
		$this->shutDownMode = true;

		if( ($err = error_get_last() ) == null ) return;

		$exception = new FatalErrorException( $err['message'], $err['type'], 0, $err['file'], $err['line'] );

		$this->callHandlers( $exception );
	}

	private function callHandlers( $exception )
	{

		$callNextHandler = TRUE ;

		while( ( $handler = $this->popHandler() ) != null && $callNextHandler )
		{
			$callNextHandler = $handler->handle( $exception );
		}

		if( $callNextHandler )
		{

		/*
		- Cleaning up all other output buffers before sending our exception output:
		*/
			while (ob_get_level() > 0) ob_end_clean();

		/* output */
			$this->page->display();
		}
	}

	public function handleException( $exception ) { $this->callHandlers($exception); }


}
