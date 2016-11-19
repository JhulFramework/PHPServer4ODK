<?php namespace _modules\user\nodes\logout;

class Handler extends \Jhul\Core\Application\Node\Handler\_Class
{
	public function run()
	{

		$this->getApp()->endUser()->logout();
		$this->getApp()->redirect( $this->getApp()->url()  );
	}
}
