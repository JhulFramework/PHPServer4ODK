<?php namespace Jhul\Components\Form;

/*----------------------------------------------------------------------------------------------------------------------
 *@Author Manish Dhruw < 1D3N717Y12@gmail.com >
 *
 *@Created Tue 22 Sep 2015 05:14:21 AM IST
 *--------------------------------------------------------------------------------------------------------------------*/


abstract class Base_Zero
{


	use \Jhul\Core\_AccessKey;

	// use \Jhul\Core\Application\Module\_AccessKey;

	use \Jhul\Utils\Traits\Errorable ;

	public static function I() { return new static() ; }


	//Name of This Form
	protected $_name ;

	//name of antiCSRFToken
	protected $_antiCSRFTokenName = 'antiCSRFToken';

	//AntiCSRFToken Object
	protected $_antiCSRFToken;

	//returns form name
	//Override , to set form name ,
	//By Default form model name will be used as form name
	public function name()
	{
		if( NULL == $this->_name )
		{
			$class = get_called_class();

			$this->_name = substr( $class, strrpos( $class, '\\'  ) + 1 );
		}
		return $this->_name;
	}

	public function antiCSRFToken()
	{
		if( NULL == $this->_antiCSRFToken )
		{
			$this->_antiCSRFToken = new AntiCSRFToken( $this->name() );
		}

		return $this->_antiCSRFToken;
	}

	// //metod to provide validator dependency
	// public function validator()
	// {
	// 	return $this->J()->com('Validator');
	// }

	//insert anti csrf field in the form
	public function CSRFCheckField()
	{
		return '<input type = "hidden" '.$this->fieldName( $this->_antiCSRFTokenName ).' value ="'.$this->antiCSRFToken()->value().'" />';
	}


	//Verifies AntiCSRFToken
	public function CSRFCheck()
	{
		if( isset( $_POST[ $this->name() ][ $this->_antiCSRFTokenName ] )  )
		{
			return $this->antiCSRFToken()->verify( $_POST[ $this->name() ][ $this->_antiCSRFTokenName ]  );
		}

		return FALSE;
	}

	public function htmlEncode( $text )
	{
		return htmlspecialchars( $text, ENT_QUOTES, 'UTF-8' );
	}
}
