<?php namespace _modules\main\models;

class List extends \Jhul\Components\Database\Store\Data\_Class
{

	public function byName( $name )
	{
		return $this->where( 'name', $name );
	}

	public function byYear( $year )
	{
		return $this->where( 'year', $year );
	}

	public function month( $month )
	{
		return $this->where( 'month', $month );
	}

	public function date( $data )
	{
		return $this->where( 'month', $month );
	}

	public function name()
	{
		return 'name'
	}
}
