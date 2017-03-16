<?php namespace Jhul\Components\Form;


class Captcha
{

	use \Jhul\Core\_AccessKey;

	protected $_form;

	protected $_name = '_captcha';

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

	public function name() { return $this->_name; }

	public function key(){ return 'captcha.'.$this->_form->name() ; }

	public function validate()
	{
		if( NULL != $this->_form->fieldValue( $this->name() ) && $this->isActive() )
		{
			return 0 == strcasecmp(  $this->_form->fieldValue( $this->_name ) , $this->session()->pull( $this->key() ) );
		}

		return FALSE;
	}

	public function isActive() { return $this->session()->has( $this->key() ); }

	public function activate() { $this->session()->set( $this->key() ); }

	public function deActivate(){ $this->session()->remove( $this->key() ); }

	public function value(){ return $this->session()->get( $this->key() ); }

	protected function session(){ return $this->getApp()->session(); }
}
