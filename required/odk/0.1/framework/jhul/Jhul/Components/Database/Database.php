<?php namespace Jhul\Components\Database;

/* @Author : Manish Dhruw [saecoder@gmail.com]
+-----------------------------------------------------------------------------------------------------------------------
| Database Manager
| @Updated : [ 2016-July-07, 2016-July-08, ]
+=====================================================================================================================*/

class Database
{
	use \Jhul\Core\Design\Component\_Trait;

	const VERSION = '0.8';

	public $charSet = 'utf8';

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
	public function get( $name  )
	{
		if( !isset( $this->_connections[$name] ) )
		{
			if( !$this->config()->has('connections') ) { throw new \Exception('Database "connections" not configured', 1); }

			$connections = $this->config('connections');

			if( !isset($connections[$name]) ) { throw new \Exception( 'Database "'.$name.'" not defined in configuration file' , 1); }

			$this->_connections[ $name ] = $this->PDOMaker()->make( $connections[ $name ] );
		}

		return $this->_connections[ $name ] ;
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




	function fetchLastIdOfTable( $tableName )
	{
		return $this->executeStatement
		(
			" SELECT `AUTO_INCREMENT`
			FROM  INFORMATION_SCHEMA.TABLES
			WHERE TABLE_SCHEMA = '".$this->name()."'
			AND   TABLE_NAME   = '$tableName' "
		)
		->fetch();
	}
}
