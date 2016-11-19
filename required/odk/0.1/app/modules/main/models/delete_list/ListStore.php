<?php namespace _modules\main\models;

class ListStore extends \Jhul\Components\Database\Store\_Class
{

	public function itemKeyName( $name )
	{
		return 'ik' ;
	}

	public function name( $year )
	{
		return 'submitted_forms' ;
	}
}
