<?php namespace Jhul\Core\Application;

class Application
{

	use \Jhul\Core\Design\Component\_Trait;

      const ACTIVITY_BEFORE_RUN = 'ACTIVITY_BEFORE_RUN' ;

      const ACTIVITY_AFTER_RUN = 'ACTIVITY_AFTER_RUN' ;

	protected $_configLoader;

	protected $_dataType;

	protected $_endUser;

	protected $_outputAdapter;
	protected $_path;


	protected $_route;

	protected $_mActivity;

	protected $_mHandler;

	protected $_mURL;

	protected $_data;

	
	public function __construct( $params  )
	{

		$this->_path = $this->J()->fx()->dirPath( get_called_class() );

		$this->_mActivity	= new Node\Activity\Manager;

		$this->_mHandler	= new Node\Handler\Manager;

		$this->_configLoader	= new ConfigLoader;

		$this->_mDataType = new DataType\Manager;

		$this->_data = new SharedData;

		$this->_mURL = new URLManager( $params['url'], $this->J()->fx()->loadConfigFile( $params['url_map'] ) );



	}


	public function configLoader(){ return $this->_configLoader; }
	public function data( ) { return $this->_data; }
	public function endUser(){ return $this->_endUser; }
	public function name(){ return $this->config('name') ; }
	public function outputAdapter(){ return $this->_outputAdapter; }

	public function path(){ return $this->_path; }
	public function route(){ return $this->_route; }
	public function mActivity(){ return $this->_mActivity; }
	public function mHandler(){ return $this->_mHandler; }
	public function mURL(){ return $this->_mURL; }



	public function mDataType( $type = NULL )
	{
		if( !empty($type))
		{
			return $this->_mDataType->get($type);
		}
		return $this->_mDataType;
	}

	public function lipi()
	{
		return $this->J()->cx('lipi');
	}

	public function m( $name = NULL )
	{
		if( !empty( $name ) )
		{
			return $this->_moduleStore->g( $name );
		}

		return $this->_moduleStore;
	}

	protected function processClientRequest()
	{
		$this->mHandler()->handle( $this->_route->handler() );
	}

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

	protected function beforeRun(){}

	public function publicRoot(){ return JHUL_APPLICATION_PUBLIC_ROOT ; }

	public function run()
	{
		if( !$this->J()->ifDebugOn() )
		{
			$this->registerExceptionHandler();
		}

		$this->beforeRun();

		$this->processClientRequest();

		return $this->outputAdapter()->sendResponse();
	}



	public function runActivity( $activity_name )
	{
		$this->J()->cx('event')->trigger( static::ACTIVITY_BEFORE_RUN );

		$this->mActivity()->run( $activity_name );

		$this->J()->cx('event')->trigger( static::ACTIVITY_AFTER_RUN );
	}

	public function s( $name, $com )
	{
		$name = '_'.$name;

		$this->$name = $com;
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
