<?php namespace Jhul\Components\JHTTP ;

class Request_Data
{

	use \Jhul\Core\Traits\EasyArray;

	protected $map = [] ;

	public function __construct( $data )
	{
		$this->map = $data;
	}

	public static function I( $data )
	{
		return new static( $data );
	}

}
