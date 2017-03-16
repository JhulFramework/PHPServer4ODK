<?php namespace Jhul\Components\UIX;

class Theme
{
	protected $_name;

	protected $_components = [];

	//@object
	protected $_uix;

	public function __construct( $name, $uix )
	{
		$this->_name = $name;
		$this->_uix = $uix;
		$this->_components = $this->_uix->loadThemeData( $this->_name );
	}

	public function components()
	{
		return $this->_components;
	}

	public function get( $name )
	{
		if( empty($this->_components[$name]) )
		{
			return $this->_components[$name];
		}

		throw new \Exception( 'Theme "'.$this->_name.'" has no component named "'.$name.'" ' , 1);

	}

	public function makeAll()
	{
		$all = '';

		foreach ( $this->components() as $key => $value)
		{
			$all .= $this->make($key);
		}

		return $all;
	}

	public function make( $name )
	{
		return $this->_uix->compileScss( $this->deflate($name) );
	}

	//@param : $name = theme component name
	public function deflate( $name )
	{
		$d = '';

		foreach ( $this->_components[$name]  as $key => $value)
		{
			$d .= $this->getData( $name, $key );
		}

		return $d;
	}

	//@param : $name = theme component name
	//@param : $param = theme component param
	public function getData( $name, $param )
	{
		$data = $this->_components[ $name ][$param];

		if( 0 === strpos('#', $data) )
		{
			$data = substr( $data, 1 );

			echo '<pre>';
			echo '<br/> File : <br/>'.__FILE__.':'.__LINE__.'</br></br>';
			var_dump($data);
			echo '</pre>';
			exit();
		}

		return $data;
	}

}
