<?php namespace Jhul\Components\MHttp\Session;

/*----------------------------------------------------------------------------------------------------------------------
> @Author - Manish Dhruw [1D3N717Y12@gmail.com]
----------------------------------------------------------------------------------------------------------------------*/

class Flash extends ArrayAccess
{

	protected $map = [] ;

	public function __construct( &$map )
	{
		$this->map = &$map;
	}

	public function get( $key, $returnOnFail = NULL )
	{
		return parent::pull( $key );
	}

	public function map()
	{
		return $this->map;
	}
}
