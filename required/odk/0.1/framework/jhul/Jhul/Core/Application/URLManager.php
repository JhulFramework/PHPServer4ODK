<?php namespace Jhul\Core\Application ;

class URLManager
{


	protected $_base_url;

	protected $_map = [] ;

	public function __construct( $base_url, $map )
	{
		$this->_map = $map;
		$this->_base_url = $base_url;
	}

	public function map() { return $this->_map ; }


	public function get( $name, $absolute = TRUE )
	{
		if( !isset( $this->_map[ $name ] ) ) return NULL ;

		return $absolute ? $this->_base_url .'/'. $this->_map[$name]['url'] : $this->_map[$name]['url'] ;
	}

	public function link(  $name, $params = [], $abs = TRUE )
	{
		return '<a href = "'.$this->get( $name, $params, $abs ).'" >'.$this->label($name).'</a>';
	}

	private function label($name)
	{

		if( isset($this->map[$name]['label']) ) return $this->map[$name]['label'];
		return strtoupper($name);
	}

}
