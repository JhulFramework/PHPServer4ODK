<?php namespace Jhul\Components\Database\Adapter\PG\Statement\Types;

class Custom extends _Abstract
{
	protected $_query;

	function __construct( $query = '' )
	{
		$this->_query = $query;
	}

	function setQuery( $query )
	{
		$this->_query = $query;

		return $this;
	}

	function append( $query )
	{
		$this->_query .= ' '.$query;
		return $this;
	}

	function make()
	{
		return $this->_query;
	}
}
