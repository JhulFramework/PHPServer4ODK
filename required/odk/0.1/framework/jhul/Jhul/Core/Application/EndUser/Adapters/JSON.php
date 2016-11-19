<?php namespace Jhul\Core\Application\Client\Adapters;

/* @Author Manish Dhruw < 1D3N717Y12@gmail.com >
+=======================================================================================================================
|@Created Thu 11 Feb 2016 09:22:34 PM IST
+---------------------------------------------------------------------------------------------------------------------*/
class JSON extends _Abstract
{

	const CLIENT_TYPE = 'MOBILE_APPLICATION';

	private $_CUser;

	private $_rawData = [];

	private $_sessionKey = [];

	public function __construct()
	{
		if( isset($_POST['client'])  )
		{
			$this->_rawData = $_POST['client'];
		}

		$this->_UIK =  $this->load('UIK');
	}


	public function sessionKey()
	{
		if( NULL == $this->_sessionKey )
		{
			$this->_sessionKey = $this->load('sessionKey');
		}

		return $this->_sessionKey;
	}




	public function load( $key )
	{
		if( isset( $this->fields()[$key] ) && isset( $this->_rawData[$key] )  )
		{
			$type = $this->fields()[$key]['type'];

			return $this->validator()->$type( $this->_rawData[$key], $this->fields()[$key] )->filter();
		}
	}

	public function validator()
	{
		return $this->J()->com('Validator');
	}

	public function fields()
	{
		return
		[
			'UIK'			=> [ 'type' => 'posdecnum' ],
			'sessionKey'	=> [ 'type' => 'alnum', ],
		];
	}

	public static function I()
	{
		return new static();
	}

	public function user()
	{
	 	return NULL != $this->CUser() ? $this->CUser()->user() : NULL ;
	}

	public function CUser()
	{
		if( NULL == $this->_CUser )
		{
			$this->_CUser = $this->findCUser();
			if( NULL != $this->_CUser )
			{
				$this->J()->com('JData')->add('ifUserLoggedIn', true );
			}
			else
			{

				$this->J()->com('JData')->add('ifUserLoggedIn', false );

				$this->J()->com('JData')->add( 'error', 'User Authentication Failed' );
			}
		}

		return $this->_CUser;
	}

	public function logout()
	{
		if( NULL != $this->CUser() )
		{
			$this->CUser()->logout();
			$this->CUser()->save();

			$this->_UIK		= NULL;
			$this->_user	= NULL;
			$this->_CUser	= NULL;
		}
	}

	public function isLoggedIn()
	{
		return NULL != $this->user();
	}

	private function findCUser()
	{
		if( NULL != $this->UIK() && NULL != $this->sessionKey() )
		{
			return $this->getApp()->m('User')->webServiceUserDB()
				->setAccessPerspective('S')->loadUser( $this->UIK(), $this->sessionKey()  ) ;
		}
	}


	public function loginRequired(){}

	public function login( $user )
	{

		$this->_CUser = $this->getApp()->m('User')->webServiceUserDB()->setAccessPerspective('S')->byIK( $user->IK() )->fetch() ;

		$this->_CUser->regenerateSessionKey();

		$this->_CUser->save();
	}

	public function JSONResponse()
	{
		if( NULL != $this->user() )
		{
			$user = new \stdClass();

			$user->IK = $this->user()->IK();

			$user->name = $this->user()->name();

			$user->IName = $this->user()->IName();

			$user->sessionKey = $this->cuser()->sessionKey();

			return $user;
		}
	}


}
