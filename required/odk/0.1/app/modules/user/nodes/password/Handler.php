<?php namespace _modules\user\nodes\password;

class Handler extends \Jhul\Core\Application\Handler\_Class
{
	public function handle()
	{
		$form = new Form;

		if( $form->collect() && $form->save()  )
		{
			$this->getApp()->setFlash( 'Password changed successfully' );
			$this->getApp()->redirect( $this->getApp()->url()  );
		}

		$this->getApp()->response()->page()->cook( 'password', [ 'form' =>  $form ] );
	}
}
