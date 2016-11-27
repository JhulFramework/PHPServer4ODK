<?php namespace _modules\user\models\user;

class M extends \Jhul\Components\Database\Store\Data\_Class
{
	use \Jhul\Components\Database\Store\Data\_WriteAccessKey;

	public function storeClass() { return __NAMESPACE__.'\\Store'; }


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
