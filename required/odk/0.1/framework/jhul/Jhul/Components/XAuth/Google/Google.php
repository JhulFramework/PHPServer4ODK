<?php namespace Jhul\Components\XAuth\Google;

class Google
{
	//private $_id = '783470526493-r778u6t8tvns4n596o4q5hcip1kd833t.apps.googleusercontent.com';
	//private $_secrete = 'nF4ztoGyRO5cCXZf6PqUsTlu';

	//private $_redirectUri ;

	//private $_client;

	private $_error;

	private $_tokenKey = '__Google_Access_T';

	public function error()
	{
		return $this->_error;
	}

	private $_scopes =
	[
		"https://www.googleapis.com/auth/userinfo.email",
		"https://www.googleapis.com/auth/userinfo.profile"
	];

	public function __construct()
	{


		$this->_client = new \Google_Client();

		$this->_client->setAuthConfigFile( __DIR__.'/client_secrets.json');

		$this->_client->addScope( $this->_scopes );

		$this->_redirectUri = 'http://' . $_SERVER['HTTP_HOST'] . '/login_g';

	}

	public function fetchData()
	{
		echo __LINE__.'---'.__FILE__.'<pre>';
		var_dump( $this->accessToken() );
		echo '</pre>';
		exit;

		if( FALSE == $this->accessToken() )
		{
			$this->authorize();
		}

		return $this->loadData();
	}

	//Checks for access token
	//And Checks if it is valid
	public function accessToken()
	{
		//Checks for old access toke
		if( NULL != $this->_accessToken() )
		{
			$this->_client->setAccessToken( $this->_accessToken() );

			return FALSE == $this->_client->isAccessTokenExpired();
		}

		return FALSE;
	}

	private function _accessToken()
	{
		if( isset($_SESSION[ $this->_tokenKey ] ) )
		{
			return $_SESSION[ $this->_tokenKey ];
		}
	}

	//Must Be Called after setting validAccessToken
	private function loadData( )
	{

		$service  = new \Google_Service_Oauth2($this->_client);

		$data = $service->userinfo->get()  ;

		if( isset( $data['email'] ) && TRUE == $data['verifiedEmail'] )
		{
			$this->_data['name'] = $data['name'];
			$this->_data['email'] = $data['email'];
			$this->_data['gender'] = $data['gender'];
			$this->_data['avatar'] = $data['picture'];
		}

echo __LINE__.'---'.__FILE__.'<pre>';
var_dump(  $this->_data );
echo '</pre>';
exit;

		return $this->_data;
	}

	public function authorize()
	{
		$this->_client->setRedirectUri( $this->_redirectUri );

echo __LINE__.'---'.__FILE__.'<pre>';
var_dump('dmp');
echo '</pre>';
exit;

		if (! isset($_GET['code']))
		{
			$auth_url = $this->_client->createAuthUrl();
			header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
		}
		else
		{
			$this->_client->authenticate($_GET['code']);
			$_SESSION[ $this->_tokenKey ] = $this->_client->getAccessToken();
			//header('Location: ' . filter_var($this->_redirectUri, FILTER_SANITIZE_URL));
		}
	}
}
