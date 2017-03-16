<?php namespace Jhul\Components\Router;

/* @Author : Manish Dhruw [1D3N717Y12@gmail.com]
+=======================================================================================================================
| @Created : 13-Jun-2016
|
|
| @Update : 2016-02-11
+---------------------------------------------------------------------------------------------------------------------*/

class Route
{
	use \Jhul\Core\_AccessKey;

	//HANDLER NODE
	protected $_path;

	protected $_data;

	//HANDLER MODULE
	//protected $_handler;

	//protected $_key;

	private $_statusCode;

	private $_route;

	public function __construct( $route )
	{

		$this->_route = $route;

		//$this->_key = $route['key'];

		//$this->_data 	= $route['data'];

		$this->_path	= new Path( $route['P'] );

		// //default is page
		// $this->_handler =  $route['handler']['module_key'].'.'.$route['handler']['page'] ;
		//
		// //switch to handler if it is set
		// if( !empty($route['handler']['node']) )
		// {
		// 	$this->_handler =  $route['handler']['module_key'].'.'.$route['handler']['node'] ;
		// }

		$this->_statusCode = $route['status_code'] ;
	}

	public function statusCode() { return $this->_statusCode; }

	public function key()
	{
		return $this->_route['key'];
	}

	// public function moduleKey() { return $this->_route['handler']['module_key']; }
	//
	// public function nodeKey() { return $this->_route['handler']['node']; }
	//
	// public function pageKey() { return $this->_route['handler']['page']; }
	//
	// public function staticPageKey() { return $this->_route['handler']['static_page']; }

	public function params()
	{
		return $this->_route['params'];
	}

	public function getData( $key )
	{
		$arg = explode( '::', $key );

		if( empty($arg[0]) )
		{
			throw new \Exception( 'Please set Data type in "'.$key.'" ' );
		}

		if( isset( $this->_data[$arg[1]] )  )
		{
			return $this->getApp()->mDataType( $arg[0] )->filter( $this->_data[ $arg[1] ] );
		}
	}

	public function getParam( $key, $type )
	{
		$value = null;

		if( isset( $this->_route['params'][ $key ] )  )
		{
			$value = $this->_route['params'][$key];
		}

		return $this->getApp()->mDataType( $type )->make( $value );
	}


	public function handler()
	{
		return $this->_route['handler'];
	}

	public function nav()
	{
		return $this->_path;
	}

	public function typeIdentifier()
	{
		return $this->_route['type_identifier'];
	}

	public function type()
	{
		return $this->_route['type'];
	}
}
