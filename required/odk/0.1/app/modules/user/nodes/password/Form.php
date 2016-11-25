<?php namespace _modules\user\nodes\password;

class Form extends \Jhul\Components\Form\Base
{
	protected function fields()
	{
		return
		[
			'old_password'	=> 'string',

			'new_password'	=> 'string',

			'new_password_re'	=> 'string',
		];
	}
}
