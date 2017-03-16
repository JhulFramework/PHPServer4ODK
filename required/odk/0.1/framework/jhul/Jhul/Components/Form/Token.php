<?php namespace Jhul\Components\Form;


class Token
{

	use \Jhul\Core\_AccessKey;

	protected $_key;

	protected $_fieldName;

	public function __construct( $formName, $fieldName )
	{
		$this->_key = $this->prefixKey($formName);
		$this->_fieldName = $fieldName;
	}

	public function key(){ return $this->_key; }

	public function fieldName()
	{
		return $this->_fieldName;
	}

	public function session()
	{
		return $this->getApp()->session();
	}

	public function ifExists()
	{
	 	return $this->session()->has( $this->key() );
	}

	public function value()
	{

		if( !$this->ifExists() )
		{
			$this->session()->set( $this->key() , $this->generateToken() );
		}

		return $this->session()->get( $this->key() );
	}

	protected function prefixKey( $formName )
	{
		return '_CSRFToken.'.$formName;
	}

	public function verify( $token )
	{
		if( $this->ifExists() )
		{
			return $this->session()->pull( $this->key() ) == $token ;
		}

		return FALSE;
	}

	//Always generates new Token
	public function generateToken()
	{
		return substr( md5( time() ), 0, 8);
	}

	public function __toString()
	{
		return $this->value();
	}

}
