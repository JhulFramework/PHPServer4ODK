<?php namespace Jhul\Components\BFD\DB;

class Attempt extends \Jhul\Components\Database\Store\Data\_Class
{

	use \Jhul\Components\Database\Store\Data\_WriteAccessKey;

	function increment()
	{
		return $this->write('attempts_count', $this->read('attempts_count') + 1 );
	}

	function countAttempts()
	{
		return $this->read('attempts_count');
	}

	function register()
	{
		return $this->increment();
	}

	function clear()
	{
		return $this->write('attempts_count', 0 );
	}



	function storeClass()
	{
		return __NAMESPACE__.'\\Table';
	}

	function queryParams()
	{
		return
		[
			'select' => '*',
		];
	}
}
