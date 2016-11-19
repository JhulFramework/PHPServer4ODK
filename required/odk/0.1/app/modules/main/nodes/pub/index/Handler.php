<?php namespace _modules\main\nodes\pub\index;

class Handler extends \Jhul\Core\Application\Node\Handler\_Class
{
	public function run()
	{
		$this->forwardTo( 'main.data' );
	}
}
