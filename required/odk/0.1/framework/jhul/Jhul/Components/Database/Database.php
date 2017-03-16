<?php namespace Jhul\Components\Database;

/* @Author : Manish Dhruw [saecoder@gmail.com]
+=======================================================================================================================
| Database Manager
| @Updated : [ 2016-July-07, 2016-July-08, ]
+---------------------------------------------------------------------------------------------------------------------*/

class Database
{
	use \Jhul\Core\Design\Component\_Trait;

	const VERSION = '0.8';

	public $charSet = 'utf8';

	protected $_selected_db = 'default';

	public function __construct( $params )
	{
		$this->config()->add( $params );
	}

	public function pdoConf( $key = NULL )
	{
		if( array_key_exists( $key, $this->pdoConf ) ) return $this->pdoConf[$key] ;
		return $this->pdoConf ;
	}


	//ldifferentc types of loaded databse
	protected $_connections = [] ;

	public function pdoConnections()
	{
		return $this->_connections;
	}

	//@Param $name = databse configuartion name, defined in databse configuration file
	public function selectDB( $name )
	{
		$this->_selected_db = $name ;
		return $this;
	}

	public function getDB()
	{
		if( !isset( $this->_connections[ $this->_selected_db ] ) )
		{
			if( !$this->config()->has('connections') ) { throw new \Exception('Database "connections" not configured', 1); }

			$connections = $this->config('connections');

			if( !isset($connections[ $this->_selected_db ]) ) { throw new \Exception( 'Database "'.$this->_selected_db.'" not defined in configuration file' , 1); }

			$this->_connections[ $this->_selected_db ] = $this->PDOMaker()->make( $connections[ $this->_selected_db ] );
		}

		return $this->_connections[ $this->_selected_db ] ;
	}

	protected $_PDOMaker;

	public function PDOMaker()
	{
		if( empty($this->_PDOMaker) )
		{
			$this->_PDOMaker = new _PDOMaker;
		}

		return $this->_PDOMaker;
	}

	protected $_stores = [];

	public function getStore( $storeClass )
	{
		if(empty($this->_stores[$storeClass]))
		{
			//$class = $this->_stores[$storeClass];

			if( !class_exists( $storeClass ) )
			{
				throw new \Exception("  Error Processing Request ".$storeClass, 1);

			}

			$this->_stores[$storeClass] = new $storeClass;
		}

		return $this->_stores[$storeClass];
	}


	public final function fetch( $queryBuilder )
	{
		$pdos = $this->getDB()->executeStatement( $queryBuilder );

		$record = $pdos->fetch( \PDO::FETCH_ASSOC );

		$pdos = NULL; //NOT tested if it is required

		return $record;
	}

	public function fetchAll( $queryBuilder )
	{
		$statement = $this->getDB()->executeStatement( $queryBuilder );

		$rows = $statement->fetchAll( \PDO::FETCH_ASSOC );

		$statement = NULL; //NOT tested if it is required

		return $rows;
	}



}
