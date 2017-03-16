<?php namespace Jhul\Core\Application\User;

/* @Author manish dhruw < 1D3N717Y12@gmail.com >
+=======================================================================================================================
| @Created : Fri 12 Feb 2016 03:38:41 PM IST
| SINGLETON
| @Update : [ 2016-07-08, 2016-12-20, 2017-01-29 ]
+---------------------------------------------------------------------------------------------------------------------*/
class M
{
	use \Jhul\Core\_AccessKey;

	const KEY_NAME = 'user_key';

	//data can be store to sahre accros nodes
	protected $_data = [];

	protected $_host_user_data_model ;

	// vistotr user data model
	protected $_data_model;

	//Identity Key of user
	protected $_key;

	public function __construct( $appURL )
	{
		$this->_key = $this->session()->get( static::KEY_NAME );

		$this->_request = new Request($appURL);
	}

	public function iname(){ return $this->getState('iname'); }

	public function isWebPageConsumer() { return 'webpage' == $this->request()->mode() ; }

	public function isJSONConsumer() { return 'json' == $this->request()->mode() ; }

	public function login( $user, $rememberMe = FALSE )
	{
		if( NULL == $user->key() ) throw new \Exception (' User ID required for login ');

		$this->session()->regenerateKey();

		foreach ( $user->loginStates() as $state )
		{
			$this->setState( $state, $user->$state() );
		}

		$this->setState( static::KEY_NAME, $user->key()  );


		if( $this->session()->has('goToAfterLogin')  )
		{
			$this->getApp()->redirect( $this->session()->pull('goToAfterLogin') );
		}

		return TRUE;
	}

	//TODO logout cookies
	public function logout()
	{
		$this->session()->remove( static::KEY_NAME ) ;
		$this->_key = NULL;
		$this->_data_model = NULL;
	}

	public function isAnon(){ return NULL == $this->key() ; }


	public function ifSignInRequired()
	{
		if( !$this->isSigned() )
		{
			$this->session()->set( 'goToAfterLogin', $this->getApp()->nodeURL() );
			$this->getApp()->redirect( $this->loginURL() );
		}

		return $this->isSigned();
	}

	public function key() { return $this->_key; }

	public function l10n()
	{
		return $this->session()->has( 'l10n' ) ? $this->session()->get( 'l10n' ) : $this->getApp()->lipi()->getCode('iso6393')->name() ;
	}

	//returns user Model
	protected function m()
	{
		if( NULL == $this->_data_model && NULL != $this->key() )
		{
			$this->_data_model = $this->getApp()->m('user')->mUser()->getAsVisitor( $this->key() );
		}

		return $this->_data_model ;
	}

	public function request(){ return $this->_request; }

	//input
	public function input(){ return $this->_request; }


	public function setL10N( $value ){ return $this->setState( 'l10n', $value ); }


	//Access session
	public function session() { return $this->getApp()->session() ; }


	public function has( $key )
	{
		return array_key_exists( $key, $this->_data );
	}

	public function set( $key, $value )
	{
		$this->_data[$key] = $value;
	}

	public function get( $key, $required = TRUE )
	{
		if( isset($this->_data[$key]) ) return $this->_data[$key];

		if( $required ) throw new \Exception( 'Data not set with key "'.$key.'" for current user' , 1);
	}

	public function setState( $key, $value )
	{
		$this->session()->set( $key, $value );
	}

	public function getState( $key )
	{
		return $this->session()->get( $key );
	}

	public function url( $append = '' )
	{
		if( !empty($append) )
		{
			return $this->url().'/'.$append;
		}
		return $this->getApp()->url().'/@'.$this->iname();
	}

	// public function context()
	// {
	// 	return $this->getState('context');
	// }
	//
}
