<?php namespace Jhul\Core\Application\Response\WebPage;

class Content
{
	private $_data =
	[
		'content' => '',
	];

	public function s( $key, $value )
	{
		$this->_data[$key] = $value;
		return $this;
	}

	public function g( $key )
	{
		if( isset( $this->_data[$key] ) ) return $this->_data[$key];
	}

	public function a( $key, $value )
	{
		$this->_data[$key] .= $value;
	}


	public function has( $e )
	{
		return !empty( $this->_data[$e] ) ;
	}
}
