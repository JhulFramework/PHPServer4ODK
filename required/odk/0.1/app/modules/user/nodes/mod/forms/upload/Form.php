<?php namespace _modules\user\nodes\mod\forms\upload;

class Form extends \Jhul\Components\Form\Base
{
	use \Jhul\Components\HTML\Traits\Form;

	public function fields()
	{
		return
		[
			'xform_name'	=> 'alnum',
			'xform_value'	=> 'string',
		];
	}

}
