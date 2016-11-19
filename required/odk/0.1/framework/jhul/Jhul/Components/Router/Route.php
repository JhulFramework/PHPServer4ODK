<?php namespace Jhul\Components\Router;

/* @Author : Manish Dhruw [1D3N717Y12@gmail.com]
+=======================================================================================================================
| @Created : 13-Jun-2016
+---------------------------------------------------------------------------------------------------------------------*/

class Route
{
	use \Jhul\Core\_AccessKey;

	//HANDLER NODE
	protected $_path;

	protected $_data;

	//HANDLER MODULE
	protected $_handler;

	protected $_ik;

	public function __construct( $route )
	{

		$this->_ik = $route['I'];

		$this->_data 	= $route['D'];

		$this->_path	= new Path( $route['P'] );



		//$this->_handler	= new Handler( $route['H'] );
		$this->_handler =  $route['H']['M'].'.'.$route['H']['N'] ;

	}

	public function ik()
	{
		return $this->_ik;
	}

	public function data()
	{
		return $this->_data;
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

	public function handler()
	{
		return $this->_handler;
	}


	public function path()
	{
		return $this->_path;
	}


}
