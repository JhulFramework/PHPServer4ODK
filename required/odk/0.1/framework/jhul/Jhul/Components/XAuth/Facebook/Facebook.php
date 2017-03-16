<?php namespace Jhul\Components\XAuth\Facebook;

//require_once(JHUL_VENDOR_PATH.'/f45/src/Facebook/autoload.php');



class FaceBook
{

	private $_tokenKey = '__facebook_access_T';

	private $_data;

	private $_client ;

	private $_redirectUri;

	private $_error;

	public function error()
	{
		return $this->_error;
	}

	public function __construct()
	{
		$this->_client = new \Facebook\Facebook([

			'app_id' => '903195929716532',
			'app_secret' => '59a2d9a4d3e7c97d5a30de787b0316d9',
			'default_graph_version' => 'v2.2',
  		]);

		$this->_redirectUri = 'http://' . $_SERVER['HTTP_HOST'] . '/login_f';
	}

	//CHECK IF Has ACCESS TOKEN
	//ON FALSE
	//	redirect to auth url for access token
	// ON TRUE
	//	Loads Access token
	//	Collects Data;
	//@Return DATA
	public function fetchData()
	{
		if( FALSE == $this->accessToken() )
		{
			$this->authorize();
		}

		return $this->loadData();
	}


	public function authorize()
	{
		$helper = $this->client()->getRedirectLoginHelper();
		$permissions = ['email']; // optional
	 	$auth_url = $helper->getLoginUrl( $this->_redirectUri , $permissions);
		header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
	}

	public function client()
	{
		return $this->_client;
	}

	public function accessToken()
	{
		$helper = $this->client()->getRedirectLoginHelper();
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
			//$_SESSION[ $this->_tokenKey ] = (string) $accessToken;
			$this->client()->setDefaultAccessToken( (string)  $accessToken );
			return TRUE;
		}
	}

	public function loadData()
	{
		$response = $this->client()->get('/me?locale=en_US&fields=name,email,gender,verified,picture');

		$data = $response->getGraphUser();

		if( !empty($data['email']) &&  TRUE == $data['verified']  )
		{
			$this->_data['name'] = $data['name'];
			$this->_data['email'] = $data['email'];
			$this->_data['gender'] = $data['gender'];
		}

		return $this->_data;
	}



}
