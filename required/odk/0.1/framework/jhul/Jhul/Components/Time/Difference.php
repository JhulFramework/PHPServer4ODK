<?php namespace Jhul\Components\Time ;

class Difference
{

	protected $_value;

	protected $_context;

	//default unit
	protected $_unitName = 'second';

	protected $_readable = FALSE;

	protected $_output = NULL;

	protected $_units =
	[

		'second' => 'second',

		'minute' => 'minute',

		'hour' => 'hour',

		'day' => 'day',

		'month' => 'month',

		'year'	=> 'year',
	];

	public function __construct( $difference, $context )
	{

		$this->_output = $this->_value = $difference;
		$this->_context = $context;
	}

	public function context()
	{
		return $this->_context;
	}

	public function __call( $method, $args )
	{
		// Difference In mode
		if(  0 === stripos( $method, 'in' ) )
		{
			return $this->inMode( $method );
		}

		//Checking if it is Less the mode
		if(  0 === stripos( $method, 'isLessThan' ) )
		{
			return $this->isLessThanMode( $method );
		}

		throw new \Exception('Method '.$method.' Not Found!');
	}

	protected function inMode( $method )
	{

		if( NULL != ( $unitName = $this->findUnitName( 'in', $method ) ) )
		{
			$unit = 'unit'.$unitName;

			$this->_unitName = $unitName;

			$this->_output = floor( $this->value( TRUE )/$this->context()->$unit() ) ;

			return $this;
		}

		throw new \Exception('Method '.$method.' Not Found!');
	}

	public function readable()
	{
		$this->_readable = TRUE;

		return $this->auto();

	}

	protected function isLessThanMode( $method )
	{
		if( NULL != ( $mode = $this->findUnitName( 'isLessThan', $method ) ) )
		{
			$unitMode = 'unit'.$mode;
			return $this->value() < $this->context()->$unitMode();
		}

		throw new \Exception('Method '.$method.' Not Found!');
	}

	public function findUnitName( $prefix, $method )
	{
		$unitName = substr( rtrim( $method, 's'), strlen($prefix) );

		if( isset( $this->_units[ strtolower($unitName) ] ) )
		{
			return $unitName;
		}
	}

	public function hasMode( $mode )
	{
		return isset( $this->_modes[ strtolower($mode) ] );
	}

	public function value( $inSeconds = FALSE )
	{
		if( NULL === $this->_output || $inSeconds )
		{
			return $this->_value ;
		}

		return $this->_output;
	}

	public function __toString()
	{
		return $this->show();
	}

	protected function unitName()
	{
		return $this->_unitName;
	}

	public function show()
	{
		if( $this->_readable )
		{
			if( $this->value() > 1 )
			{
				return $this->value().' '.$this->unitName().'s ago';
			}

			return $this->value().' '.$this->unitName().' ago';
		}

		return $this->value();
	}

	public function auto()
	{
		if( $this->isLessThanMinute() )
		{
		 	$this->inSeconds();
		}
		elseif( $this->isLessThanHour() )
		{
			$this->inMinutes();
		}
		elseif( $this->isLessThanDay() )
		{
			$this->inHours();
		}
		elseif( $this->isLessThanMonth() )
		{
			$this->inDays();
		}
		else
		{
			$this->inYears();
		}

		return $this;
	}

}
