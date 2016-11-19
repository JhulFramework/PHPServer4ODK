<?php namespace Jhul\Components\Form;


class Captcha
{

	use \Jhul\Core\_AccessKey;

	protected $_form;

	protected $_name = 'captcha';

	public function __construct( $form )
	{
		$this->_form = $form;
	}

	public function field()
	{

		if( $this->isActive() )
		{
			$builder = new \Gregwar\Captcha\CaptchaBuilder;

			$builder->build();

			$this->J()->cx('session')->set( $this->sessionKey() , $builder->getPhrase() );

			return '<div style="background:#141414" class="VPad24"><img src="'.$builder->inline().'" />'.\app\components\gui\GUI::I()->field( $this->_name , $this->_form).'</div>';
		}
	}

	public function name()
	{
		return $this->_name;
	}

	public function sessionKey()
	{
		return 'captcha/'.$this->_form->name().'/value';
	}

	public function validate()
	{

		if( NULL != $this->_form->fieldValue( $this->_name ) )
		{
			return 0 == strcasecmp(  $this->_form->fieldValue( $this->_name ) , $this->value() );
		}

		return FALSE;
	}

	public function isActive()
	{
		return $this->J()->cx('session')->has('captcha/login/enable');
	}

	public function activate()
	{
		$this->J()->cx('session')->set('captcha/login/enable', TRUE);
	}

	public function deActivate()
	{
		$this->J()->cx('session')->remove('captcha/login/enable');
	}


	public function value()
	{
		return $this->J()->cx('session')->get( $this->sessionKey() );
	}

}
