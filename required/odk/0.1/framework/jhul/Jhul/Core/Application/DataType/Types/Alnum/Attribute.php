<?php namespace Jhul\Core\Application\DataType\Types\Alnum;


class Attribute extends \Jhul\Core\Application\DataType\Types\String\Attribute
{

	public function __construct()
	{
		parent::__construct();

		$this->config()->add
		([
			'definition'		=>  'L=1-99',
			'required'			=> TRUE,
			'validation_steps'	=> 'type:minLength:maxLength',
		]);


	}

	public function validateType( $value )
	{
		return ctype_alnum( $value );
	}

	public function type(){ return 'alpha'; }
}
