<?php namespace Jhul\Core\Application\DataType\Types\PDN ;


class Attribute extends \Jhul\Core\Application\DataType\Types\String\Attribute
{
	public function validateType( $number )
	{
		return ctype_digit($number) &&  $number > 0 ;
	}

}
