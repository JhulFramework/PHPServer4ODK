<?php namespace Jhul\Components\BFD\DB;

class Store extends \Jhul\Components\Database\Store\_Class
{
	public function items()
	{
		return
		[
			'write' =>
			[
				'class' 	=> __NAMESPACE__.'\\Attempt',
				'select'	=> '*'
			],
		];
	}

	public function useNULLDataModel()
	{
		return TRUE;
	}

	public function defaultValues()
	{
		return
		[
			'attempts_count' => 0,
		];
	}
}
