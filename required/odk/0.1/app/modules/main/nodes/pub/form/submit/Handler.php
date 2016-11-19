<?php namespace _modules\main\nodes\pub\form\submit;

class Handler extends \Jhul\Core\Application\Node\Handler\_Class
{
	public function run()
	{

		if( !empty($_FILES)  )
		{
			if( is_file($_FILES['xml_submission_file']['tmp_name']) )
			{
				// $this->J()->cx('papertrail')->log( __LINE__.'FILES NOT EMPTY' );
				$x2h = new \app\helpers\x2h\X2H;

				$form = $x2h->make( $_FILES['xml_submission_file']['tmp_name']  );

				\_modules\main\models\form\Data::I()->store()->add( $form );

				$this->J()->cx('http')->R()->setStatusCode(201);
			}
		}
		else
		{

			if( $this->authorize() )
			{
				// $this->J()->cx('papertrail')->log( 'FORM SUBMISSION: AUTHORIZED' );
				// $this->J()->cx('papertrail')->log( 'FORM SUBMISSION:SETTING RESPONSE CODE to 204 ' );
				$this->J()->cx('http')->R()->setStatusCode(204);
				return;
			}
			else //if not authorized
			{
				// $this->J()->cx('papertrail')->log( 'FORM SUBMISSION: NOT AUTHORIZED' );
				// $this->J()->cx('papertrail')->log( 'FORM SUBMISSION:SETTING RESPONSE CODE to 401 ' );

				$nonce = md5(uniqid());
				$opaque = md5(uniqid());

				$realm = 'Authorized users of example.com';


				$this->J()->cx('http')->R()->setStatusCode(401);

				$this->J()->cx('http')->R()->headers->set( 'Content-Type', 'text/html') ;

				$this->J()->cx('http')->R()->headers->set( 'WWW-Authenticate',  sprintf('Digest realm="%s", nonce="%s", opaque="%s"', $realm, $nonce, $opaque) ) ;
			}

		}
	}

	public function authorize()
	{
		//TODO ENABLE AUTHORIZATION LOGIC
		if ( !empty($_SERVER['PHP_AUTH_DIGEST']) )
		{
			// $this->J()->cx('papertrail')->log( 'PHP_AUTH_DIGEST: '.serialize( $_SERVER['PHP_AUTH_DIGEST'] ) );
			// $this->J()->cx('papertrail')->log( 'POST: '.serialize( $_POST ) );
			// $this->J()->cx('papertrail')->log( 'GET: '.serialize( $_GET ) );
			// $this->J()->cx('papertrail')->log( 'PHP_AUTH_DIGEST: '.serialize( $_SERVER ) );


			return TRUE;
		}

		return FALSE;
	}
}
