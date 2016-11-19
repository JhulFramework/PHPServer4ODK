<?php define( 'REQUIRED_PATH', __DIR__ );


//require_once( dirname( dirname( REQUIRED_PATH ) ).'/framework/jhul/0.7.1/autoloader.php' );

//(optional) Its important to instantiate frameworkt to enable exception handler

function makeapp( $app_name, $app_version )
{
	$app_path = __DIR__.'/'.$app_name;

	if(  !file_exists( $app_path ) )
	{
		throw new \Exception( 'Application "'.$app_path.'" Not Found ' , 1 );
	}

	$app_path_version = $app_path.'/'.$app_version.'/app';

	if(  !file_exists( $app_path_version ) )
	{
		throw new \Exception( 'Application version"'.$app_version.'" for application "'.$app_path.'" not found ' , 1);
	}


	require_once( $app_path.'/'.$app_version.'/framework/jhul/autoloader.php' );

	//Composer
	require( $app_path.'/'.$app_version.'/vendor/vendor/autoload.php' );

	\Jhul::I();

	//providing patt to look for compoenet component configuration //PRIMARY
	\Jhul::I()->cx()->setPath( __DIR__.'/'.$app_name.'/server/'.$app_version.'/components' );

	//providing path to look for component configuration //SECONDARY
	\Jhul::I()->cx()->setPath( $app_path_version.'/config/components' ) ;

	//registering path to autload, application and modules namespace
	\Jhul::I()->fx()->add( require( $app_path_version.'/config/_namespaces.php' ) ) ;
}
