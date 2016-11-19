<?php namespace Jhul\Core\Design\Component;


trait _Trait
{
	public function J()
	{
		return \Jhul::I();
	}

	public function getApp()
	{
		return $this->J()->app() ;
	}

	protected $_config;

	public function config( $key = NULL, $required = TRUE )
	{
		if( empty($this->_config) ) { $this->_config = new \Jhul\Core\Containers\Config; }

		if( !empty( $key ) ) return $this->_config->get($key, $required);

		return $this->_config;
	}

	final public function _s( $name, $com )
	{
		$name = '_'.$name;

		$this->$name = $com;
	}
}
