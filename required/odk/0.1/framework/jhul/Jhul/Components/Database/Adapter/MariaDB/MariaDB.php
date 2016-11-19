<?php namespace Jhul\Components\Database\Adapter\MariaDB;


class MariaDB
{
	protected $_pdo;

	//Multiple stores of same class having different aspects can exists
	protected $_stores;

	public function __construct( $pdo )
	{
		$this->_pdo = $pdo;
	}

	public function pdo()
	{
		return $this->_pdo;
	}

	protected function _loadTableSchema( $name )
	{
		return  $this->makeStatement( 'show_columns' )->setTable($name)->cookData( $this->pdo() );
	}


	public function name()
	{
		if( NULL == $this->_name )
		{
			$pos = strrpos( $this->dsn, '='  ) ;

			$this->_name = substr( $this->dsn, $pos + 1 );
		}

		return $this->_name ;
	}

	public function executeStatement( $statement )
	{
		try
		{
			$preparedStatement = $this->pdo()->prepare( $statement->make() );
			$preparedStatement->execute( $statement->values() ) ;
			return $preparedStatement;
		}
		catch ( \Exception $e)
		{
			throw new \Exception( $e->getMessage().$statement->show() );
		}
	}

	//Tbale is common but statement cannot be shared
	//TODO use a better way to preven statement sharing
	public function getStore( $context_table )
	{
		if( isset( $this->_stores[ $context_table ] ) )
		{
			return $this->_stores[ $context_table ];
		}

		throw new \Exception( 'Table Mode "'.$context_table.'" Not Created ' );
	}

	public function hasStore( $context_table )
	{
		return isset( $this->_stores[$context_table] );
	}

	public function addStore( $context, $table )
	{
		 $this->_stores[$context] = $table;
	}

	public function makeStatement( $type = 'custom' )
	{
		return Statement\Statement::I()->make( $type );
	}

	// Return All tables of this database
	public function tables( $name = NULL )
	{
		if( empty( $this->_tables ) )
		{
			//TODO CUSTOM statement
			$tables = $this->executeStatement( $this->makeStatement( 'SHOW TABLES' ) )->fetchAll();

			foreach ($tables as $value)
			{
				$this->_tables[ $value[0] ] = [];
			}
		}

		if( !empty( $name ) )
		{
			if( array_key_exists( $name, $this->_tables ) )
			{
				if( empty( $this->_tables[$name] ) )
				{

					$this->_tables[$name]['columns'] = $this->_loadTableSchema( $name );
				}

				return $this->_tables[$name] ;
			}

			return [];
		}

		return $this->_tables;
	}
}
