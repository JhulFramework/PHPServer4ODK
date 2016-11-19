<?php namespace Jhul\Components\Database\Adapter\MariaDB\Statement\Types;

class Delete extends _Abstract
{

	use \Jhul\Components\Database\Adapter\MariaDB\Statement\Traits\Where;

	public function make()
	{
		return 'DELETE  FROM '.$this->p('table_name').$this->makeWhere();
	}

}
