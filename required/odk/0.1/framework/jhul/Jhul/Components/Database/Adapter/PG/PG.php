<?php namespace Jhul\Components\Database\Adapter\PG;


class PG
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

	public function stores()
	{
		return $this->_stores;
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

}
