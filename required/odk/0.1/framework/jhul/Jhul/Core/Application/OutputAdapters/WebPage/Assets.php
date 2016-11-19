<?php namespace Jhul\Core\Application\OutputAdapters\WebPage;

/* @Author : Manish Dhruw < 1D3N717Y12@gmail.com >
+-----------------------------------------------------------------------------------------------------------------------

//this class is intended to provide/link resources from public accessible dir

+---------------------------------------------------------------------------------------------------------------------*/

class Image
{

	use \Jhul\Core\_AccessKey;
//	use \Jhul\Core\Design\Entity\_Trait\Configurable;

	protected $_webpage;

	public $CSSDirectoryName = 'css' ;

	public $iconsDirectoryName = 'icons' ;

	public $iconType = 'png';



	// public function path( $append = NULL )
	// {
	// 	if( NULL != $append )
	// 	{
	// 		return $this->path().'/'.$append;
	// 	}
	//
	// 	return $this->getApp()->path().'/'.$this->directory();
	// }


	public function cssUrl( $name )
	{
		return $this->getApp()->url().'/'. $this->getApp()->config('public_css_dir'). '/'.$name.'.css' ) ;
	}

	public function iconUrl( $name, $ext = 'png')
	{
		return $this->getApp()->url().'/'. $this->getApp()->config('public_icon_dir'). '/'.$name.'.'.$ext ) ;
	}

	public function linkCss( $cssFileName )
	{
		if( is_array( $cssFileName ) )
		{
			foreach( $cssFileName  as $name )
			{
				$this->linkCss( $name );
			}
		}
		else
		{
			$this->webPage()->css()->addLink( $this->cssUrl( $cssFileName ), $cssFileName );
		}
	}

	public function injectCss( $cssFileName )
	{
		if( is_array( $cssFileName ) )
		{
			foreach( $cssFileName  as $name )
			{
				$this->injectCss( $name );
			}
		}
		else
		{
			$this->webPage()->css()->addCode( $this->cssUrl( $cssFileName ), $cssFileName );
		}
	}


	public function webPage()
	{
		return $this->getApp()->outputAdapater();
	}
}
