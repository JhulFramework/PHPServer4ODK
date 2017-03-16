<?php namespace Jhul\Components\Database\Adapter\PG\Statement\Types;

class ShowColumns extends _Abstract
{



	function full()
	{
		$this->_p['full'] = 'FULL';
		return $this;
	}

	function isFull()
	{
		return $this->p('full') == 'FULL';
	}

	function make()
	{
		return 'SHOW '.$this->p('full').' COLUMNS IN '.$this->p('table_name');
	}


	function cookData( $pdo )
	{
		$_result = $this->executeThis( $pdo )->fetchAll( $this->_fetchMode );

		$result = [];

		foreach ($_result as $r)
		{
			$result[ $r['Field'] ] = $r;
		}

		return $result;
	}


	function __toString()
	{
		return $this->make();
	}
}
