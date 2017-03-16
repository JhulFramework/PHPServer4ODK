<?php namespace _modules\user\models\user;

class Store extends \Jhul\Components\Database\Store\_Class
{

	public function items()
	{
		return
		[
			'write' =>
			[
				'class' => __NAMESPACE__.'\\M',
				'select' => '*',
			],
		];
	}

	public function useNullDataModel()
	{
		return TRUE;
	}
}
