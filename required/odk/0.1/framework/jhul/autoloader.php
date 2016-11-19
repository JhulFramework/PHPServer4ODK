<?php


class JhulClassLoader
{
	public static function autoload( $className )
	{
		if( strpos( $className, 'Jhul' ) === 0 )
		{
			$file = __DIR__.'/'.str_replace( '\\', '/', $className ).'.php';

			if( file_exists( $file ))
			{
				require( $file ) ;
			}
		}
	}
}

spl_autoload_register(  array( 'JhulClassLoader', 'autoload') , true);
