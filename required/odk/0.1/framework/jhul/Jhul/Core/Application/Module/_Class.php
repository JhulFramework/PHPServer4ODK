<?php namespace Jhul\Core\Application\Module ;

/* @Author Manish Dhruw [1D3N717Y12@gmail.com]
+=======================================================================================================================
| @Responsibilities
| -loads configuration from module
|
| @Created
| -Friday 19 December 2014 08:23:15 PM IST
|
| @Updated
| -Saturday 23 May 2015 06:21:56 PM IST
| -Sun 15 Nov 2015 07:25:41 PM IST
| -[2016-Oct-01]
+---------------------------------------------------------------------------------------------------------------------*/

abstract class _Class
{

	use \Jhul\Core\Design\Component\_Trait;
	use \Jhul\Core\Design\Trunk\_Trait;

	protected $_path;

	public $elementMap = [];

	//Name of the module
	protected $_name ;

	public function name()
	{
		if( empty($this->_name) )
		{
			$paths = explode('\\', trim( get_called_class(), '\\' ) );

			$k = array_search( '_modules', $paths );

			if( FALSE === $k ) return;

			$this->_name = strtolower( $paths[ $k + 1 ] );

		}

		return $this->_name;
	}

	public function elementMap()
	{
		return $this->elementMap;
	}

	public static function getClass() { return static::class; }

	// public function hasActivity( $activity )
	// {
	// 	return isset( $this->activityMap[$activity] );
	// }

	// public function handler( $handlerI )
	// {
	// 	if( isset( $this->nodeHandlerMap[ $handlerI ] ) )
	// 	{
	// 		$class = $this->nodeHandlerMap[ $handlerI ] ;
	//
	// 		return new $class;
	// 	}
	//
	// 	throw new \Exception( 'Handler Not Found Found for Path "'.$handlerI.'" for module "'.get_called_class().'" ' );
	// }

	// public function handleActivity( $activity )
	// {
	// 	if( $this->hasActivity( $activity ) )
	// 	{
	// 		return $this->runActivity(  $this->activityMap[ $activity ] );
	// 	}
	//
	// 	throw new \Exception( 'Activity '.$activity.' Not Found' );
	// }


	// public function handle( $handlerId  )
	// {
	// 	return $this->handler( $handlerId )->handle();
	// }

	public function path()
	{
		return $this->_path;
	}

	// public function resourceDirectoryPath()
	// {
	// 	return $this->path().'/'.$this->resourceDirectory;
	// }

	public function loadResource( $fileName )
	{
		$data = require( $this->path().'/res/'.$fileName.'.php' );

		return is_array( $data ) ? $data : [] ;
	}

	public function _s( $prop, $value )
	{
		$prop = '_'.$prop;

		$this->$prop = $value;

		return $this;
	}
}
