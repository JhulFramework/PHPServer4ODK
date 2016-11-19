<?php namespace Jhul\Core\Application\DataType\Types\Image;

Class Definition
{
	protected $_p =
	[
		'min_size'		=> 6000, //bytes
		'max_size'		=> 1024000,//bytes

		'min_heigth'	=> 16 //px
		'max_heigth'	=> 2400 //px

		'min_width'		=> 16 //px
		'max_width'		=> 2400 //px

	];

	protected $_d = [];

	protected $_r = [];

	protected $_asString ;

	private $_limitKeys =
	[
		'S'	=> 'size',
		'W'	=> 'width',
		'H'	=> 'height',
	];

	public function __construct( $definition )
	{
		$this->_asString = $definition;

		$params = explode( ':', strtoupper($definition));

		foreach ( $params as $param )
		{

			if( strpos( $param, '=' ) )
			{
				$kv = explode( '=', $param );
				$this->_r[ $kv[0] ] = $kv[1];
			}

		}

		foreach ( $this->_limitKeys as $key => $type )
		{
			//extracting length
			if( isset( $this->_r[$key] ) )
			{
				$this->limit( $type, $this->_r[$key] );
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

	public function setLimit( $type, $limit )
	{
		if( strpos( $limit,'-' ) )
		{
			$limit = explode('-', $limit );

			$this->_p['min_'.$type]	= $limit[0];
			$this->_p['max_'.$type]	= $limit[1];

		}
		else
		{
			$this->_p['max_'.$type] = $limit;
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
