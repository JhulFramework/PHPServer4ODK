<?php namespace Jhul\Core\Application\OutputAdapters\WebPage;

/* @Author Manish Dhruw [1D3N717Y12@gmail.com]
+=======================================================================================================================
| @Created Mon 09 Nov 2015 01:55:10 PM IST
+---------------------------------------------------------------------------------------------------------------------*/

class TemplateManager
{
	use \Jhul\Core\_AccessKey;

	protected $_currentPath ;

	protected $_currentViewName;

	protected $_res = [];

	protected $_valuesSeperator = '|';

	public function __construct()
	{
		$this->register( 'error404', __DIR__.'/resources/error404' );
	}


	private function _buffer( $file, $params = [] )
	{
		ob_start();

		extract($params, EXTR_OVERWRITE);

		require($file);

		return ob_get_clean();
	}

	public function breadCrumbs()
	{
		return $this->getPage()->mBreadCrumb()->create();
	}


	public function dirPath( $file )
	{
		return mb_substr( $file, 0, strrpos( $file, '/' ) );
	}

	public function get( $name )
	{
		if( isset($this->_res[$name]) )
		{
			return $this->_res[$name];
		}


		throw new \Exception('Template "'.$name.'" Not Mapped');
	}

	public function getCSS()
	{
		return $this->getPage()->mStyle();
	}

	public function getPage()
	{
		return $this->getApp()->outputAdapter();
	}

	public function html()
	{
		return $this->J()->com('HTML');
	}


	public function load( $name, $params = [] )
	{

		$view = $this->get($name);

		if( is_array($view) )
		{
			if( isset($view['s']) )
			{
				$this->loadCSS( $view['s'] );
			}

			//if view is consist of child view(s)
			if( !empty($view['v']) )
			{
				$cView = $view['v'];


				//if it consistsof multiple child views
				if( strpos( $cView, $this->_valuesSeperator ) )
				{
					$cNames = explode(  $this->_valuesSeperator , $cView );


					$p = $params;

					foreach ($cNames as $c)
					{
						$params['views'][$c] = $this->load( $c, $p );
					}
				}

				//if it consist of only one child view
				else
				{
					$params['views'][$cView] =  $this->load( $cView, $params );
				}

			}

			$this->_currentViewName = $name;
			return  $this->buffer( $view['f'], $params ) ;
		}


		$this->_currentViewName = $name;
		return $this->buffer( $view, $params ) ;
	}


	public function loadCss( $css )
	{
		if( strpos( $css, $this->_valuesSeperator ) )
		{
			$cArray = explode( $this->_valuesSeperator, $css );

			foreach ($cArray as $c)
			{
				$this->loadCss( $c );
			}
		}
		else
		{

			if( !$this->getCss()->embed( $css ) )
			{
				throw new \Exception( 'Css "'.$css.'" Not Found In Path '.$this->_currentPath , 1);
			}
		}
	}


	public function buffer( $file, $params = [] )
	{

		if( is_file($file) )
		{
			$this->_currentPath = $this->dirPath( $file );

			$output = $this->_buffer( $file , $params );

			$this->_currentPath = NULL;

			return $output;
		}

		if( NULL != $this->_currentPath )
		{
			$cFile = $this->_currentPath.'/'.$file.'.php';

			if( is_file( $cFile) ) return $this->_buffer( $cFile , $params );

		}


		throw new \Exception( 'View File "'.$file.'" May Not exists' );

	}

	public function embedCss( $cssFileName = NULL )
	{
		if( NULL == $cssFileName )
		{
			$cssFileName =  $this->_currentViewName;
		}

		$file = $this->_currentPath.'/'.$cssFileName.'.css';

		$this->getCss()->embed( $this->_buffer( $file ), $cssFileName );
	}


	public function map()
	{
		return $this->_res;
	}

	public function register( $name, $view = NULL, $definition_file = NULL )
	{

		if( is_array($name) )
		{
			foreach ( $name as $n => $v)
			{
				$this->register( $n, $v, $definition_file );
			}

			return;
		}

		if( is_array( $view ) )
		{
			$file = $view['f'].'.php';

			if( !is_file($file) )
			{
				throw new \Exception( 'Template file "'.$file.'" does not exists defined in file '.$definition_file.'.php' , 1);
			}

			$view['f'] = $file;

		}
		else
		{
			$view .= '.php';

			if( !is_file( $view ) )
			{
				throw new \Exception( 'Template File "'.$view.'" does not exists defined in file '.$definition_file.'.php', 1);
			}
		}

		$this->_res[$name] = $view;
	}


	public function res(){ return $this->_res; }
}
