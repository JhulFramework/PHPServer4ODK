<?php namespace Jhul\Core\Application\Module;

/* @Author : Manish Dhruw [1D3N717Y12@gmail.com]
+=======================================================================================================================
| Module Store
|
|
+---|Module Boot Process|
|
|	-Register/Load  Configurations
|		- load Main Configurations
|		- register _class_map
|		- register elements
|		- register activities
|		- register handlers
|
|	-Register Resources
|		- register view files
|		- register css files
|		- register view dependency files
|		- register translation file map
|
|@Updated : [ 2016-august-01, 2016-Oct-01, 2016-Oct-16, 2017-02-12 ]
+---------------------------------------------------------------------------------------------------------------------*/

class Store
{

	use \Jhul\Core\_AccessKey;

	protected $_module_map = [];

	//TODO Cache it, and check performance
	protected $_loaded_module = [];

	public function __construct( $modules )
	{
		$this->_module_map = $modules;
	}

	//@Params : $name = name of module
	public function g( $name )
	{
		if( !isset( $this->_loaded_module[$name] ) )
		{
			if( !isset( $this->_module_map[ $name ] ) )
			{
				throw new \Exception( 'Module "'. $name .'" Not Mapped ' , 1 );
			}

			$this->load( $name );
		}

		return $this->_loaded_module[ $name ];
	}

	protected function load( $name )
	{
		$module_path = $this->J()->fx()->dirPath( $this->_module_map[$name] );

		$this->J()->cx('classmapper')->register
		(
			 $this->J()->fx()->loadConfigFile(  $module_path.'/config/_classmap', FALSE )
		);

		$module = ( new $this->_module_map[$name] )->_s( 'path', $module_path ) ;

		$this->_loaded_module[ $name ] = $module;

		$this->getApp()->configLoader()->registerPages( $module->path(), $module->name() );

		$this->getApp()->configLoader()->registerHandlers( $module->path(), $module->name() );

		$this->getApp()->configLoader()->load( $this->_loaded_module[ $name ] ) ;

	}

	public function __toString()
	{
		return json_encode( $this->_module_map );
	}
}
