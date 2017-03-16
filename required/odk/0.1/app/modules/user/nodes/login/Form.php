<?php namespace _modules\user\nodes\login;

class Form extends \Jhul\Components\Form\_Class
{
	public function name()
	{
		return 'xml_form_upload';
	}

	public function fields()
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

			if( !$user->isNULL() &&  0 === strcmp( $this->password->value(), $user->read('password') )   )
			{
				$this->getApp()->user()->login( $user );
				return TRUE;
			}
		}
	}
}
