<?php namespace Jhul\Components\Database;

//TODO database from url

use \PDO;

class _PDOMaker
{

	protected $_adapter_map = [];

	protected  $pdoConf =
	[
		'error_mode'		=> \PDO::ERRMODE_EXCEPTION,

		'emulate_prepare'		=> TRUE,

		'charset'			=> 'utf8',
	];

	public function __construct()
	{
		$this->_adapter_map = require( __DIR__.'/_adapter_map.php' );
	}

	public function make( $p )
	{
		if( !isset( $this->_adapter_map[ $p['adapter'] ] ) )
		{
			throw new \Exception( 'Adapter Not Available For Database Type "'.$p['adapter'].'" ', 1);
		}

		$adapter =  $this->_adapter_map[ $p['adapter'] ];


		return new $adapter( $this->_makePDO($p) );
	}

	private function _makePDO( $p )
	{
		$pdo = new PDO( $p['adapter'].':host='.$p['host'].';dbname='.$p['name'], $p['username'], $p['password'] );

		foreach ($this->pdoConf as $key => $value)
		{
			if( empty($p[$key]) )
			{
				$p[$key] = $value;
			}
		}


		$pdo->setAttribute( \PDO::ATTR_ERRMODE, $p['error_mode'] );

		$pdo->setAttribute( \PDO::ATTR_EMULATE_PREPARES, $p['emulate_prepare'] );

		$pdo->exec( 'SET NAMES ' . $pdo->quote( $p['charset'] ) );

		return $pdo;
	}

}
