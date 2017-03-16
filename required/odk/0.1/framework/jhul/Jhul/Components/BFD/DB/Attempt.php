<?php namespace Jhul\Components\BFD\DB;

class Attempt extends \Jhul\Components\Database\Store\Data\_Class
{

	use \Jhul\Components\Database\Store\Data\_WriteAccessKey;

	public function increment()
	{
		return $this->write('attempts_count', $this->read('attempts_count') + 1 );
	}

	public function countAttempts() { return $this->read('attempts_count'); }

	public function register() { return $this->increment(); }

	public function clear() { return $this->write('attempts_count', 0 ); }

	public function tableName() { return  'brute_force_defense'; }

	public function keyName() { return 'identity_key'; }

	public function storeClass(){ return __NAMESPACE__.'\\Store'; }

	public function context() { return  'write' ; }
}
