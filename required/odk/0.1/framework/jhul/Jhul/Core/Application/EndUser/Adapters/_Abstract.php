<?php namespace Jhul\Core\Application\EndUser\Adapters;

/* @Author manish dhruw < 1D3N717Y12@gmail.com >
+=======================================================================================================================
| @Created : Fri 12 Feb 2016 03:38:41 PM IST
|
| @Update : [ 2016-07-08, ]
+---------------------------------------------------------------------------------------------------------------------*/
abstract class _Abstract
{
	use \Jhul\Core\_AccessKey;

	const CONSUMER_TYPE_HTML = 'webpage';
	const CONSUMER_TYPE_JSON = 'json';

	protected $_user;

	protected $_user_ik;


	public function consumerType(){ return static::CONSUMER_TYPE ; }

	public function ifConsumes( $type ){ return  static::CONSUMER_TYPE == $type ; }

	public function userIK() { return $this->_user_ik; }

	abstract function login( $user );

	abstract function isLoggedIn();

	abstract function user();

	abstract function logout();

	abstract function loginRequired();

	//clients requested language
	abstract function language();
}
