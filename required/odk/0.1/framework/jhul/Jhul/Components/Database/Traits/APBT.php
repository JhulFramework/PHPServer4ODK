<?php namespace Jhul\Components\Database\Traits;

//Access Perspective Based Table

trait APBT
{
	use \Jhul\Core\Traits\APBF;

	public function newRecord()
	{
		$eClass = $this->SAP('S')->entityClass();

		if( class_exists( $eClass ) )
		{
			return new $eClass;
		}

		throw new \Exception( 'class "'.$eClass.'" Not Found. Please Check "'.get_called_class().'"::entityClass() ' , 1);

	}
}
