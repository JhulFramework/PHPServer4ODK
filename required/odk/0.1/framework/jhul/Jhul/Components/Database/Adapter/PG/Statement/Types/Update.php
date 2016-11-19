<?php namespace Jhul\Components\Database\Adapter\PG\Statement\Types;

class Update extends _Abstract
{
	use \Jhul\Components\Database\Adapter\PG\Statement\Traits\Where;

	function setData( $data )
	{
		$columns = '';

		foreach( $data as $name => $value )
		{
			$columns .= '`'.$name.'` = :'.$name.',';

			$this->bindValue($name, $value);
		}

		$this->_p['update_columns'] = trim( trim($columns), ',' );

		return $this;
	}

	function make()
	{
		return 'UPDATE '.$this->p('table_name').' SET '.$this->p('update_columns').' '.$this->makeWhere();
	}
}
