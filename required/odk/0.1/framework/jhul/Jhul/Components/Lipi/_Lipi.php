<?php namespace Jhul\Components\Lipi ;

class _Lipi
{
	protected $_p;

	public function __construct( $name, $lipi )
	{
		$this->_p['name'] = $name;
		$this->_p['numeric'] =$lipi->getCode( $name );
		$this->_p['iso6393'] = $lipi->getCode( $name, 'iso6393' );
	}

	public function code()
	{
		return $this->_p['numeric'];
	}

	public function iso6393()
	{
		return $this->_p['iso6393'];
	}

	public function name()
	{
		return $this->_p['name'];
	}

	public function match( $language )
	{
		return ( $this->code() == $language) || ( $this->iso6393() == $language ) || ( $language == $this->_p['name'] ) ;
	}
}
