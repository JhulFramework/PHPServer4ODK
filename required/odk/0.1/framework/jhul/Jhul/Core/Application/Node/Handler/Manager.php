<?php namespace Jhul\Core\Application\Node\Handler;

/* @Author Manish Dhruw < 1D3N717Y12@gmail.com >
+=======================================================================================================================
| @Created : 2016-October-16
+---------------------------------------------------------------------------------------------------------------------*/

class Manager
{
	use \Jhul\Core\_AccessKey;

	protected $_handlers = [];

	public function register( $module_name, $name, $class = NULL, $checkIfClassExists = TRUE )
	{

		if( is_array($name) )
		{
			foreach ( $name as $n => $c)
			{
				$this->register( $module_name, $n, $c, $checkIfClassExists );
			}

			return;
		}

		if( empty($class) ) throw new \Exception( 'Handler "'.$name.'" class must not be empty ', 1);


		$class = trim( $class, '\\' );

		if( $checkIfClassExists && !class_exists( $class ) ) throw new \Exception( 'Handler "'.$name.'" class "'.$class.'" not found', 1);


		if( isset( $this->_handlers[$name] )  && $this->_handlers[$name] != $class )
		{
			throw new \Exception( 'Clash for HANDLER name "'.$name.'" betwen alreday registered class "'.$this->_handlers[$name].'" and new class "'.$class.'" ', 1);
		}

		$this->_handlers[ $module_name.'.'.$name ] = $class;
	}

	public function map()
	{
		return $this->_handlers;
	}

	public function extractClass( $handler_name )
	{
		$h = explode( '.', $handler_name );

		if( isset($h[0]) && isset($h[1]) )
		{
			$this->getApp()->m( $h[0] );

			if( isset( $this->map()[$handler_name]) )
			{
				return $this->map()[$handler_name];
			}

			throw new \Exception( 'Module "'.$h[0].'" does not contains any handler named "'.$h[1].'" ' , 1);
		}

		throw new \Exception( 'Invalid handler name formate "'.$handler_name.'". Use <module_name>.<handler_name> ', 1 );
	}


	public function handle( $handler_name )
	{

		$handler_class = $this->extractClass( $handler_name );

		return $handler_class::I()->handle();
	}

}
