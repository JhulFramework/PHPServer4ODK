<?php namespace _modules\user\nodes\password;

class Handler extends \Jhul\Core\Application\Node\Handler\_Class
{
	public function run()
	{
		if( $this->isEnd() )
		{
			$form = new Form;
			$this->getApp()->outputAdapter()->cook( 'change_password', [ 'form' =>  $form ] );
		}
	}
}
