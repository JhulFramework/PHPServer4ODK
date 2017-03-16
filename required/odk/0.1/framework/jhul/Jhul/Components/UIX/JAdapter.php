<?php namespace Jhul\Components\UIX;


class JAdapter
{

	use \Jhul\Core\Design\Component\_Trait;

	private $_map = [];

	private $_scssCompiler;

	public function __construct( $params )
	{
		$this->config()->add( $params ) ;
	}

	public function register( $theme, $config )
	{
		$this->_map[ $theme ] = $config ;
	}

	// Delius+Unicase
	public function linkGoogleFont( $name )
	{
		$this->getApp()->response()->page()->mStyle()->link( $this->getGoogleFont( $name ) );
	}

	//attach style for ui component
	public function attach( $theme, $component )
	{
		$this->getApp()->response()->page()->mStyle()->embed
		(
			parent::make( $theme, $component )
		);
	}

	public function scssCompiler()
	{
		if( NULL == $this->_scssCompiler )
		{
			$this->_scssCompiler = new \Leafo\ScssPhp\Compiler;
		}

		return $this->_scssCompiler;
	}

	public function loadScssFiles()
	{

	}

	//converts php array in scss variable
	public function loadPHPVariables()
	{

	}
}
