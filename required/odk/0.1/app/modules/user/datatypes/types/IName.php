<?php namespace _modules\user\datatypes\types;

class IName extends \Jhul\Core\Application\DataType\Types\String\Attribute
{

	protected $_blacklist = [];

	public function __construct()
	{
		parent::__construct();
		$this->config()->add('definition', 'L=3-15:' );
	}

	//@override
	public function validateType( $value )
	{
		return ctype_alnum( $value ) && !ctype_digit($value) ;
	}


	public function type() { return 'iname'; }
}
