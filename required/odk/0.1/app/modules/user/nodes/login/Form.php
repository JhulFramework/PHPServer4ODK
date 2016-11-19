<?php namespace _modules\user\nodes\login;

class Form extends \Jhul\Components\Form\Base
{
	protected function fields()
	{
		return
		[
			'iname' => 'iname',

			'password'	=> 'string',
		];
	}

	public function login()
	{


		if( !$this->hasError() )
		{
			$user = $this->module()->mUser()->findByIName( $this->iname->value() );

			$this->getApp()->endUser()->login( $user );
		}
	}
}
