<?php namespace Jhul\Components\Database\Adapter\PG\Statement\Traits;

trait RowQueryParams
{
	protected $_qp = [];

	function limit( $limit )
	{
		$this->_qp['limit'] = 'LIMIT '.$limit;

		return $this;
	}

	function orderBy( $name, $order  )
	{
		$this->_qp['order_by'] = 'ORDER BY '.$this->quote($name).' '.$order;
		return $this;
	}

	function groupBy( $groupBy )
	{
		$this->_qp['group_by'] = 'GROUP BY '.$this->quote($groupBy);
		return $this;
	}

	function having( $field, $value, $relation = '=' )
	{
		$this->_p['having'][] = '( `'.$field.'` '.$relation.' :'.$field.' )';

		return $this->bindValue( $field, $value );
	}

	function offset( $offset )
	{
		$this->_qp['offset'] = 'OFFSET '.$offset;

		return $this;
	}

	function qp( $name )
	{
		if( isset( $this->_qp[$name] ) )
		{
			return ' '.$this->_qp[$name] ;
		}
	}

	function makeHaving()
	{
		if( !empty( $this->_p['having'] ) )
		{
			return ' HAVING '.implode( ' AND ', $this->_p['having']  );
		}
	}

	function makeRowQueryParams()
	{
		return $this->qp('group_by').$this->makeHaving().$this->qp('order_by').$this->qp('limit').$this->qp('offset');
	}


}
