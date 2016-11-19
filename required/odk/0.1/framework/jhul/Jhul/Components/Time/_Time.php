<?php namespace Jhul\Components\Time ;

class _Time
{

	public $defaultFormat = 'd M Y';


	public function __construct( $time )
	{
		$this->_value = $time;
	}

	public function setDefaultFormat( $format )
	{
		$this->defaultFormat = $format ;
	}

	protected $_value ;


	public function value()
	{
		return $this->_value;
	}

	public function __toString()
	{
		return @date( $this->defaultFormat, $this->_value );
	}

	public function year( $y = 'Y' )
	{
		return date( $y, $this->_value );
	}

	public function month($M = 'm')
	{
		return date( $M, $this->_value );
	}

	public function unitay( $D= 'D' )
	{
		return date( $D, $this->_value );
	}

	public function day( $d = 'j' )
	{
		return date( $d, $this->_value );
	}

	public function hour($H ='H')
	{
		return date( $H , $this->_value );
	}


	public function unitSecond()
	{
		return 1;
	}

	//IN Seconds
	public function unitMinute()
	{
		return 60;
	}

	//IN Seconds
	public function unitHour()
	{
		return $this->unitMinute()*60;
	}

	//IN Seconds
	public function unitDay()
	{
		return $this->unitHour()*24 ;
	}

	public function unitWeek()
	{
		return $this->unitDay()*7;
	}

	public function unitMonth()
	{
		return $this->unitDay()*30;
	}

	public function unitYear()
	{
		return $this->unitDay()*365;
	}

	protected $_diff;

	public function diff()
	{

		if( NULL == $this->_diff )
		{
			$this->_diff = new Difference( time() - $this->value(), $this );
		}

		return $this->_diff;
	}

/*
	//Readable difference
	public function RD()
	{


		if( $this->difference() < $this->unitMinute() ) return $t.' secs ago ';

		if( $this->difference() < $this->unitHour() ) return round( $this->difference()/$this->unitMinute() ).' mins ago ';

		if( $this->difference() < $this->unitDay() ) return round( $this->difference()/$this->unitHour() ).' hrs ago ';

		if( $this->difference() < $this->unitWeek() )  return round( $this->difference()/$this->unitDay() ).' days ago ';

		if( $this->difference() < $this->unitMonth() )  return round( $t/$this->unitWeek() ).' weeks ago ';

		if( $this->difference() < $this->unitYear()  return round($t/ $this->unitMonth().' months ago ';

 		return round($t/$this->unitYear() ).' years ago ';

		return $this;
	}*/

	public function RDInDays()
	{
		return round( $this->difference()/$this->unitMinute() ).' mins ago ';
	}

	public function get( $format )
	{
		return date( $format, $this->_value );
	}
}
