<?php namespace Jhul\Core\Application\DataType\Types\String;

Class Definition
{
	protected $_p = [];

	protected $_d = [];

	protected $_r = [];

	protected $_asString ;

	public function __construct( $definition )
	{
		$this->_asString = $definition;

		if( !empty($definition) )
		{

			$params = explode( ':', strtoupper($definition));

			foreach ( $params as $param )
			{

				if( strpos( $param, '=' ) )
				{
					$kv = explode( '=', $param );
					$this->_r[ $kv[0] ] = $kv[1];
				}

			}

			//extracting length
			if( isset( $this->_r['L'] ) )
			{
				$length = $this->_r['L'];

				if( strpos( $length,'-' ) )
				{
					$length = explode('-', $length );

					$this->_p['min_length'] = $length[0];
					$this->_p['max_length'] = $length[1];

				}
				else
				{
					$this->_p['exact_length'] = $length;
				}
			}

			if( isset($this->_r['P']) )
			{
				if( strpos( $this->_r['P'],  'R' ) )
				{
					$this->_p['required'] = TRUE;
				}
			}
		}
	}


	public function ifValueRequired()
	{
		return isset( $this->_p['required'] );
	}

	public function __toString()
	{
		return $this->_asString;
	}

	public function params()
	{
		return $this->_p;
	}

	public function get( $p )
	{
		if( $this->has($p) )
		{
			return $this->_p[$p];
		}

		throw new \Exception( 'Parameter "'.$p.'" Not Defined' , 1);
	}

	public function has( $d )
	{
		return array_key_exists( $d, $this->_p );
	}

}
