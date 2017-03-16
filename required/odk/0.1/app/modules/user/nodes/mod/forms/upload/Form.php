<?php namespace _modules\user\nodes\mod\forms\upload;

class Form extends \Jhul\Components\Form\_Class
{
	use \Jhul\Components\HTML\Traits\Form;

	public function name()
	{
		return 'xml_form_upload';
	}

	public function fields()
	{
		return
		[
			'xform_name'	=> 'alnum',
			'xform_value'	=> 'string',
		];
	}

}
