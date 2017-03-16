<?php

defined('JHUL_REQUIRED_DIR') or define('JHUL_REQUIRED_DIR', __DIR__ );

function makeapp( $app_name, $app_version )
{
	$base_path = __DIR__.'/'.$app_name.'/'.$app_version;

	if(  !file_exists( $base_path ) )
	{
		throw new \Exception( 'Application "'.$base_path.'" Not Found ' , 1 );
	}


	require( $base_path.'/framework/jhul/autoloader.php' );

	//Composer
	require( $base_path.'/xdep/composer/vendor/autoload.php' );

	\Jhul::I();

	//providing patt to look for compoenet component configuration //PRIMARY
	\Jhul::I()->cx()->setPath( $base_path.'/_components/server' );

	//providing path to look for component configuration //SECONDARY
	\Jhul::I()->cx()->setPath( $base_path.'/_components/common' ) ;

	//registering path to autload, application and modules namespace
	\Jhul::I()->fx()->add( require( $base_path.'/app/_config/_namespaces.php' ) ) ;
}
