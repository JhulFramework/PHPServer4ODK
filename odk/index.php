<?php ini_set('display_errors', 1); date_default_timezone_set ('Asia/Kolkata');


define( 'JHUL_IF_ENABLE_DEBUG', TRUE );

define( 'JHUL_APPLICATION_PUBLIC_ROOT', __DIR__ );


require_once( dirname(__DIR__).'/required/appmaker.php' );

makeApp( 'odk', '0.1' );


\Jhul::I()->app()->run();


// if (!empty($_FILES))
// {
//
// 	\Jhul::I()->cx('papertrail')->log( 'inside Not empty file if' );
//
// 	ob_start();
//   echo json_encode($_FILES);
//   echo json_encode($_POST);
//   echo 'dumping';
//   $result = ob_get_clean();
//
//   \Jhul::I()->cx('papertrail')->log( 'FRONT Logging'. htmlspecialchars( $result, ENT_QUOTES, 'utf-8') );
//
//
//
// }
// http_response_code(201);
