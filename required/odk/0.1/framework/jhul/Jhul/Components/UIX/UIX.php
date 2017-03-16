<?php namespace Jhul\Components\UIX;

require_once( __DIR__.'/scssphp/scss.inc.php' );

use Leafo\ScssPhp\Compiler;

class UIX
{

	use \Jhul\Core\_AccessKey;

	private $_loaded = [];

	private $_scssCompiler;

	protected $_themes = [];

	private $_scss_dir = '';


	//built css Components
	protected $_cssComponents = [] ;

	public function __construct( $params )
	{
		//$this->config()->add( $params ) ;
	}

	public function register( $theme, $dir )
	{
		$this->_map[ $theme ] = $dir ;
	}

	// Delius+Unicase
	public function getGoogleFont( $name )
	{
		$this->getApp()->response()->page()->mStyle()->link( 'font:'.$name,  'https://fonts.googleapis.com/css?family='.$name );
	}

	public function setScssDir( $dir )
	{
		$this->_scss_dir = $dir;
		return $this;
	}

	private function resolveSCSSFile( $name, $dir )
	{
		$file = $dir.'/'.$name.'.scss';

		if( !file_exists($file) )
		{

			if( strrpos( $name, '/'  ) )
			{

				//substr_replace($var, 'bob', 0) . "<br />\n";
				$pos = strrpos( $name, '/' );

				$name = substr_replace($name, '/_', $pos, 1);
			}
			else
			{
				$name = '_'.$name;
			}

			$file = $dir.'/'.$name.'.scss';
		}

		$file = $dir.'/'.$name.'.scss';

		if( file_exists($file)  )
		{
			return $file;
		}


		throw new \Exception( 'SCSS file "'.$file.'" not found' , 1);
	}


	public function compileSCSSFile( $name )
	{
		return $this->compileScss( $this->makeScss($name) );
	}


	public function makeScss( $name )
	{
		return $this->_makeScss($name, $this->_scss_dir);
	}


	public function _makeScss( $name, $dir)
	{
		$file = $this->resolveSCSSFile( $name, $dir );

		$content = file( $file );

		foreach ($content as $key => $value)
		{
			if( false !== strpos( $value, '//'  ) )
			{
				unset( $content[$key] );
			}
		}

		$content = implode( ' ', $content);

	
		preg_match_all('|\@import "(.*)"\;|', $content, $matches );

		if( !empty($matches) )
		{

			$dep = [];

			$dep_dir = dirname($file);

			foreach ($matches[1] as  $key => $import)
			{
				$dep[ $matches[0][$key] ] = $this->_makeScss( $import, $dep_dir );
			}


			foreach ($dep as $key => $value)
			{
				$content = str_replace( $key, $value, $content  );
			}
		}

		return $content;
		//$content =  $this->compileScss($content);

	}

	//@param : $name = theme name
	//@param : $component = theme component name
	public function make( $name, $component )
	{
		return $this->theme( $name )->make( $component );
	}

	public function makeTheme( $name )
	{
		return $this->theme( $name )->makeAll();
	}


	public function compileScss( $data )
	{
		return $this->scssCompiler()->compile( $data );
	}



	//to prevenet duplication
	protected $_embeded = [];

	public function embed( $theme, $component )
	{
		if( !isset($this->_embeded[ $theme ]) )
		{
			if( !isset($this->_embeded[ $theme.'.'.$component ]) )
			{
				$this->getApp()->response()->page()->mStyle()->embed( $this->make( $theme, $component ) );
			}
		}
	}

	public function embedTheme( $theme )
	{
		if( !isset($this->_embeded[ $theme ]) )
		{
			$this->getApp()->response()->page()->mStyle()->embed( $this->makeTheme( $theme ) );
		}
	}



	public function scssCompiler()
	{
		if( NULL == $this->_scssCompiler )
		{
			$this->_scssCompiler = new \Leafo\ScssPhp\Compiler;
		}

		return $this->_scssCompiler;
	}

	public function theme( $name )
	{
		if(empty($this->_themes[$name]))
		{
			$this->_themes[$name] = new Theme( $name, $this );
		}

		return $this->_themes[$name];
	}

	public function loadThemeData( $theme )
	{
		if( isset($this->_map[$theme]) )
		{
			$data = [];

			$theme = require( $this->_map[$theme].'/_map.php' );

			foreach ($theme as $key => $component)
			{
				$data[$key] = $this->loadComponentData( $component );
			}

			return $data;
		}

		throw new \Exception( 'Theme "'.$name.'" not found!' , 1);
	}

	private function loadComponentData( $map )
	{
		$themeParams = [];

		$m = '';
		if( is_string($map) )
		{
			$file = $map.'.scss';
			if( is_file( $file ) )
			{
				$themeParams['template'] = file_get_contents( $file );
				return $themeParams;
			}

			$m = $map;

			$map = [ 'colors' => $m , 'size' => $m, 'template' => $m ];
		}

		foreach ( $map as $key => $value)
		{
			$themeParams[ $key ] = $this->loadRes( $key, $value );
		}

		return $themeParams;
	}

	private function loadRes( $name, $res )
	{
		if( 0 === strpos($res, '#') )
		{
			return $this->loadRes( $res, substr( $res, 1 ) );
		}

		$file = $res.'/'.$name.'.scss';

		return file_exists($file) ? file_get_contents($file): '' ;
	}

}
