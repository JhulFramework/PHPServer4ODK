<?php namespace Jhul\Components\MHttp\Cookie;

/*@Aauthor [Manish Dhruw] <1D3N717Y12@gmail.com>
 +----------------------------------------------------------------------------------------------------------------------
 |
 |
 *
 *	//returns value or NULL
 *	$cookie->get( cookieName );
 *
 *
 *	// GOC get or create ( creates if cookie not already created )
 *	$cookies->GOC('')->save();;
 *
||@Created -Saturday 23 May 2015 10:20:45 AM IST
||@Update - Thu 22 Oct 2015 05:40:29 AM IST
++--------------------------------------------------------------------------------------------------------------------*/

class CookieManager
{
	const VERSION = '0.2';

	public function __construct( $p )
	{
		if( empty($p['D']) ) throw new \Exception('ERROR : Pleas configure cookie param "D(domain)" in MHttp conf File ') ;


		foreach( $p as $k => $v )
		{
			_Cookie::$p[$k] = $v;
		}
	}

	public function get( $name, $key = NULL )
	{
		if( isset( $_COOKIE[$name] ) )
		{
			return  _Cookie::I( $name, $_COOKIE[$name] );
		}
	}

	public function has( $name )
	{
		return isset( $_COOKIE[$name] );
	}

	// creates new Cookie
	public function create( $name, $value = NULL )
	{
		return new _Cookie( $name, $value );
	}

}
