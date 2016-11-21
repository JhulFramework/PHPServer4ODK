<?php namespace Jhul\Core\Application\EndUser;


/* @Author : Manish Dhruw < 1D3N717Y12@gmail.com >
+=======================================================================================================================
|
+---------------------------------------------------------------------------------------------------------------------*/

class Request
{

	protected $_baseURL ;

	protected $path;

	private $_languageModes =
	[
		'ENG'		=> 'ENGLISH',
		'HIN'		=> 'HINDI',
	];

	private $_languageMode;

	//default is web mode
	private $_requestModes =
	[
		'JSON'	=> 'JSON',
		'HTML'	=> 'HTML',
	];


	//http or json
	private $_requestMode = 'webpage' ;


	public function clientRequestedDataFormat()
	{
		return $this->_requestMode;
	}

	public function languageMode()
	{
		return $this->_languageMode;
	}

	public function setBaseUrl( $baseUrl )
	{
		$this->_baseURL = trim($baseUrl, '/');
	}

	public function baseUrl()
	{
		return $this->_baseURL;
	}


	public function path()
	{
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


		if( isset( $p[0] ) && isset($this->_requestModes[ strtoupper($p[0]) ]) )
		{
			$this->_requestMode = strtoupper($p[0]);
			array_shift( $p );
		}

		if( isset($p[0]) && isset($this->_languageModes[$p[0]]) )
		{
			$this->_languageMode = $p[0];
			array_shift( $p );
		}

		$this->path = implode('/', $p);



		return $this->path;
	}

	private $_P = [];

	// Acccess $_POST
	public function P()
	{
		if( empty($this->_P))
		{
			$this->_P = Request_Data::I($_POST) ;
		}

		return $this->_P;
	}

	private $_G;

	// Acccess $_GET
	public function G()
	{
		if( empty($this->_G))
		{
			$this->_G = Request_Data::I($_GET);
		}

		return $this->_G;
	}


	private $_S;
	// Acccess $_SERVER
	public function S()
	{
		if( empty($this->_S))
		{
			$this->_S = Request_Data::I($_SERVER);
		}

		return $this->_S;
	}

	public function hasData( $key, $type )
	{
		$type = '$_'.strtoupper($type);

		$data = $$type;

		echo '<br/> FILE : '.__FILE__;
		echo '<br/> LINE : '.__LINE__;
		echo '<pre>';
		var_dump($$type);
		echo '</pre>';
		exit();
	}
}