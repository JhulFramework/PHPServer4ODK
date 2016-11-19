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
|@Updated : [ 2016-august-01, 2016-Oct-01, 2016-Oct-16 ]
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

		$this->_loaded_module[ $name ] = ( new $this->_module_map[$name] )->_s( 'path', $module_path ) ;
		$this->getApp()->configLoader()->load( $this->_loaded_module[ $name ] ) ;

		// $res = $this->loadConfigFile( $module->path().'/res/_res', FALSE );
		//
		// if( !empty($res) )
		// {
		// 	$this->registerResources( $res );
		// }
		//
		// $this->_loaded_module[ $name ] = $module;
	}

	// protected function configureModule( $module )
	// {
	// 	$module->_s( 'path', $this->J()->fx()->dirPath( $module->getClass() ) );
	//
	// 	$module->data()->add
	// 	(
	// 		$this->loadConfigFile( $module->path().'/config/_main', FALSE )
	// 	);
	//
	// 	$this->getApp()->activityManager()->register
	// 	(
	// 		$module->name(),
	// 		$this->loadConfigFile( $module->path().'/config/_activities' )
	// 	);
	//
	// 	$this->getApp()->handlerManager()->register
	// 	(
	// 		$module->name(),
	// 		$this->loadConfigFile( $module->path().'/config/_handlers' )
	// 	);
	//
	// 	$module->elementMap = $this->loadConfigFile( $module->path().'/config/elements/_map', FALSE );
	//
	// 	return $module;
	// }

	//
	// public function validateClassExists( $map, $file )
	// {
	// 	foreach ( $map as $key => $class)
	// 	{
	// 		if( !class_exists($class) )
	// 		{
	// 			throw new \Exception( 'Class "'.$class.'" does not exists defined in file "'.$file.'" ' , 1);
	// 		}
	// 	}
	//
	// 	return $map;
	// }


	// protected function registerResources( $res )
	// {
	// 	$res = array_merge( [ 'views'=>'', 'styles' =>'', 'i18n'=> '' ], $res );
	//
	//
	// 	if( $this->getApp()->getUserclient()->ifConsumes( 'webpage' )  )
	// 	{
	//
	// 		$this->getApp()->outputAdapter()->view()->register
	// 		(
	// 			$this->loadConfigFile( $res['views'], FALSE )
	// 		);
	//
	//
	// 		$this->getApp()->outputAdapter()->style()->register
	// 		(
	// 			$this->loadConfigFile( $res['styles'], FALSE )
	// 		);
	// 	}
	//
	// 	$this->J()->cx('lipi')->register( $this->loadConfigFile( $res['i18n'], FALSE  ) );
	// }
	//
	//
	// protected function loadConfigFile( $file, $required = TRUE )
	// {
	// 	return $this->J()->fx()->loadConfigFile( $file, $required );
	// }

	public function __toString()
	{
		return json_encode( $this->_module_map );
	}
}
