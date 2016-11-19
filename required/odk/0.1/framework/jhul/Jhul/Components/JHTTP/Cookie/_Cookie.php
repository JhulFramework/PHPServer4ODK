<?php namespace Jhul\Components\MHttp\Cookie;

/*----------------------------------------------------------------------------------------------------------------------
 *@Aauthor [Manish Dhruw] <1D3N717Y12@gmail.com>
 *
 *@Created - Saturday 23 May 2015 08:39:59 AM IST
 *--------------------------------------------------------------------------------------------------------------------*/

//require_once( __DIR__.'/php-encryption-master/autoload.php' );

//use \Defuse\Crypto\Crypto;
//use \Defuse\Crypto\Exception as Ex;

class _Cookie
{

	public static $p =
	[

		//secure
		'S' => FALSE,

		//path
		'P'	=> '/',

		//for domain name
		'D'	=> '',

		//expire
		'E'	=> 0 ,

		//httponly
		'H' => TRUE,
	];

	private $_name ;

	//raw value;
	private $_value;

	private $_useEncryption = FALSE;

	public function ifUseEncryption()
	{
		return TRUE === $this->_useEncryption;
	}

	public function __construct( $name, $value)
	{

		$this->_name	= $name;
		$this->_value	= $value;
	}

	public function save( $params = [] )
	{
		$p = array_merge( static::$p, $params );

		$value = $this->_value;

		if( $this->ifUseEncryption() )
		{
			$value = $this->_encrypted();
		}

		return setcookie( $this->_name, $value, $p['E'], $p['P'], $p['D'], $p['S'], $p['H'] );
	}

	public function delete( $params = [] )
	{
		$p = array_merge( static::$p, $params );
		unset($_COOKIE[$this->_name]);
		return setcookie( $this->_name, NULL, -1, $p['P'], $p['D'] );
	}

	public static function I( $name, $value )
	{
		return new static( $name, $value );
	}

	public function raw()
	{
		return $this->_value;
	}

	public function value()
	{
		if( $this->ifUseEncryption() )
		{
			return $this->_decrypted();
		}

		return $this->raw();
	}

	//Secure
	public function S( $key = NULL )
	{
		$this->_encryptionKey = $key;

		if( NULL == $this->_encryptionKey )
		{
			$this->_encryptionKey = $this->_generateKey();
		}

		if( NULL != $this->_encryptionKey )
		{
			$this->_useEncryption = TRUE;
		}

		return $this;
	}

	private function _encrypted()
	{
		try
		{
			return Crypto::encrypt($this->_value, $this->_encryptionKey);

		}
		catch (Ex\CryptoTestFailedException $ex)
		{

		}
		catch (Ex\CannotPerformOperationException $ex)
		{

		}

		return NULL ;
	}

	private function _decrypted()
	{
		try
		{
			return Crypto::decrypt($this->_value, $this->_encryptionKey);
		}
		catch (Ex\InvalidCiphertextException $ex)
		{
			// VERY IMPORTANT
			// Either:
			//   1. The ciphertext was modified by the attacker,
			//   2. The key is wrong, or
			//   3. $ciphertext is not a valid ciphertext or was corrupted.
			// Assume the worst.
			//die('DANGER! DANGER! The ciphertext has been tampered with!');
		}
		catch (Ex\CryptoTestFailedException $ex)
		{
			//die('Cannot safely perform decryption');
		}
		catch (Ex\CannotPerformOperationException $ex)
		{
			//die('Cannot safely perform decryption');
		}
	}

	private function _generateKey()
	{
		try
		{
			return Crypto::createNewRandomKey();
			// WARNING: Do NOT encode $key with bin2hex() or base64_encode(),
			// they may leak the key to the attacker through side channels.
		}
		catch (Ex\CryptoTestFailedException $ex)
		{
			throw new \Exception('Cannot safely create a key');
		}
		catch (Ex\CannotPerformOperationException $ex)
		{
			throw new \Exception('Cannot safely create a key');
		}
	}

}
