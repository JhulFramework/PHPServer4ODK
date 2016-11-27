<?php namespace _modules\main\nodes\index;

class Handler extends \Jhul\Core\Application\Node\Handler\_Class
{
	public function run()
	{
		$this->forwardTo( 'main.data' );
	}
}
