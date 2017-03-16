<?php namespace Jhul\Core\Application\User;

/*
| @Author Manish Dhruw < 1D3N717Y12@gmail.com >
+=======================================================================================================================
| @Created :Thursday 06 February 2014 10:37:57 AM IST
| @Updated : [ 2017-01-29]
+---------------------------------------------------------------------------------------------------------------------*/

class Request
{

	protected $_serverURL ;

	protected $_baseURL ;

	protected $path;

	protected $_route;

	public  $autoDetectBaseURL = TRUE;

	//webpage or json
	private $_mode = 'webpage' ;

	protected $_modes =
	[
		'json' => 'json',
	];

	public function __construct( $serverURL )
	{
		$this->_serverURL = $serverURL;
		$this->translateURL();
	}

	public function mode() { return $this->_mode; }

	public function setBaseUrl( $baseUrl )
	{
		$this->_baseURL = trim($baseUrl, '/');
	}

	public function baseUrl()
	{
		return $this->_baseURL;
	}

	public function path(){ return $this->path; }

	public function route()
	{
		if( empty($this->_route) )
		{
			$this->_route = \Jhul::I()->cx('router')->match( $this->path() );
		}

		return $this->_route;
	}

	public function translateURL()
	{
		if( $this->autoDetectBaseURL )
		{
			$info = parse_url( $this->_serverURL )  ;

			if(!empty($info['path']))
			{
				$this->_baseURL = trim( $info['path'], '/' );
			}
		}

		if( NULL == $this->path  )
		{
			$uri =  trim($_SERVER['REQUEST_URI'], '/') ;


			if( !empty($this->_baseURL) && 0 === strpos( $uri, $this->_baseURL ) )
			{
				$uri = substr( $uri, strlen($this->_baseURL) + 1  );
			}

			$this->path = trim( $uri, '/') ;

			if( FALSE !== ( $pos = mb_strpos( $this->path, '?' ) ) )
			{
				$this->path = mb_substr( $this->path, 0, $pos );
			}

		}

		$p = explode('/', $this->path );

		if( isset( $p[0] ) && isset($this->_modes[ $p[0] ]) )
		{
			$this->_mode = $p[0];
			array_shift( $p );
		}

		$this->path = implode('/', $p);
	}

	public function requestedDataFormat()
	{
		return $this->_mode;
	}
}
