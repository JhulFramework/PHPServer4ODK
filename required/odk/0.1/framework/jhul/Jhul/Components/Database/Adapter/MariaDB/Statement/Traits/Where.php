<?php namespace Jhul\Components\Database\Adapter\MariaDB\Statement\Traits;

trait Where
{
	protected $_made = FALSE;

	final function byParams( $params )
	{
		foreach ( $params as $key => $value)
		{
			$this->where( $key, $value);
		}
		return $this;
	}

	final function where( $field, $value, $relation = '=' )
	{
		$this->_p['where'][] = '( `'.$field.'` '.$relation.' :'.$field.' )';

		return $this->bindValue( $field, $value );
	}

	public function whereIn( $column, $_values )
	{
		$values = '';

		foreach ( $_values as $v )
		{
			$values .= ' \''.$v.'\',';
		}

		$this->_p['where_in'] = '`'.$column.'` IN ('. trim($values,',').' )' ;

		return $this;
	}

	// function makeAnd()
	// {
	// 	$and = '';
	//
	//
	// 	if( !empty( $this->_p['where']['AND']  ) )
	// 	{
	// 		if( TRUE == $this->_made ) $and .= ' AND';
	//
	// 		$this->_made = TRUE;
	// 		$and .= implode( ' AND ', $this->_p['where']['AND']  );
	// 	}
	//
	// 	return $and;
	// }

	public function makeIn()
	{
		if( isset( $this->_p['where_in'] ) )
		{
			return ' '.$this->_p['where_in'];
		}
	}

	final function makeWhere()
	{
		if( isset( $this->_p['where'] ) )
		{
			return ' WHERE'.$this->makeIn().' '.implode( ' AND ', $this->_p['where'] );
		}

		if( isset( $this->_p['where_in'] ) )
		{
			return ' WHERE'.$this->makeIn();
		}
	}

}
