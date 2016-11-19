<?php namespace Jhul\Core\Application\DataType\Types\Email ;

class Attribute extends \Jhul\Core\Application\DataType\Types\String\Attribute
{



	public function type(){ return 'email' ; }

	public function prepareValue( $value ) { return $value; }

	public function validateType ( $value )
	{
		return filter_var( $value, FILTER_VALIDATE_EMAIL ) ;
	}

	public function validateHost( $value )
	{
		$host = substr( $value , strpos( $value, '@') + 1   );

		$host = strtolower($host);

		return in_array( $host, $this->allowedHosts() ) ;
	}
}
