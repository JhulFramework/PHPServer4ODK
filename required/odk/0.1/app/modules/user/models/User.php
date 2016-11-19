<?php namespace _modules\user\models;

class User extends \Jhul\Components\Database\Store\Data\_Class
{
	use \Jhul\Components\Database\Store\Data\_WriteAccessKey;

	public function storeClass()
	{
		return __NAMESPACE__.'\\UserStore';
	}


	public function queryParams()
	{
		return
		[
			'select' => '*',
		];
	}

	public function canManageForms()
	{
		return strpos( $this->read('access'), 'F' );
	}
}
