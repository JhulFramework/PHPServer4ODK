<?php namespace Jhul\Components\XHelper;

abstract class _Design
{
	use \Jhul\Core\_AccessKey;

	abstract function handlerMap() ;

	public function showClass( $class )
	{
		return '<br/> Class : '.$class. '<br/> File : '.$this->J()->g('P')->filePath( $class );
	}

	public function cook( $error_code, $params, $error_object )
	{
		if( isset( $this->handlerMap()[$error_code] ) )
		{
			$method = $this->handlerMap()[$error_code];

			return $this->$method( $params, $error_object );
		}

		return $error_code;
	}
}
