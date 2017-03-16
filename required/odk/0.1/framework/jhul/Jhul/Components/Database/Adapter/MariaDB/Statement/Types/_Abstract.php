<?php namespace Jhul\Components\Database\Adapter\MariaDB\Statement\Types;

abstract class _Abstract implements \Jhul\Components\Database\Adapter\MariaDB\Statement\Interfaces\_Statement
{

	protected $_p;

	//Binded values
	protected $_values = [];

	protected $_fetchMode = \PDO::FETCH_ASSOC;

	//YTable Object;
	protected $_dispenser;


	public function bindValue( $name, $value )
	{
		$this->_values[ ':'.$name ] = $value ;
		return $this;
	}

	public function bindValues( $values )
	{
		foreach ($values as $name => $value)
		{
			$this->bindValue( $name, $value );
		}

		return $this;
	}

	public function getDBM()
	{
		return \Jhul::I()->cx('dbm');
	}

	function p( $key  ) { return isset($this->_p[$key]) ? $this->_p[$key] : '' ; }

	function tick( $name ){ return '`'.$name.'`' ; }

	final public function setTable( $name )
	{
		$this->_p['table_name'] = $this->tick($name);

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
			if( is_array( $value) )
			{
				$value = '('.implode('|', $value).')' ;
			}

			$string .= $key.'='.$value.'|';
		}

		return  trim( $string, '|' ) .']';
	}


	final public function values(){ return $this->_values; }

	public function fetch()
	{
		return $this->cookItem( $this->getDBM()->fetch($this), $this->show() );
	}

	public function fetchAll()
	{
		$record = $this->getDBM()->fetchAll($this) ;

		$items = [];

		foreach ($record as $r)
		{
			$items[] = $this->cookItem( $r, $this->show() );
		}
		return $items;
	}


	public function executeThis( $pdo )
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
