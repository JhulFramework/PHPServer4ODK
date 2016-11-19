<?php namespace Jhul\Components\Database\Adapter\PG\Statement\Traits;

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
		$this->_p['where']['AND'][] = '( `'.$field.'` '.$relation.' :'.$field.' )';

		return $this->bindValue( $field, $value );
	}

	function makeAnd()
	{
		$and = '';

		if( TRUE == $this->_made ) $and .= ' AND';

		if( !empty( $this->_p['where']['AND']  ) )
		{
			$this->_made = TRUE;
			$and .= implode( ' AND ', $this->_p['where']['AND']  );
		}

		return $and;
	}

	function makeIn()
	{
		if( isset( $this->_p['where']['IN'] ) )
		{
			$this->_made = TRUE ;
			return $this->_p['where']['IN'];
		}
	}

	final function makeWhere()
	{
		if( !empty( $this->_p['where'] ) )
		{
			return ' WHERE '.$this->makeIn().$this->makeAnd();
		}
	}

	function in( $name, $keys )
	{

		$in = '';

		foreach ( $keys as $key )
		{
		 	$in .= '\''.$key.'\',';
		}

		if( !empty( $in ) )
		{
			$in = trim( $in , ',' );

			$this->_p['where']['IN'] = $this->tick($name).' IN  ('.$in.')';
		}

		return $this;
	}
}
