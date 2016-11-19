<?php namespace Jhul\Components\Database\Querybuilder;

abstract class Query
{

	private $_sql;

	protected $p =
	[

		'insert'	=> NULL,

		'select'	=> NULL,

		'update'	=> NULL,

		'fields'	=> NULL,

		'from'		=> NULL,

		'where'		=> NULL,

		'like'		=> NULL,

		'groupBy'	=> NULL,

		'having'	=> NULL,

		'orderBy'	=> NULL,

		'offset'	=> NULL,

		'limit'	=> NULL,

		'params'	=> [],

		'values'	=>'',
	];

	protected $params = [];

	function bindParam( $field, $value )
	{
		$this->params[ ':'.$field ] = $value ;
		return $this;
	}

	function build( )
	{

		$sql = '';
		foreach( $this->buildElements() as $e )
		{
			$sql .= ' '.$this->p[$e];
		}

		return trim($sql);
	}

	function data()
	{
		return $this->params();
	}

	function getParam( $key )
	{
		if( isset( $this->params[':'.$key] ) )
		{
			return $this->params[':'.$key] ;
		}
	}

	function limit( $limit )
	{
		$this->p['limit'] = 'LIMIT '.$limit;
		return $this ;
	}

	function offset( $offset )
	{
		if($offset > 0)
		{
			$this->p['offset'] = 'OFFSET '.$offset;

		}
		return $this ;
	}

	function orderBy( $field, $type )
	{
		$this->p['orderBy'] = 'ORDER BY `'.$field.'` '.$type;

		return $this;
	}

	function params()
	{
		return $this->params;
	}

	function raw()
	{
		$raw = $this->sql();

		foreach( $this->params as $key => $value ) { $raw = str_replace( $key, '\''.$value.'\'', $raw ); }

		return $raw;
	}

	function setFields( $fields )
	{
		$fields = str_replace( ' ', '', $fields );

		$this->p['fields'] = '`'.str_replace( ',', '`, `', $fields ).'`';

		return $this;
	}

	function setSql( $sql )
	{
		$this->_sql = $sql ;
		return $this;
	}

	function show()
	{
		return '\r\n SQL : '.$this->sql().'\r\n Data : '.json_encode($this->data());
	}

	function sql()
	{
		return $this->_sql ? $this->_sql : $this->_sql = $this->build() ;
	}

	function table( $table )
	{
		$this->p['table'] = '`'.$table.'`';
		return $this;
	}

	function __toString()
	{
		return $this->sql();
	}

	function where( $field, $value, $rel = '=' )
	{
		if( empty($this->p['where']) )
		{
			$this->p['where'] = 'WHERE `'.$field.'` '.$rel.' :'.$field;
		}
		else
		{
			$this->p['where'] .= ' AND `'.$field.'` '.$rel.' :'.$field;
		}


		return $this->bindParam( $field, $value );
	}

}
