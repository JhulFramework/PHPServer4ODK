<?php namespace Jhul\Core\Application\DataType;

class Manager
{

	use \Jhul\Core\_AccessKey;

	private static $_I;

	protected $_loaded = [];

	protected $_dataTypeMap = [];

	//files containing datatype config
	protected $_config_files = [];

	public function __construct()
	{
		$this->_dataTypeMap =
		[
			'string'	=> __NAMESPACE__.'\\Types\\String\\Attribute',
			'email'	=> __NAMESPACE__.'\\Types\\Email\\Attribute',
			'alpha'	=> __NAMESPACE__.'\\Types\\Alpha\\Attribute',
			'alnum'	=> __NAMESPACE__.'\\Types\\Alnum\\Attribute',
			'pdn'		=> __NAMESPACE__.'\\Types\\PDN\\Attribute',
			'image' 	=> __NAMESPACE__.'\\Types\\Image\\Attribute',
		];
	}

	public function dataTypes()
	{
		return $this->_dataTypeMap;
	}


	public function register( $name, $class = NULL, $overwrite = FALSE )
	{
		//mass
		if( is_array($name))
		{
			foreach ($name as $n => $c)
			{
				$this->register($n, $c, $overwrite );
			}

			return;
		}

		//singular
		if( is_array($class) )
		{
			if( isset($class['config']) )
			{
				$file = $class['config'].'.php';

				if( !file_exists($file) )
				{
					throw new \Exception( 'Data Type "'.$name.'" config file "'.$file.'" Not Found ' , 1);
				}

				$this->_config_files[$name] = $file;
			}

			if( isset($class['class']) )
			{
				$class = $class['class'];
			}
		}


		if( is_string($class) )
		{
			if( (isset($this->_dataTypeMap[$name]) &&  $class != $this->_dataTypeMap[$name] ) && !$overwrite )
			{
				throw new \Exception( 'Data Type name "'.$name.'" for class "'.$class.'" is already used by "'.$this->_dataTypeMap[$name].'"' , 1);
			}

			if( empty($class) )
			{
				throw new \Exception( 'Data Type "'.$name.'"\'s class must not be empty ' );
			}

			if( !class_exists($class) )
			{
				throw new \Exception( 'Data Type "'.$name.'" class "'.$class.'" does not exists' );
			}

			$this->_dataTypeMap[ $name ] = $class;
		}
	}

	public function get( $name, $newDefinition = NULL )
	{
		if( isset( $this->_loaded[$name.$newDefinition] ) ) return $this->_loaded[$name.$newDefinition];

		return $this->_get( $name, $newDefinition );

	}


	protected function _get( $name, $newDefinition )
	{
		if( $this->hasDataType( $name ) )
		{
			$class = $this->dataTypes()[$name];

			$dataType = new $class;

			if( isset($this->_config_files[$name]) )
			{
				$config = $this->J()->fx()->loadConfigFile( $this->_config_files[$name] );

				$dataType->config()->add($config, NULL, TRUE);
			}

			if( !empty($newDefinition) )
			{
				$dataType->config()->add( 'definition', $newDefinition, TRUE );
			}

			$this->_loaded[$name.$newDefinition] = $dataType;

			return $this->_loaded[$name.$newDefinition];
		}

		throw new \Exception( 'Data Type "'.$name.'" Not Found', 1 );
	}

	public function hasDataType($type)
	{
		return isset( $this->_dataTypeMap[$type] );
	}

}
