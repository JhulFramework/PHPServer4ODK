<?php namespace Jhul\Components\Database\Adapter\PG\Statement\Types;

class Delete extends _Abstract
{

	use \Jhul\Components\Database\Adapter\PG\Statement\Traits\Where;

	public function setTable( $table )
	{
		$this->_p['table'] = $this->tick($table) ;
		return $this;
	}

	public function make()
	{
		return 'DELETE  FROM '.$this->p('table').$this->makeWhere();
	}

}
