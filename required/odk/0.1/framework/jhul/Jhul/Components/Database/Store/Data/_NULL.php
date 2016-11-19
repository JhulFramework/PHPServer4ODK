<?php namespace Jhul\Components\Database\Store\Data;

/* @Author : Manish Dhruw [ 1D3N717Y12@gmail.com ]
+=======================================================================================================================
| @Createdd :2016-Sep-05
+---------------------------------------------------------------------------------------------------------------------*/

class _NULL
{

	protected $_sql;

	public function sql()
	{
		return $this->_sql;
	}

	public function __construct( $sql  )
	{
		$this->_sql = $sql;
	}

	public function isNULL()
	{
		return TRUE;
	}
}
