<?php namespace Jhul\Core\Application\DataType\_Attribute;


class ErrorCodeManager
{
	protected $_codes;

	protected $_type;

	public function __construct( $type )
	{
		$this->_type = $type;
	}

	public function add( $method, $code = NULL )
	{
		if( is_array($method) )
		{
			foreach ( $method as $m => $c)
			{
				$this->add( $m, $c );
			}

			return;
		}

		if( empty($code) )
		{
			throw new \Exception( 'Error code must not be empty' , 1);
		}

		$this->_errorCodes[strtolower($method)] = $code;
	}

	public function get( $key )
	{
		$key = strtolower($key);

		if( $this->has($key) ) return $this->_errorCodes[$key] ;

		throw new \Exception( 'Error Code not set for "'.$this->_type.'::'.$key.'()" ', 1);
	}

	public function has( $key ){ return isset( $this->_errorCodes[$key] ) ; }
}
