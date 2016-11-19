<?php namespace Jhul\Components\Database\Adapter\PG\Statement\Types;

class Insert extends _Abstract
{
	function setData( $data )
	{
		$this->_p['insert_columns']	= '';
		$this->_p['insert_values']	= '';

		foreach( $data as $f => $v )
		{
			$this->_p['insert_columns'] .= '`'.$f.'`,';
			$this->_p['insert_values'] .= ':'.$f.',';
			$this->bindValue($f, $v);
		}

		$this->_p['insert_columns'] = trim( trim($this->_p['insert_columns']), ',');
		$this->_p['insert_values'] = trim( trim($this->_p['insert_values']), ',');

		return $this;
	}


	function make()
	{
		return 'INSERT INTO '.$this->p('table_name').' ('.$this->p('insert_columns').') VALUES ('.$this->p('insert_values').') ';
	}

}
