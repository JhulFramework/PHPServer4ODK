<?php namespace Jhul\Components\XHelper;

class XHelper
{
	use \Jhul\Core\_AccessKey;

	//@Structure : [ error_code => handler_ik ]
	protected $_map = [];

	//@Structure : [ handler_ik => handler_class ]
	protected $_handlers = [];

	public function show( $error_code, $params, $entity )
	{
		$message = $this->cookMessage( $error_code, $params, $entity );

		throw new \Exception( $message , 1 );
	}

	public function cookMessage( $error, $params, $entity )
	{

		if( isset( $this->_map[$error] ) )
		{
			$class = $this->_handlers[ $this->_map[$error] ];

			return (new $class)->cook( $error, $params, $entity );
		}
	}

	public function errorMap()
	{
		return $this->_map;
	}

	public function handlerMap()
	{
		return $this->_handlers;
	}

	public function register( $class, $ik )
	{
		$this->registerHandler($class, $ik);

		$errors = require( $this->J()->g('P')->getDirPath( $class ).'/_errors.php' ) ;

		if( !is_array( $errors ) )
		{
			$errors = [];
		}

		foreach ( $errors as $error )
		{
			$this->registerError( $error, $ik );
		}
	}

	protected function registerError( $error, $handler  )
	{
		if( isset( $this->_map[$error] ) )
		{
			if( $this->_map[$error]  != $handler )
			{
				throw new \Exception( 'Error code clash between "'.$this->_map[$error].':'.$error.'" and "'.$handler.':'.$error.'" ' , 1);
			}

			return;
		}

		$this->_map[$error] = $handler;
	}

	protected function registerHandler( $class, $ik  )
	{
		if( isset( $this->_handlers[$ik] ) )
		{
			if( $this->_handlers[$ik]  != $class )
			{
				throw new \Exception( 'Clash between error handling class "'.$this->_handlers[$ik].'" and "'.$class.'" For IK "'.$ik.'" ' , 1);
			}

			return;
		}

		if( !class_exists($class) )
		{
			throw new \Exception( 'Error Handling class "'.$class.'" does not exists' , 1);
		}

		$this->_handlers[$ik] = $class;
	}
}
