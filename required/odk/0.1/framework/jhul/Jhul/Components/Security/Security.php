<?php namespace Jhul\Components\Security;

class Security
{


	public $algorithm = 'sha256';

	#length of the random key
	public $lengthOfRandKey = 8 ;

	public $paddingRightLength = 8 ;

	public $cipher = MCRYPT_RIJNDAEL_256 ;

	protected $key = "majkhkjkjhnish" ;

	protected $keyRaw ;

	public function isSingleton()
	{
		return TRUE;
	}

	public function altGet( $name, $value = 0 )
	{
		return empty($value) ? $this->$name : $value ;
	}

	public function __construct()
	{
		mb_internal_encoding('UTF-8');
	}

	public function setKey( $key )
	{
		$this->keyRaw = $key ;

		$this->key = $this->mhash( $this->keyRaw );
	}

	public function hashMac( $data, $key = NULL, $algo = NULL )
	{
		return hash_hmac( $this->altget( 'algorithm', $algo ) , $data , $this->mhash( $this->altGet( 'keyRaw', $key ) ) );
	}



	public function padData( $data, $key = NULL , $algo = NULL )
	{
		return $this->hashCRC32B($data, $key ).$data;
	}

	public function unpadData( $data, $key = NULL , $algo = NULL )
	{
		return $this->hashMac($data, $key ).$data;
	}

	/* useful for generating small length key for caching */
	public function hashCRC32B( $data, $key = NULL )
	{
		return hash_hmac( 'crc32b' , $data , 'key');
	}

	public function mHash( $input )
	{
		return mhash( MHASH_MD5, $input );
	}


	// Initilization Vector
	public function IV(  $size = NULL )
	{
		return mcrypt_create_iv( $this->altGet( 'lengthOfRandKey', $size ) , MCRYPT_RAND );
	}

	public function encrypt( $data, $key = NULL )
	{

		$key = $this->eKey( $key );

		$iv_size = mcrypt_get_iv_size( MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC );

		$iv = $this->IV( $iv_size );

		$data = $iv.mcrypt_encrypt( MCRYPT_RIJNDAEL_256, $key, $data, MCRYPT_MODE_CBC, $iv);

		return base64_encode( $data );

	}

	public function decrypt( $data, $key = NULL )
	{
		$data = base64_decode( $data );

		$size = mcrypt_get_iv_size( MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC ) ;

		$iv = mb_substr( $data, 0,  $size );

		$data = mb_substr( $data, $size );

		return mcrypt_decrypt( MCRYPT_RIJNDAEL_256, $this->encKey($key) , $data, MCRYPT_MODE_CBC, $iv );
	}

	public function hash( $data, $length = 8  )
	{
		while( mb_strlen($data) < $length )
		{
			$data .= $this->hashCRC32B($data);
		}

		return mb_substr( $data, 0, $length  );
	}


	public function testHashSA( $p = 'mmmmmmmm' )
	{
		$h = $this->hashSA($p);

		return $this->hashSAMatch($p, $h);
	}

	#Hash Stand Alone, no seperate Key

	public function hashSA( $raw )
	{
		if( strlen($raw) == 96 )
		{
			throw new \Exception( 'Possible double hashing password "'.$raw.'" ' , 1);
		}

		$raw = (string) $raw;

		$salt = $this->randomKey(6,3);

		return base64_encode( $salt.$this->hashmac( $raw , $salt ) );
	}

	public function hashSAMatch( $raw, $hashed )
	{
		$raw = (string) $raw ;

		$hashed = base64_decode( $hashed );

		$salt = mb_substr( $hashed , 0, 6 );

		return $hashed === ( $salt.$this->hashMac( $raw, $salt ) );
	}

	public function randKey( $length = 10, $charStrength = 0 )
	{
		return $this->randomKey( $length, $charStrength );
	}

	public function randomKey( $length = 10, $charStrength = 0 )
	{
		$char = '0123456789';

		if( $charStrength > 0 )
			$char .= 'abcdefghijklmnopqrstuvwxyz';

		if( $charStrength > 1 )
			$char .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

		if( $charStrength > 2 )
			$char .= '!@#$%^&*(){}.|!@#$%^&*(){}.|';

		$char = str_shuffle($char);

		$charactersLength = strlen($char);

		$randomString = '';

		for ($i = 0; $i < $length; $i++)
		{
			$randomString .= $char[ rand( 0, $charactersLength - 1 ) ];
		}

		return $randomString;
	}
}
