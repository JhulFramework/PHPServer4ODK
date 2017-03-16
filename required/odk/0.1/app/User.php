<?php namespace app;

class User extends \Jhul\Core\Application\User\M
{
	public function canManageForms()
	{
		return FALSE !== strpos( $this->getState('access'), 'F' );
	}
}
