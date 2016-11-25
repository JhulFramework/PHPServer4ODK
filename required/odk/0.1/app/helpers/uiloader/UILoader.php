<?php namespace app\helpers\uiloader;

class UILoader
{

	use \Jhul\Core\Design\Component\_Trait;

	protected $_uiadapters = [];

	protected $_adapter ;

	public function __construct( $params )
	{
		$this->config()->add( $params ) ;

		$this->_uiadapters['uikit'] = __NAMESPACE__.'\\adapters\\uikit\\UIKit' ;

		if( $this->config()->has('adapter') )
		{
			$this->setAdapter( $this->config('adapter') );
		}

	}

	public function setAdapter( $name )
	{
		if( isset( $this->_uiadapters[$name] ) )
		{
			$class= $this->_uiadapters[$name];
			$this->_adapter = new $class( $this->config('uikit_dir') );
		}

		return $this;
	}

	public function adapter(){ return $this->_adapter; }

	public function mBreadcrumb()
	{
		return $this->adapter()->mBreadcrumb();
	}

	public function link( $name )
	{
		$this->adapter()->link($name);
	}
}
