<?php namespace Jhul\Core\Application\Response;

class Response
{

	//http version
	public $version = '1.1';

	protected $_ifStatusCodeSet = FALSE ;

	public $statusCode;

	public $statusText;


	//Data Adpater
	//@object : output data
	protected $_page;

	protected $_dataAdapters =
	[
		'json'	=> __NAMESPACE__.'\\JSON\\JSON',
		'webpage'	=> __NAMESPACE__.'\\WebPage\\WebPage',
	];

	protected $_statusCodes = [ ];

	public function __construct( $adapter )
	{
		$this->_statusCodes = require( __DIR__.'/_status_codes.php' );

		$this->setStatusCode(200);

		$adapter = $this->_dataAdapters[ $adapter ];

		$this->_page = new $adapter;
	}

	public function page(){ return $this->_page; }

	public function ifStatusCodeSet()
	{
		return $this->_ifStatusCodeSet;
	}

	public function setStatusCode( $code, $text = NULL )
	{
		$this->_ifStatusCodeSet = TRUE;

		if( empty($text) )
		{
			$text = $this->_statusCodes[$code];
		}

		$this->statusCode = $code;

		$this->statusText = $text;

		return $this;
	}

	public function send()
	{
		$this->sendHeaders();

		$this->sendPage();
	}

	public function sendPage()
	{
		echo $this->page()->make();
	}

	protected $_headers = [];

	public function addHeader( $key, $value )
	{
		$this->_headers[ $key ] = $value;
		return $this;
	}

	public function sendHeaders()
	{
		if( empty( $this->_headers['Content-Type'] ) )
		{
			$this->_headers['Content-Type'] =  $this->page()->contentTypeHeader();
		}

		if ( !headers_sent() )
		{
			header( 'HTTP/'.$this->version.' '.$this->statusCode.' '.$this->statusText );

			foreach ($this->_headers as $key => $value)
			{
				header( $key.': '.$value );
			}
		}
	}
}
