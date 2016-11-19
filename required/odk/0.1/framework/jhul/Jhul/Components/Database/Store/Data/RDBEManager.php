<?php namespace Jhul\Components\Database\Store\Data;

//ciomponent entities are only created when all create paarms exists nad not null
//TODO extract and use coommeon code from shared object
class RDBEManager
{
	//@Structure: [$name => $entityClass]
	protected $_map = [];

	protected $_store;

	// one to one, which is mustt
	protected $_components = [];

	private function afterCreate( $name, $element )
	{
		if( $this->has( $name, 'after_create' ) )
		{
			$method = $this->params( $name, 'after_create' );
			echo '<br/> FILE : '.__FILE__;
			echo '<br/> LINE : '.__LINE__;
			echo '<pre>';
			var_dump('after create is deprecated');
			echo '</pre>';
			echo '<pre>';
			var_dump($method);
			echo '</pre>';
			echo '<pre>';
			var_dump($this->store());
			echo '</pre>';
			exit();


			return $this->store()->$method( $element );
		}

		return $element;
	}

	public function __construct( $store )
	{
		$this->_store = $store ;
	}

	//all find fields should not be empty
	public function find( $name )
	{
		$params =  $this->params( $name, 'search' );

		foreach ( $params as $key => $value)
		{
			if(empty($value)) return ;
		}

		return $this->getRDB($name)->byParams( $params  )->fetch();
	}

	// for craeteing entity all paramas must be provided
	public function create( $name )
	{

		$e = $this->find($name);

		if( empty( $e ) )
		{

			if( $this->has($name, 'creator') )
			{
				$creator = $this->params( $name, 'creator' );

				return (new $creator( $this->store() ) )->create() ;
			}

			$params = $this->params( $name, 'create' );



			$e = $this->getRDB($name)->make( $params );

			if( !empty( $e ) )
			{
				return $this->afterCreate( $name, $e );
			}


			throw new \Exception( 'Unable to create component "'.$name.'" for "'.get_class( $this->_store ).'" ' , 1);
		}

		throw new \Exception( 'Component "'.$name.'" already exists ' , 1);
	}

	public function register( $name, $entityClass )
	{
		$this->_map[$name]  = $entityClass;
	}

	public function getClass( $name )
	{
		if( $this->has($name) )
		{
			return $this->map()[$name]['class'];
		}

		throw new \Exception( 'Relative Database Entity "'.$name.'" Not Found ' , 1);
	}

	public function getRDB( $name )
	{
		$class = $this->getClass( $name ) ;

		$store = $class::I()->store();



		if( $this->hasFlag($name, 'L') )
		{
			echo '<br/> FILE : '.__FILE__;
			echo '<br/> LINE : '.__LINE__;
			echo '<pre>';
			var_dump( $this->store() );
			echo '</pre>';
			exit();
			$store->setLipi( $this->store()->lipi() );
		}

		return $store;
	}

	public function has( $name, $type = NULL )
	{
		if( !empty($type) )
		{
			return !empty( $this->map()[$name][$type] );
		}
		return isset( $this->map()[$name] );
	}

	public function hasFlag( $name, $flag )
	{
		return  $this->has( $name, 'flags' ) && FALSE !== strpos( $this->params($name, 'flags'), $flag );
	}

	//find relative entity
	public function _e( $name, $createIfNotExists = FALSE )
	{
		$e = $this->find($name);


		if( empty($e)  )
		{

			$e = $this->getNullObject( $name );
		}

		if( $createIfNotExists && ( empty( $e ) || $e->isNull()  ) )
		{
			$e = $this->create( $name );
		}

		return $e;
	}

	//find relative entity
	public function e( $name, $createIfNotExists = FALSE )
	{
		if( empty( $this->_components[$name] ) )
		{
			$this->_components[$name] = $this->_e( $name );

			if( $createIfNotExists && ( empty( $e ) || $e->isNull()  ) )
			{
				$this->_components[$name] = $this->_e( $name, TRUE );
			}
		}

		return $this->_components[$name];
	}

	public function unload( $name )
	{
		if( isset($this->_components[$name]) )
		{
			unset( $this->_components[$name] );
		}
	}

	public function getNullObject( $name )
	{
		if( $this->has($name, 'null')  )
		{
			$nullClass = $this->params( $name, 'null' );

			if( !class_exists( $nullClass ) )
			{
				throw new \Exception( 'Class "'.$nullClass.'" Not Found For "'.get_class($this->store()).'" ', 1);
			}

			return new $nullClass( $this->store() );
		}
	}

	public function params( $name, $type )
	{
		$params = $this->_params($name , $type );

		if( empty($params) )
		{
			if( ($type == 'search') || ($type == 'create') ) return $this->_params( $name, 'connect' );
		}

		return $params;
	}

	protected function _params( $name , $type )
	{

		if( isset( $this->map()[$name][$type] ) )
		{
			$p  =  $this->map()[$name][$type];

			if( is_array( $p  ) )
			{
				$params = [];

				foreach ( $p as $cName => $value )
				{
					if(  strpos( $value, '.' ) )
					{
						$d = explode('.', $value);

						$method = $d[1];

						if( 'store' == $d[0] )
						{
							$params[ $cName ] = $this->store()->$method() ;
						}

						else
						{

							$params[ $cName ] = $this->e( $d[0] )->$method() ;
						}
					}
					else
					{
						$params[ $cName ] = $value ;
					}
				}

				return $params;
			}

			return $p;
		}
		return [];
	}

	//@Structure: [$name => $entityClass]
	public function map()
	{
		return $this->store()->elementMap();
	}

	public function store()
	{
		return $this->_store;
	}
}
