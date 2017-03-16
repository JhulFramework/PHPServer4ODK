<?php namespace Jhul\Components\Database\Adapter\MariaDB\Statement\Types;

class Select extends _Abstract
{
	use \Jhul\Components\Database\Adapter\MariaDB\Statement\Traits\Where;
	use \Jhul\Components\Database\Adapter\MariaDB\Statement\Traits\RowQueryParams;

	final function selectAll()
	{
		$this->_p['selected_columns'] = '*' ;
		return $this;
	}

	final function select( $columns )
	{
		if( is_string( $columns ) )
		{
			if( $columns == '*' )
			{
				$this->_p['selected_columns' ] = ' *' ;
			}
			elseif( strpos($columns,':') )
			{
				$columns = explode( ':', $columns );
				return $this->select($columns);
			}
			else
			{
				$this->_p['selected_columns'] = ' '.$this->tick(trim($columns));
			}
			return $this;
		}

		$selected = '';

		foreach ( $columns as $columnName )
		{
			$selected .= ' '.$this->tick( $columnName ).',';
		}

		$this->_p['selected_columns'] = trim($selected, ',');

		return $this;
	}

	protected function _make()
	{
		return 'SELECT'.$this->p('selected_columns').' FROM '.$this->p('table_name').$this->makeWhere().$this->makeRowQueryParams();
	}

	function make()
	{
		if( empty( $this->_p['selected_columns'] ) )
		{
			throw new \Exception( 'Nothing Is Selected in select statement "'.$this->_make().'"' , 1);
		}

		return $this->_make();
	}

}
