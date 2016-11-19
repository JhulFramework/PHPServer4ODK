<?php namespace Jhul\Components\Application\Client\Adapters;

/* @Author manish dhruw < 1D3N717Y12@gmail.com >
+=======================================================================================================================
| @Created : Fri 12 Feb 2016 03:38:41 PM IST
|
| @Update : [ 2016-07-08, ]
+---------------------------------------------------------------------------------------------------------------------*/
abstract class _Abstract
{
	use \Jhul\Components\Application\_AccessKey;
	use \Jhul\Core\_AccessKey;

	const CONSUMER_TYPE_HTML = 'HTML';
	const CONSUMER_TYPE_JSON = 'JSON';

	protected $_user;

	protected $_user_ik;


	public function isHTMLConsumer(){ return $this->type == static::CONSUMER_TYPE_HTML; }

	public function userIK() { return $this->_user_ik; }

	public function type() { return static::CLIENT_TYPE; }


	abstract function login( $user );

	abstract function isLoggedIn();

	abstract function user();

	abstract function logout();

	abstract function loginRequired();

	//clients requested language
	abstract function language();
}
