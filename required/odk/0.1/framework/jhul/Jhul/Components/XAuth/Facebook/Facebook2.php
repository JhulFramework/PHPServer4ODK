<?php namespace Jhul\Components\XAuth\Facebook;

//require_once(JHUL_VENDOR_PATH.'/f45/src/Facebook/autoload.php');


class FaceBook
{

	use \Jhul\Core\Traits\DependencyProvider;

	private $_fb ;

	private $_error;

	public function error()
	{
		return $this->_error;
	}

	public function __construct()
	{
		$this->_fb = new \Facebook\Facebook([

			'app_id' => '903195929716532',
			'app_secret' => '59a2d9a4d3e7c97d5a30de787b0316d9',
			'default_graph_version' => 'v2.2',
  		]);
	}

	public function url()
	{

		$helper = $this->fb()->getRedirectLoginHelper();
		$permissions = ['email']; // optional
	 	return $helper->getLoginUrl( $this->conf()->get('siteUrl').'/login_f', $permissions);

	}

	public function fb()
	{
		return $this->_fb;
	}

	public function accessToken()
	{
		$helper = $this->fb()->getRedirectLoginHelper();
		try
		{
			$accessToken = $helper->getAccessToken();
		}
		catch(\Facebook\Exceptions\FacebookResponseException $e)
		{

			$this->_error = 'Graph returned an error: ' . $e->getMessage();
 			return FALSE;
		}
		catch(\Facebook\Exceptions\FacebookSDKException $e)
		{
			// When validation fails or other local issues
			$this->_error = 'Facebook SDK returned an error: ' . $e->getMessage();
			return FALSE;
		}

		if (isset($accessToken))
		{
			// Logged in!
			$_SESSION['facebook_access_token'] = (string) $accessToken;

			return TRUE;
		}
	}

	public function collect()
	{
		// Sets the default fallback access token so we don't have to pass it to each request

		if(!isset($_SESSION['facebook_access_token']) ) return FALSE;

		$this->fb()->setDefaultAccessToken( $_SESSION['facebook_access_token'] );

		try
		{
			$response = $this->fb()->get('/me?locale=en_US&fields=name,email');

			$this->_userNode = $response->getGraphUser();
			return TRUE;
		}
		catch(\Facebook\Exceptions\FacebookResponseException $e)
		{
			$this->_error = 'Graph returned an error: ' . $e->getMessage();
		}
		catch(\Facebook\Exceptions\FacebookSDKException $e)
		{
			$this->_error = 'Facebook SDK returned an error: ' . $e->getMessage();
		}

		return FALSE;
	}

	private $_userNode ;

	public function user()
	{
		return $this->_userNode;
	}
}
