<?php namespace _modules\user\nodes\login;

class Handler extends \Jhul\Core\Application\Node\Handler\_Class
{
	public function run()
	{

		if( !$this->getApp()->endUser()->isLoggedIn() )
		{
			$form = new Form;

			if( $form->collect() && $form->validate() )
			{
				$form->login();
				$this->getApp()->redirect( $this->getApp()->url() );
			}

			$this->getApp()->outputAdapter()->cook( 'login', [ 'form'=> $form ] );
		}
	}
}
