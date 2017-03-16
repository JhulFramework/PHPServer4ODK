<?php namespace Jhul\Components\UIX\UIKit;

class MBreadCrumb
{
	protected $_crumbs = [];
	protected $_active = [];

	protected $_uikit;

	public function add( $name, $url )
	{
		if( !empty( $this->_active) )
		{
			$this->_crumbs[ $this->_active['name'] ] = $this->_active['url'];
		}

		$this->_active['name'] = $name;

		$this->_active['url'] = $url;
	}

	public function make()
	{

		$b = '';

		foreach( $this->_crumbs as $name => $link )
		{
			$b .= '<li><a href="'.$link.'" >'.$name.'</a></li>' ;
		}

		if( !empty($b))
		{
			$b .= '<li><span class="uk-active">'.$this->_active['name'].'</span></li>';

			return '<div style="padding: 12px ; font-size:12px;" ><ul class="uk-breadcrumb">'.$b.'</ul></div>' ;
		}

		return '';
	}

	public function __toString(){ return $this->make(); }
}
