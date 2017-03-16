<?php namespace Jhul\Components\Router ;

/* @Author : Manish Dhruw [ 1D3N717Y12@gmail.com ]
+=======================================================================================================================
| @Created -Thursday 06 February 2014 10:40:07 AM IST
|
| - Path should in format path/subPath, not /path/subpath
|
| @Updated -
|	[ -Sat 13 June 2015 08:59:44 AM IST
|	-Sun 07 Feb 2016 04:34:05 PM IST
|	-31-May-2016
|	-2016-jun-13 , 2016-02-10 ]
|
| TODO CACHE loaded map
+---------------------------------------------------------------------------------------------------------------------*/

class Router
{

	use \Jhul\Core\_AccessKey;

	const VERSION = '0.7';


	protected $defaultRoute = 'index';

	protected $errorRoute = 'error404';

	public $pathMap = [];

	public $depthMap = [];

	protected $_config;

	protected $map =
	[

		/* Contains only static route*/
		'static' => [],

		/* contains all routes*/
		'dynamic' => [],

	];


	public function __construct( $params )
	{
		$this->config()->add( $params );

		$this->add( $params['routes'] );
	}

	public function config( $key = NULL, $required = TRUE )
	{
		if( empty($this->_config) ) { $this->_config = new \Jhul\Core\Containers\Config; }

		if( !empty( $key ) ) return $this->_config->get($key, $required);

		return $this->_config;
	}


	function map( $key = NULL )
	{
		if( NULL != $key && isset($this->map[$key]) ) return $this->map[$key];

		return $this->map ;
	}

	/*
	 * identify that the path string is a name of regex pattern in refexfilters ( $this->regexFilters ), not a path or regex pattern
	*/
	public $regexFilterIdentifier	= ':';

	/*
	 * identify that the path string is a regex pattern
	*/
	public $regexIdentifier	= '_' ;


	public $pathIdIdentifier	= '&' ;

	public $varBoundary	= '|' ;

	public $caseSensitive = FALSE;

	// regex patterns by name
	private $regexFilters =
	[

		'alnum' => '/^[\w]+$/',
	];

	public function addRegexFilter($name, $regex)
	{
		$this->regexFilters[$name] = $regex;
	}

	public function pageIdentifier()
	{
		return $this->config('page_identifier');
	}

	public function staticPageIdentifier()
	{
		return $this->config('static_page_identifier');
	}

	public function nodeIdentifier()
	{
		return $this->config('node_identifier');
	}

	private $_route =
	[
		'key'		=>  '',

		//PATH
		'P'		=> [ 'V' => '', 'P' => [], ],

		'params'		=> [],

		//HANDLER
		'handler'		=> [ 'module_key' => '', 'node' => '', 'page' => '', 'static_page' => '' ],

		'type_identifier'	=> '',

		'type'		=> '',

	];


	// @param $path (URI PATH)
	// @Param $handler ( 'MODULE:NODE' )
	public function add( $path,  $handler = NULL )
	{

		if( is_array($path) )
		{
			foreach( $path as  $p => $h )
			{
				$this->add( $p, $h );
			}

			return;
		}

		//cooking new route
		$route = $this->_route ;


		if( 0 === strpos( $path, ':') )
		{
			//registering key of route without and does match to nay url path
			$route['key'] = substr( $path, 1 );
		}
		else
		{
			// url path based route
			// its path is its key
			$route['key'] = $path;
			$route['P']['P'] =  array_filter( explode( '/', trim( $path, '/' ) ) );
			$route['P']['V'] = $path;
		}

		$route['handler'] = $handler;

		if( strpos( $handler,  $this->nodeIdentifier() ) )
		{
			$route['type_identifier'] = $this->nodeIdentifier();
			$route['type']	= 'node';
		}
		elseif( strpos( $handler,  $this->pageIdentifier() ) )
		{
			$route['type_identifier'] = $this->pageIdentifier();
			$route['type']	= 'page';
		}
		elseif( strpos( $handler,  $this->staticPageIdentifier() ) )
		{
			$route['type_identifier'] = $this->staticPageIdentifier();
			$route['type']	= 'static_page';
		}
		// if target value contain ':' character it mean it is module:handler pattern
		// if( strpos( $handler, ':') )
		// {
		// 	$handler = explode( ':', $handler );
		//
		// 	//registering module for path handling
		// 	$route['handler']['module_key'] = $handler[0];
		//
		// 	//registering node for path handling
		// 	$route['handler']['node'] = $handler[1];
		// }
		//
		// // else if target value contain '.' character it mean it is module:Page pattern
		// else if( strpos( $handler, '.') )
		// {
		// 	$handler = explode( '.', $handler );
		//
		// 	$handler[_page]
		// 	//registering module for path handling
		// 	//$route['handler']['module_key'] = $handler[0];
		//
		// 	//registering page as route response
		// 	//$route['handler']['page'] = $handler[1];
		// }
		//
		// else if( strpos( $handler, '-') )
		// {
		// 	$handler = explode( '-', $handler );
		//
		// 	//registering module for path handling
		// 	$route['handler']['module_key'] = $handler[0];
		//
		// 	//registering page as route response
		// 	$route['handler']['static_page'] = $handler[1];
		// }



	 	//checking if its a simple static route
		if(  ( FALSE === strpos( $route['P']['V'], $this->regexIdentifier ) ) && ( FALSE === strpos( $route['P']['V'], $this->varBoundary ) ) )
		{
			$this->addStatic($route );
		}

		$this->addDynamic($route)  ;
	}

