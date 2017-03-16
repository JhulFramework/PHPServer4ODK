<?php namespace Jhul\Components\HTML\Traits;

trait Form
{
	public function showError( $key )
	{
		$error = $this->error( $key );

		if( !empty($error) )
		{
			return '<div class="form_error">'.$error.'</div>';
		}
	}
}
