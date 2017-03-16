<?php namespace Jhul\Components\Database\Adapter\PG\Statement\Types;

abstract class _Abstract implements \Jhul\Components\Database\Adapter\PG\Statement\Interfaces\_Statement
{

	protected $_p;

	//Binded values
	protected $_values = [];

	protected $_fetchMode = \PDO::FETCH_ASSOC;

	//YTable Object;
	protected $_table;

	function bindValue( $name, $value )
	{
		$this->_values[ ':'.$name ] = $value ;
		return $this;
	}

	function bindValues( $values )
	{
		foreach ($values as $name => $value)
		{
			$this->bindValue( $name, $value );
		}

		return $this;
	}

	function p( $key  ) { return isset($this->_p[$key]) ? $this->_p[$key] : '' ; }

	final public function setTable( $table )
	{

		if( is_object( $table ) )
		{
			$this->_table = $table;
			$this->_p['table_name'] = $this->_table->name();
		}

		if( is_string($table) )
		{
			$this->_p['table_name'] = $table ;
		}
		return $this;
	}

	public function table()
	{
		return $this->_table;
	}

	public function show()
	{
		return '<br/> Statement : "'.$this->make(). '"<br/> Values : '.$this->showValues();
	}

	public function showValues()
	{
		$string = '[';

		foreach ( $this->values() as $key => $value )
		{
			$string .= $key.'='.$value.'|';
		}

		return  trim( $string, '|' ) .']';
	}


	public function values(){ return $this->_values; }


	public function fetch()
	{
		if( empty( $this->_table ) )
		{
			throw new \Exception("Error Processing Request", 1);

		}

		return $this->table()->fetch( $this );
	}

	public function fetchAll()
	{
		return $this->table()->fetchAll( $this );
	}


	function executeThis( $pdo )
	{
		try
		{
			$preparedStatement = $pdo->prepare( $this->make() );
			$preparedStatement->execute( $this->values() ) ;
			return $preparedStatement;
		}
		catch ( \Exception $e)
		{
			throw new \Exception( $e->getMessage().$this->show() );
		}
	}

}
