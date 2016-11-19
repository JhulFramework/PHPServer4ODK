<?php namespace Jhul\Core;

/* @Author : Manish Dhruw <1D3N717Y12@gmail.com>
+=======================================================================================================================
| @Created 2016:Oct-07
|
| Component Loader
|
| psuedo :
|	$_paths
|	$_config_files
|	$_config_override
|
|	setPath($path)
|	registerConfigFile( $dep_name, $file_path )
|	registerConfigFiles( $map )
|	_create() //creates the dependency object
|	_init() //initializes dependency object
+---------------------------------------------------------------------------------------------------------------------*/

class CX
{
	use _AccessKey;

	//paths to look for Dependency config file
	protected $_paths = [];

	//Dependency Congig file map
	protected $_config_files = [];

	// can overrid configs at run time
	protected $_override_config = [];

	//loaded Components
	//@Structure = [ 'name' => {component Object} ]
	protected $_components = [] ;

	//Map of passive components
	//@Structure = [ 'name' => 'name\\of\\class' ]
	protected $_passive = [];

	protected $_params = [];

	public function get($name)
	{
		if( isset($this->_components[$name]) ) return $this->_components[$name];

		return $this->_get($name);
	}

	private function _get($name)
	{
		$this->_components[$name] = NULL;

		$this->inject( $this->_components[$name], $name );

		return $this->_components[$name];
	}

	//returns Component Configuration file
	public function getFile( $name, $required = TRUE )
	{

		foreach ( $this->paths() as $path )
		{
			$file = $path.'/'.$name.'.php';

			if( is_file($file) ) return $file;

			if( isset( $this->_config_files[$name] ) ) return $this->_config_files[$name] ;
		}

		if($required)
		{
			throw new \Exception( 'Dependency "'.$name.'" Not Configured', 1);
		}
	}


	//Inject and initilaize dependency
	//It is posiible to modify it and provide __constructor param from here
	public function inject( &$property, $dep_name, $params = [] )
	{
		$params = $this->_loadParams( $dep_name, $params );

		if( isset( $this->_passive[$dep_name] ) )
		{
			$class = $this->_passive[$dep_name];

			$property = new $class($params);

			return;
		}

		$config = $this->_loadConfig( $dep_name.'/_loader' );

		//component must be created and assigned before intializing
		$property = $this->_create( $config, $params);

		$property = $this->_init( $property, $config, $params );
	}

	protected function _loadParams( $dep_name, $params )
	{
		if( isset( $this->_params[$dep_name] ) )
		{
			$params = $this->_params[$dep_name];
		}

		return array_merge( $this->J()->fx()->loadConfigFile( $this->getFile( $dep_name.'/_params', FALSE ) , FALSE ), $params );
	}

	protected function _create( $config, $params )
	{
		$class = $config['class'];

		$dep = new $class( $params ) ;

		if( method_exists($dep, 'config') )
		{
			$dep->config()->add( $params );
		}

		if( isset( $config['create'] ) )
		{
			$creator = $config['create'];

			$dep = $creator( $dep, $params );
		}

		return $dep;
	}

	//@params (object) $com
	protected function _init( $com, $config, $params )
	{
		if( isset( $config['init'] ) )
		{
			$initializer = $config['init'];

			$com = $initializer( $com, $params );
		}
		return $com;
	}

	protected function _loadConfig( $name )
	{
		$config = $this->J()->fx()->loadConfigFile( $this->getFile( $name ) );

		if( isset( $this->_override_config[ $name ] ) )
		{
			foreach( $this->_override_config[ $name ] as $key => $value )
			{
				$config[$key] = $value ;
			}
		}

		if( isset( $config['required'] ) )
		{
			foreach( $config['required']  as $key => $value )
			{
				if( empty( $config[$key] ) )
				{
					throw new \Exception( 'Please provide constructor params for dependency "'.$name.'" '.json_encode($value) , 1);
				}
			}
		}

		return $config;
	}

	public function map()
	{
		return $this->_dep_config;
	}


	public function paths()
	{
		return $this->_paths;
	}

	public function setDependency( $name, $config_file, $overwrite = FALSE )
	{
		if( !is_file( $config_file ) )
		{
			throw new \Exception( 'Configuration file "'.$config_file.'" for dependency "'.$name.'" not found' , 1);
		}

		if( !$this->has($name) || $overwrite )
		{
			$this->_dep_config[$name] = $config;
		}

		throw new \Exception("Error Processing Request", 1);

	}



	//@param: $name (dependency name)
	public function setParams( $name, $params )
	{
		if( $this->has($name) )
		{
			$this->_override_config[$name]['params'] = $params;
		}

		return $this;
	}

	//set the path to look for configs nad loads shared configs
	public function setPath( $path )
	{
		$this->_passive = array_merge(  $this->J()->fx()->loadConfigFile( $path.'/_passive', FALSE ), $this->_passive );
		$this->_params = array_merge(  $this->J()->fx()->loadConfigFile( $path.'/_params', FALSE ), $this->_params );
		$this->_paths[] = $path;
	}
}
