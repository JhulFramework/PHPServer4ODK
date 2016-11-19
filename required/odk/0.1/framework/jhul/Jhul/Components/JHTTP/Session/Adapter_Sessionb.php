<?php namespace Jhul\Components\MHttp\Session;

/*----------------------------------------------------------------------------------------------------------------------
 *@Author
 *	-Manish Dhruw [1D3N717Y12@gmail.com]
 *
 *
 *@Created
 *	-Friday 21 November 2014 08:11:19 PM IST
 *
 *@Updated
 *	-Saturday 23 May 2015 04:09:52 PM IST
 *--------------------------------------------------------------------------------------------------------------------*/

class Adapter_Session extends ArrayAccess implements AdapterInterface
{

	//use \Jhul\Core\Traits\DependencyProvider;

	const VERSION = '0.3';

	public $nspace = '_jhul_session' ;

	public $flash_namespace = '_jhul_flash' ;

	protected $_flash ;

	protected $map = [];

	public function map()
	{
		return $this->map;
	}

	public function regenerateId( $delOld = FALSE )
	{
		return session_regenerate_id( $delOld ) ;
	}

	public function _sessionStart()
	{
		session_set_cookie_params(0);

	      $sn = session_name();

	      if (isset($_COOKIE[$sn]))
		{
	          $sessid = $_COOKIE[$sn];
	      }
		else if (isset($_GET[$sn]))
		{
	          $sessid = $_GET[$sn];
	      }
		else
		{
	          return session_start();
	      }

		if (!preg_match('/^[a-zA-Z0-9,\-]{22,40}$/', $sessid))
		{
			unset($_COOKIE[$sn]);
			return false;
		}
	      return session_start();
	}



	public function sessionStart()
	{

		if( !$this->_sessionStart() )
		{
			session_id( uniqid() );
			session_start();
			return session_regenerate_id(TRUE);
		}
	}

	public function start()
	{
		if( $this->isActive() ) return TRUE;


		if( $this->sessionStart() )
		{
			if( !empty($this->nspace) )
			{

				//Checking if already created
				if( !isset($_SESSION[$this->nspace]) || !is_array($_SESSION[$this->nspace]) )
				{
					$_SESSION[$this->nspace] = array();
				}

				$this->map = &$_SESSION[$this->nspace] ;
			}
			else
			{
				$this->map = &$_SESSION ;
			}

			return TRUE;
		}
	}

	public function isActive()
	{
		return PHP_SESSION_ACTIVE === session_status() ;
	}

	public function close()
	{
		session_write_close();
	}

	public function name()
	{
		return session_name();
	}

	public function setName($name)
	{
		session_name($name);
	}

	public function id()
	{
		return session_id();
	}

	/*
	 * Lazily creates flash
	**/
	public function flash()
	{
		if( NULL == $this->_flash  )
		{

			if( !isset($this->map[ $this->flash_namespace ]) || !is_array($this->map[ $this->flash_namespace ]) )
			{
				$this->map[ $this->flash_namespace ] = array();
			}

			$this->_flash = new Flash( $this->map[ $this->flash_namespace ] );
		}

		return $this->_flash ;
	}


}
