<?php namespace _modules\user\nodes\logout;

class Handler extends \Jhul\Core\Application\Handler\_Class
{
	public function handle()
	{

		$this->getApp()->user()->logout();
		$this->getApp()->redirect( $this->getApp()->url()  );
	}
}
