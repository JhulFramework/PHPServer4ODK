<?php namespace Jhul\Components\Database\Design\Data\RDBEManager;

/* NULL OBJECT ENTITY
+=======================================================================================================================
| @Author : Manish DHruw [1D3N717Y12@gmail.com]
| @Created : 2016-August-13

+---------------------------------------------------------------------------------------------------------------------*/


trait _Trait
{
	protected $_RDBEManager;

	public function RDBEManager()
	{
		if( empty( $this->_RDBEManager ) )
		{
			$class = __NAMESPACE__ ;
			$this->_RDBEManager = new $class( $this );
		}

		return $this->_RDBEManager;
	}
}
