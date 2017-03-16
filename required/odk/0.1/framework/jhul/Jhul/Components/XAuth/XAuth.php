<?php namespace Jhul\Components\XAuth;

defined('JHUL_C_XAUTH_DEBUG') or define('JHUL_C_XAUTH_DEBUG', FALSE );

class XAuth
{

	public $dataLifeTime = 600 ; //10 minutes

	private $_server;
	private $_serverName;

	private $_debugMessage = 'Loading Old Data';

	private $_servers =
	[
		'google' 	=> __NAMESPACE__.'\Google\Google',
		'facebook'	=> __NAMESPACE__.'\Facebook\Facebook',
	];

	public function __configure()
	{
		return
		[
			'dataLifeTime' => '',
		];
	}


	public function __construct( $serverName )
	{

		if( !isset( $this->_servers[$serverName] ) )
		{
			throw new \Exception( 'Server "'.$serverName.'" Not Found!', 1 );
		}

		$this->_serverName = $serverName;
	}

	public static function I( $serverName )
	{
		return new static( $serverName );
	}

	public function server()
	{
		$this->_debugMessage = 'Loading New Data' ;

		if( NULL == $this->_server )
		{
			$this->_server = new $this->_servers[$this->_serverName];
		}

		return $this->_server;
	}

	public function dataKey()
	{
		return 'user_data_'.$this->_serverName;
	}

	public function data_new()
	{
		return $this->server()->fetchData();
	}

	public function data()
	{

		//if data is availabel, checks if it is expired
		//if expired destroys data
		if( isset( $_SESSION[ $this->dataKey()  ] ) )
		{
			if( time() > $_SESSION[ $this->dataKey()  ]['E'] )
			{
				$_SESSION[ $this->dataKey()  ] = FALSE;
			}
		}


		//If data not loaded
		if( empty( $_SESSION[ $this->dataKey()  ] )  )
		{

			$data = [];
			$data = $this->server()->fetchData();
			$data['E'] = time() + $this->dataLifeTime;
			$_SESSION[ $this->dataKey()  ] = $data;

		}

		if( isset($_SESSION[ $this->dataKey() ] ) )
		{

			if( JHUL_C_XAUTH_DEBUG ) echo $this->_debugMessage . ' From Server'.$this->_serverName;

			return $_SESSION[ $this->dataKey() ] ;
		}
	}

}
