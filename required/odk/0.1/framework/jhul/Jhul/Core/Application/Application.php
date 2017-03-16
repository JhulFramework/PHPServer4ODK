<?php namespace Jhul\Core\Application;

class Application
{
	use \Jhul\Core\Design\Component\_Trait;

	protected $_configLoader;

	protected $_dataType;

	protected $_user;

	protected $_response;

	//application script path
	protected $_path;


	protected $_mActivity;

	//Handler Maanger
	protected $_mHandler;

	//URL manager
	protected $_mURL;

	//Page Manager
	protected $_mPage;


	protected $_data;

	//protected $_modules = [];

	protected $_session;


	public function __construct( $params  )
	{

		$this->_path = $this->J()->fx()->dirPath( get_called_class() );

		//$this->_mActivity	= new Node\Activity\Manager;
		$this->_mPage	= new Page\Manager;

		$this->_mHandler	= new Handler\Manager;

		$this->_configLoader	= new ConfigLoader;

		$this->_mDataType = new DataType\Manager;

		//TODO remove it
		$this->_data = new SharedData;


		$this->_mURL = new URLManager( $params['url'], $this->J()->fx()->loadConfigFile( $params['url_map'] ) );
	}

	//this method will be called before running application
	protected function beforeRun(){}

	public function configLoader(){ return $this->_configLoader; }
	public function mData( ) { return $this->_data; }
	public function user(){ return $this->_user; }
	public function name(){ return $this->config('name') ; }

	public function response()
	{
		if( empty($this->_response) )
		{
			$this->_response = new Response\Response( $this->user()->request()->mode() );

			$this->_response->setStatusCode( $this->user()->request()->route()->statusCode() );
		}

		return $this->_response;
	}

	//public function mActivity(){ return $this->_mActivity; }
	public function mPage(){ return $this->_mPage; }
	public function mHandler(){ return $this->_mHandler; }
	public function mURL(){ return $this->_mURL; }
	public function path(){ return $this->_path; }

	public function session(){ return $this->_session; }

	public function lipi(){ return $this->J()->cx('lipi'); }

	public function m( $name = NULL )
	{
		if( !empty( $name ) )
		{
			return $this->_moduleStore->g( $name );
		}

		return $this->_moduleStore;
	}

	public function mDataType( $type = NULL )
	{
		if( !empty($type))
		{
			return $this->_mDataType->get($type);
		}
		return $this->_mDataType;
	}

	protected function handleRoute( $route )
	{
		if( $route->type() == 'node' )
		{
			return $this->mHandler()->run( $route->handler() );
		}

		if( $route->type() == 'page' )
		{
			return $this->renderPage( $route->handler(), $route->params() );
		}

		if( $route->type() == 'static_page' )
		{
			return $this->renderVirtualNode( $route->handler(), $route->params() );
		}

		// if( '' != $this->user()->request()->route()->pageKey() )
		// {
		// 	return $this->renderPage( $this->user()->request()->route()->handler() );
		// }
		//
		//
		// $this->runHandler( $this->user()->request()->route()->handler() );
	}

	public function publicRoot(){ return JHUL_APPLICATION_PUBLIC_ROOT ; }

	public function redirect( $url )
	{
		header( 'Location: '.$url );
		exit;
	}

	private function registerExceptionHandler()
	{
		$this->j()->ex()->createCallbackHandler
		(
			function()
			{
				$this->handleNode('SERVER_ERROR');
				$this->sendResponse();
				return FALSE;
			}
		);
	}

	public function renderVirtualNode( $handler, $params =[] )
	{
		$handler = explode( $this->J()->cx('router')->staticPageIdentifier(), $handler );

		if( 'app' == $handler[0] )
		{
			$file = $this->path().'/nodes/_static/'.$handler[1].'.php';
		}
		else
		{
			$file = $this->m( $handler[0] )->path().'/nodes/_static/'.$handler[1].'.php' ;
		}

		$this->renderFile( $file, $params );
	}

	private function renderFile( $file, $params =[] )
	{
		if( !$this->J()->ifDebugOn() )
		{
			$this->registerExceptionHandler();
		}

		$this->beforeRun();


		$this->response()->page()->loadFile( $file , $params );
	}

	public function run()
	{
		if( !$this->J()->ifDebugOn() )
		{
			$this->registerExceptionHandler();
		}

		$this->beforeRun();

		$this->handleRoute( $this->user()->request()->route() );

		return $this->response()->send();
	}

	public function renderPage( $view, $format = NULL )
	{
		$this->mPage()->render( $view );
	}
	//
	// public function runHandler( $handler )
	// {
	// 	$this->mHandler()->run( $handler );
	// }

	public function s( $name, $com )
	{
		$name = '_'.$name;

		$this->$name = $com;
	}

	public function setFlash( $value, $key = 'flash' )
	{
		$this->session()->set( $key, $value );
	}

	public function hasFlash( $key = 'flash' )
	{
		return $this->session()->has($key);
	}


	public function getFlash( $key = 'flash' )
	{
		return $this->session()->pull( $key );
	}

	public function url( $append = NULL )
	{
		if( !empty($append) )
		{
			return $this->url().'/'.$append;
		}

		return $this->config('url');
	}

}
