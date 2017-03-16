<?php namespace _modules\user\nodes\login;

class Handler extends \Jhul\Core\Application\Handler\_Class
{
	public function handle()
	{

		if( $this->getApp()->user()->isAnon() )
		{
			$form = new Form;


			if( $form->collect() && $form->login())
			{
				$this->getApp()->setFlash('Login Success !');
				$this->getApp()->redirect( $this->getApp()->url() );
			}

			$this->getApp()->response()->page()->cook( 'login', [ 'form'=> $form ] );
		}
	}
}
