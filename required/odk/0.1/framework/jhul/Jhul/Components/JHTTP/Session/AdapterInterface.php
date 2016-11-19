<?php namespace Jhul\Components\Mhttp\Session ;

/*----------------------------------------------------------------------------------------------------------------------
> @Author - Manish Dhruw [1D3N717Y12@gmail.com]
----------------------------------------------------------------------------------------------------------------------*/

interface AdapterInterface
{

	public function flash();

	public function isActive();

	public function start();

	public function get( $name );

	public function set( $name, $value );

	public function remove($name);

	// get and remove
	public function pull( $name );

	public function close() ;
}
