<?php namespace Jhul\Components\HTML;

/* @Author : Manish Dhruw < 1D3N717Y12@gmail.com >
+=======================================================================================================================
| @Created : 2016-August-04
----------------------------------------------------------------------------------------------------------------------*/

class HTML
{

	use \Jhul\Core\_AccessKey;

	public $charSet = 'utf-8' ;

	public function encode( $string )
	{
		return htmlspecialchars( $string, ENT_QUOTES, $this->charSet );
	}

	public function link( $name, $url )
	{
		return '<a href="'.$this->encode($url).'">'.$name.'</a>';
	}

	public function selectOptions( $map,  $selected = NULL )
	{
		$options = '';

		foreach( $map as $name => $code )
		{
			$name = $this->getApp()->lipi()->t($name);

			if( $selected == $code || $selected == $name )
			{
				$options .= '<option value="'.$code.'" selected>'.$name.'</option>' ;
			}
			else
			{
				$options .= '<option value="'.$code.'" >'.$name.'</option>' ;
			}
		}

		return $options;
	}

	public function arrayToCheckBox( $options, $name )
	{
		$html = '';

		foreach ( $options as $label => $value)
		{
			$html .= '<input type="checkbox" name="'.$name.'[]" value="'.$value.'" >'.$label.'<br/>';
		}

		return $html;
	}

	public function encode64( $image )
	{
		return base64_encode( $image );
	}

	public function embed( $image )
	{
		return $this->dataType('image')->make( $image. FALSE )->embed();
	}

	public function HB( $size = 1 , $unit = 'px' )
	{
		return new Tab\Tab( $size, $unit );
	}

	//insert anti csrf field in the form
	public function tokenField( $form )
	{
		return '<input type = "hidden" name="'.$form->name( $form->tokeName() ).'" value ="'.$form->token()->value().'" />';
	}

	public function showError( $error )
	{
		if( !empty($error) ) return '<div class="form_error" >'.$error.'</div>';
	}
}
