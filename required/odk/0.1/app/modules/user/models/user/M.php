<?php namespace _modules\user\models\user;

class M extends \Jhul\Components\Database\Store\Data\_Class
{
	use \Jhul\Components\Database\Store\Data\_WriteAccessKey;

	public function context(){ return 'write' ; }

	public function storeClass() { return __NAMESPACE__.'\\Store'; }

	public function keyName() { return 'user_key' ; }

	public function tableName(){ return 'odk_user'; }

	public function access()
	{
		return $this->read('access') ;
	}

	public function loginStates()
	{
		return [ 'key', 'iname', 'access' ];
	}

	public function iname()
	{
		return $this->read('iname');
	}
}
