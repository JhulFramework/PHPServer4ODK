<?php namespace Jhul\Components\Excep ;

/*
------------------------------------------------------------------------------------------------------------------------
> @ Copyright (c) 2013-2014 Manish Dhruw [1D3N717Y12@gmail.com ]

> @ License see LICENSE

> @Author manish dhruw < 1D3N717Y12@gmail.com >

- This class is like Data pool for data Sharing

- Wednesday 05 February 2014 01:49:07 PM IST
------------------------------------------------------------------------------------------------------------------------
*/

defined('JHUL_DEBUG') or define('JHUL_DEBUG', false);

use Jhul\Components\Excep\Sys\Html ;

class Component
{

	protected static $callNextHandler = true;

	protected static $isShutDownMode = false;

	/*holds common paths of the file to hide traces from */
	protected static $removeTracesFrom = array();

	/*html rendering object */
	private static $html;

	public function removeTracesFrom( $path )
	{
		static::$removeTracesFrom[] = $path;
	}

	protected static $params = array(

		/*
		- number of lines from above and below the error lines to be shown
		- actul height would be 1(error code line) + 2*height(above and below)
		*/
		'frameHeight'		=> 3,

		'maxFrames'		=> 12,

		/* dir containg view files */
		'resources'		=> 'resources' ,
	
	);

	public function param( $name ) { return static::$params[ $name ]; }

	public function html()
	{
		if( self::$html == null )
		{
			$resources =	strpos( $this->param('resources'), '/' ) === 0 ?
					$this->param('resources') : __DIR__.'/'.$this->param('resources');
			self::$html = new Html;

			self::$html->setResourcesPath( $resources );
		}
	
		return self::$html;
	}

	public static function inst()
	{
		$class = get_called_class() ;

		return new $class;
	}

	public function isDebugOn(){ return JHUL_DEBUG === true ; }

	public function isShutDownMode(){ return static::$isShutDownMode === true ; }
}
