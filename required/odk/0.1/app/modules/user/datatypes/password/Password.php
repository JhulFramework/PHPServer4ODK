<?php namespace _modules\user\datatypes\password;

class Password extends \Jhul\Core\Application\DataType\Types\String\Attribute
{
	use \Jhul\Core\_AccessKey;

	public function __construct()
	{
		parent::__construct();
		$this->config()->add( 'if_use_raw_password', FALSE );
	}

      public function hash( $raw )
      {
      	return $this->module()->security()->hashSA($raw);
      }

      public function verifyHash( $raw, $hash )
      {
		return $this->module()->security()->hashSAMatch( $raw, $hash );
      }

	public function ifUseRawPassword()
	{
		return TRUE == $this->config('if_use_raw_password');
	}
 }