	protected function addStatic( $route )
	{
		if( !empty($route['P']['V'])  )
		{
			$this->map['static'][ $route['P']['V'] ] = $route ;
		}
		else
		{
			$this->map['hidden'][ $route['key'] ] = $route ;
		}
	}

	/*
	 * prepare and adds dynamic route
	 * TODO cache prepared routes
	*/
	protected function addDynamic( $route )
	{
		if( !empty( $route['P']['V'] ) )
		{
			$this->depthMap[ count($route['P']['P']) ][ ] = $route['P']['V'];

			$this->map['dynamic'][ $route['key'] ] = $route;
		}
	}

	function match( $path, $trace = FALSE  )
	{
		$path = trim($path,'/');

		$route = $this->_match( $path  );

		if( empty($route) )
		{
			$route = $this->get( 'error404' );
			$route['status_code'] = 404;
		}
		else
		{
			$route['status_code'] = 200;
		}


		return new Route( $this->_prepareRoute( $path,  $route) );
	}

	protected function _prepareRoute( $path, $route )
	{


		$path = explode('/', '/'.$path);

		unset($path[0]);

		$route['P']['P'] = $path;

		return $route;

	}


	/*
	 * match by depth,
	 * keeps decreasing depth unless match is found of failed
	 * depth match for
	*/
	private function _match( $path )
	{

		if(empty($path))
		{
			return $this->get( $this->defaultRoute );
		}

		$path = trim($path,'/');


		if( isset($this->map['static'][$path]) )
		{

			return $this->map['static'][ $path ];

		}

		$paths = explode( '/', $path);



		//needs increment to adjust decrement inside while loop
		$count = count($paths) + 1 ;

		while( $count )
		{
			--$count ;

			// matches by depth for fast access

			if( isset($this->depthMap[ $count ]) )
			{
				foreach( $this->depthMap[ $count ] as $id )
				{

					if( FALSE != ( $match = $this->matchPath( $this->map['dynamic'][$id]['P']['P'], $paths, $count ) ) )
					{
						$match['nodes'] = $paths;

						return array_merge( $this->map['dynamic'][$id], $match ) ;
					}
				}
			}
		}

		return FALSE;
	}


	public function matchPath( $patterns, $paths , $count )
	{

		$args = [] ;

		// loop through each part of a path
		while( $count )
		{
			$a = [];

			--$count ;

			$path = $paths[$count];

			if( $this->hasRegex( $patterns[$count] ) )
			{
				if( !preg_match( substr( $patterns[$count], 1 ) , $path , $a) ) return FALSE;

			}
			elseif( $this->hasVar( $patterns[$count] ) )
			{

				$p = explode( $this->varBoundary, $patterns[$count] );


				if( !empty($p[0]) )
				{
					if( 0 !== ( $pos = stripos($path, $p[0] ) ) )  return FALSE;
						$path = substr( $path, $pos+1 );
				}

				if( !empty($p[2]) )
				{

					if( ! $this->strMatch( $p[2], substr($path, -strlen($p[2])  ) ) ) return FALSE;
						$path = substr( $path, 0, -strlen($p[2]) );

				}

				if( strpos($p[1], $this->regexFilterIdentifier ) )
				{

					list($rt, $p[1]) = explode( $this->regexFilterIdentifier, $p[1] );


					if( isset($this->regexFilters[$rt]) )
					{

						if( !preg_match( $this->regexFilters[$rt] , $path ) ) return FALSE;
					}

				}

				$a[$p[1]] = $path ;


			}
			elseif( FALSE === $this->strMatch( $patterns[$count], $path ) )return FALSE ;


			$args = array_merge( $args, $a );
		}

		return [ 'params' => $args ] ;
	}

	private function strMatch( $str1, $str2 )
	{
		if($this->caseSensitive) return 0 === strcmp($str1,$str2);

		return 0 === strcasecmp( $str1, $str2) ;
	}

	// direct access
	public function get( $id, $silent = FALSE )
	{
		if( isset( $this->map['hidden'][$id] ) ) return $this->map['hidden'][$id] ;

		if( $silent ) return ;

		throw new \Exception( 'No route defined for identity key "'.$id.'" ' );
	}

	private function hasRegex( $path )
	{
		return 0 === strpos( $path, $this->regexIdentifier ) ;
	}

	private function hasVar( $path )
	{
		return FALSE !== strpos( $path, $this->varBoundary ) ;
	}
}
