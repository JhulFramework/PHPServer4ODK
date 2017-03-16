<?php namespace Jhul\Core;


trait _AccessKey
{
	public function J()
	{
		return \Jhul::I();
	}

	public function getApp()
	{
		return $this->J()->app() ;
	}

	private $_module_ik ;

	public function module()
	{
		if( NULL == $this->_module_ik )
		{
			$paths = explode('\\', trim( get_called_class(), '\\' ) );

			$k = array_search( '_modules', $paths );

			if( FALSE === $k )
			{
				throw new \Exception( 'This class "'.get_called_class().'" is not a part of any module' , 1);
			}

			$this->_module_ik = strtolower( $paths[ $k + 1 ] );
		}

		return $this->getApp()->m( $this->_module_ik );
	}
}
