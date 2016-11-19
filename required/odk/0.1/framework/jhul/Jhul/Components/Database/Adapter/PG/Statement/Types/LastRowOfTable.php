<?php namespace Jhul\Components\Database\Adapter\PG\Statement\Types;

class LastRowOfTable extends _Abstract
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
		return 'SELECT `AUTO_INCREMENT`
		FROM  INFORMATION_SCHEMA.TABLES
		WHERE TABLE_SCHEMA = '".$this->name()."'
		AND   TABLE_NAME   = '$tableName' "
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
