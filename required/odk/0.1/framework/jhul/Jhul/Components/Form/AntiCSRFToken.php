<?php namespace Jhul\Components\Form;


class AntiCSRFToken
{

	use \Jhul\Core\_AccessKey;

	protected $_value;

	protected $_key;

	public function session()
	{
		return $this->J()->cx('session');
	}

	public function value()
	{
		if( NULL == $this->_value  )
		{
			$this->generateToken();
		}

		return $this->_value;
	}

	public function pullValue()
	{
		return $this->_value ;
	}

	protected function sessionKey()
	{
		return '8a7s6dg8G_antiCSRF/'.$this->key();
	}

	public function key()
	{
		return $this->_key;
	}

	public function __construct( $IK )
	{
		$this->_key = $IK;

		if( $this->session()->has( $this->sessionKey() ) )
		{
			$this->_value = $this->session()->get( $this->sessionKey() );
		}
	}

	public function verify( $tokenValue )
	{

		if(  strlen( $tokenValue ) > 1 )
		{
			$oldValue = $this->_value;

			$this->destroy();

			return  $tokenValue == $oldValue;
		}

		return FALSE;
	}

	public function destroy()
	{
		$this->_value = NULL;
		$this->session()->remove( $this->sessionKey() );
	}

	public function __toString()
	{
		return $this->value();
	}

	//Always generates new Token
	public function generateToken()
	{
		$this->_value =  substr( md5( time() ), 0, 8);
		$this->session()->set( $this->sessionKey() , $this->_value );
	}

}
