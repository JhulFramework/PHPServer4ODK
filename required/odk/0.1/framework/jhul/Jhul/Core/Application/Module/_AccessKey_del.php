<?php namespace Jhul\Core\Application\Module;

/* @Author : Manish Dhruw < 1D3N717Y12@gmail.com >
========================================================================================================================
| @created - Thursday 29 January 2015 03:38:39 PM IST-
+---------------------------------------------------------------------------------------------------------------------*/

trait _AccessKey
{

	private $_module_ik ;

	public function module()
	{
		if( NULL == $this->_module_ik )
		{
			$paths = explode('\\', trim( get_called_class(), '\\' ) );

			$k = array_search( '_modules', $paths );

			if( FALSE === $k ) return;

			$this->_module_ik = strtolower( $paths[ $k + 1 ] );

		}

		return \Jhul::I()->app()->m( $this->_module_ik );
	}
}
