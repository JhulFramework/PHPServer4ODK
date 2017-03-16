<?php namespace Jhul\Core\Containers;

trait _Config
{
	protected $_config;

	public function config( $key = NULL )
	{
		if( empty($this->_config) ) { $this->_config = new Config; }

		if( !empty( $key ) ) return $this->_config->get($key);

		return $this->_config;
	}
}
