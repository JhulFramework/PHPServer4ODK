<?php namespace Jhul\Components\BFD\DB;

class Table extends \Jhul\Components\Database\Store\_Class
{

	public function name()
	{
		return 'brute_force_defense';
	}

	public function itemKeyName()
	{
		return 'ik';
	}


	public function dataClasses()
	{
		return
		[
			's' => __NAMESPACE__.'\\Attempt',
		];
	}
}
