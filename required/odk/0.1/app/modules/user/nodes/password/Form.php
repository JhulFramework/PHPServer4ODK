<?php namespace _modules\user\nodes\password;

class Form extends \Jhul\Components\Form\_Class
{
	public function name()
	{
		return 'password_change';
	}

	public function fields()
	{
		return
		[
			'old_password'		=> 'string',

			'new_password'		=> 'string',

			'new_password_confirm'	=> 'string',
		];
	}

	protected $_user;

	public function user()
	{
		if( empty($this->_user) )
		{
			$this->_user = $this->module()->mUser()->getAsVisitor( $this->getApp()->user()->key() );
		}

		return $this->_user;
	}

	protected function postValidate()
	{
		if( strlen( $this->new_password->value() ) < 8 )
		{
			$this->addError( 'new_password', 'Password Length should be more than 8 characters' );
		}

		if( 0 !==  strcmp($this->new_password->value(), $this->new_password_confirm->value() ) )
		{
			$this->addError( 'new_password_confirm', 'does not match with new password' );
		}

		if( !$this->hasError() )
		{
			if( 0 !== strcmp( $this->user()->read('password'), $this->old_password->value() ) )
			{
				$this->addError( 'old_password', 'Wrong Password!' );
			}
		}
	}

	public function save()
	{
		if( $this->validate() )
		{
			$this->user()->write('password', $this->new_password->value())->commit();
			return TRUE;
		}
	}

	public function showError( $field )
	{
		$e = $this->error( $field );

		if( !empty($e) )
		{
			return '<div class="uk-alert-danger uk-background-secondary " uk-alert>'.$e.'</div>';
		}
	}
}
