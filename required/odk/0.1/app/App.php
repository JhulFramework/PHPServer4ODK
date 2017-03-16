<?php namespace app;

class App extends \Jhul\Core\Application\Application
{
	public function showNotification( $msg, $status = 'primary' )
	{
		$this->response()->page()->mJS()->embed( 'UIkit.notification( "'.$msg.'", "'.$status.'");' );
	}

	public function showFlash()
	{
		if( $this->hasFlash() )
		{
			$this->showNotification( $this->getFlash()  );
		}
	}
}
