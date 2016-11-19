<?php namespace Jhul\Components\Router ;

class URLProvider
{

	use \Jhul\Components\Application\_AccessKey;

	protected $map = [] ;


	public function _configure()
	{
		return
		[
			'map'	 => array( 'setter' => 'addAll' ),
		];
	}


	public function map() { return $this->map ; }

	public function addAll( $useless, $map )
	{
		foreach( $map as $k => $v )
			$this->add( $k, $v );
	}

	public function add( $name, $url ) { $this->map[$name] = $url ; }

	public function get( $name, $params = NULL , $abs = TRUE )
	{
		if( !isset( $this->map[ $name ] ) ) return NULL ;

		$url = $this->map[$name]['url'];


		return $abs ? $this->getApp()->url($url) : $url ;
	}


	public function link(  $name, $params = array(), $abs = TRUE )
	{
		if( isset($this->map[$name]) )
			return '<a href = "'.$this->get( $name, $params, $abs ).'" >'.$this->label($name).'</a>';
	}

	private function label($name)
	{

		if( isset($this->map[$name]['label']) ) return $this->map[$name]['label'];
		return strtoupper($name);
	}

	public function isSingleton()
	{
		return TRUE;
	}

}
