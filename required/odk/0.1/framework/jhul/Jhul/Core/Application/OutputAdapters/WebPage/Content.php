<?php namespace Jhul\Core\Application\OutputAdapters\WebPage;

class Content
{
	private $_data =
	[
		'content' => '',
	];

	public function s( $key, $value )
	{
		if( !isset( $this->_data[$key] ) )
		{
			$this->_data[$key] = $value;
			return TRUE;
		}

		return FALSE;
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
