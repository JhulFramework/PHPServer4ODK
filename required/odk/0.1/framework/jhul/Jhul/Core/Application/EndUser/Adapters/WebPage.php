<?php namespace Jhul\Core\Application\EndUser\Adapters;

/* @Author manish dhruw < 1D3N717Y12@gmail.com >
+=======================================================================================================================
| @Created : Fri 12 Feb 2016 03:40:12 PM IST
| @Update : [ 2016-07-08, ]
+---------------------------------------------------------------------------------------------------------------------*/
class WebPage extends _Abstract
{

	const CONSUMER_TYPE = 'webpage';


	public function userIk()
	{
		if( empty($this->_user_ik) )
		{
			$this->_user_ik = $this->J()->cx('session')->get( 'loggedin_user_i' );
		}

		return $this->_user_ik;
	}

	public function userModule()
	{
		return $this->getApp()->m('user');
	}

	public function user(){ return $this->m(); }

	//returns user Model
	public function m()
	{
		if( NULL == $this->_user && NULL != $this->userIK() )
		{
			$this->_user = $this->getApp()->m('user')->mUser()->find( $this->userIK(), 's' );
		}

		return $this->_user ;
	}

	public function isLoggedIn()
	{
		return NULL != $this->userIK() ;
	}

	public function loginURL()
	{
		return $this->getApp()->mURL()->get('login');
	}

	public function homeURL()
	{
		return $this->getApp()->mURL()->get('home');
	}

	public function loginRequired()
	{
		if( !$this->isLoggedIn() )
		{
			$this->J()->cx('session')->set( 'goToAfterLogin', $this->getApp()->nodeURL() );
			$this->getApp()->redirect( $this->loginURL() );
		}

		return $this->isLoggedIn();
	}

	public function login( $user, $rememberMe = FALSE )
	{

		if( NULL == $user->ik() ) throw new \Exception (' User ID required for login ');

		$this->J()->cx('session')->regenerateId();

		$this->J()->cx('session')->set( 'loggedin_user_i', $user->IK()  );

		//TODO
		if( $rememberMe )
		{

		}

		if( $this->J()->cx('session')->has('goToAfterLogin')  )
		{
			$this->getApp()->redirect( $this->J()->cx('session')->pull('goToAfterLogin') );
		}

		return TRUE;
	}


	//TODO logout cookies
	public function logOut()
	{
		$this->J()->cx('session')->remove( 'loggedin_user_i' ) ;
		$this->_UIK = NULL;
		$this->_user = NULL;
	}

	public function language()
	{
		return $this->J()->cx('session')->has( 'language' ) ? $this->J()->cx('session')->has( 'language' ) : 'eng';
	}

}
