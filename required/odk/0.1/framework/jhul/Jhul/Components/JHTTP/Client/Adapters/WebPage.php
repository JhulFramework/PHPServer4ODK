<?php namespace Jhul\Components\Application\Client\Adapters;

/* @Author manish dhruw < 1D3N717Y12@gmail.com >
+=======================================================================================================================
| @Created : Fri 12 Feb 2016 03:40:12 PM IST
| @Update : [ 2016-07-08, ]
+---------------------------------------------------------------------------------------------------------------------*/
class WebPage extends _Abstract
{

	const CLIENT_TYPE = 'WEBPAGE';


	public function __construct()
	{
		$this->_user_ik = $this->J()->com('Session')->get( 'loggedin_user_i' );
		$this->user();
	}


	public function userModule()
	{
		return $this->getApp()->m('user');
	}

	public function user()
	{
		if( NULL == $this->_user && NULL != $this->userIK() )
		{
			$this->_user = $this->getApp()->m('user')->manager()->find( $this->userIK(), 's' );
		}

		return $this->_user ;
	}

	public function isLoggedIn()
	{
		return NULL != $this->userIK() ;
	}

	public function loginURL()
	{
		return $this->J()->com('URLProvider')->get('login');
	}

	public function homeURL()
	{
		return $this->J()->com('URLProvider')->get('home');
	}

	public function loginRequired()
	{
		if( !$this->isLoggedIn() )
		{
			$this->J()->com('Session')->set( 'goToAfterLogin', $this->getApp()->nodeURL() );
			$this->getApp()->redirect( $this->loginURL() );
		}

		return $this->isLoggedIn();
	}

	public function login( $user, $rememberMe = FALSE )
	{

		if( NULL == $user->ik() ) throw new \Exception (' User ID required for login ');

		$this->J()->com('Session')->regenerateId();

		$this->J()->com('Session')->set( 'loggedin_user_i', $user->IK()  );

		//TODO
		if( $rememberMe )
		{

		}

		if( $this->J()->com('Session')->has('goToAfterLogin')  )
		{
			$this->getApp()->redirect( $this->J()->com('Session')->pull('goToAfterLogin') );
		}

		return TRUE;
	}


	//TODO logout cookies
	public function logOut()
	{
		$this->J()->com('Session')->remove( 'loggedin_user_i' ) ;
		$this->_UIK = NULL;
		$this->_user = NULL;
	}

	public function language()
	{
		return $this->J()->com('Session')->has( 'language' ) ? $this->J()->com('Session')->has( 'language' ) : 'eng';
	}

}
