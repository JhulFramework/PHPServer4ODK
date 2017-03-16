<?php namespace JHul\Components\UIX\Adapters\UIKit;


class UIKit
{

	use \Jhul\Core\_AccessKey;

	protected $_mBreadcrumb;

	protected $_dir ;

	public function __construct( $directory )
	{
		$this->_mBreadcrumb = new MBreadcrumb;

		$this->_mBreadcrumb->add( 'HOME', $this->getApp()->url() );

		$this->_dir = $directory;
	}

	public function mBreadcrumb(){ return $this->_mBreadcrumb; }

	protected function js( $name )
	{
		return $this->getApp()->url().'/'.$this->dir().'/js/'.$name.'.js';
	}

	public function dir()
	{
		return $this->_dir;
	}

	public function css($name)
	{
		return $this->getApp()->url().'/'.$this->dir().'/css/'.$name.'.css';
	}

	public function name()
	{
		return 'uikit';
	}

	public function linkJs( $name )
	{
		$this->getApp()->outputAdapter()->mJs()->link( $this->name().':'.$name, $this->js($name) );
	}

	public function linkCSS( $name )
	{
		$this->getApp()->outputAdapter()->mStyle()->link( $this->name().':'.$name, $this->css( $name ) );
	}

	public function link( $name )
	{
		$this->linkJS( $name );
		$this->linkCSS( $name );
	}

}
