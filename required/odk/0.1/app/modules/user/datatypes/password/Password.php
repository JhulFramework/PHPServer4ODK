<?php namespace _modules\user\datatypes\password;

class Password extends \Jhul\Core\Application\DataType\Types\String\Attribute
{
	use \Jhul\Core\_AccessKey;

      public function createHash( $raw )
      {
		return $raw;
      }

      public function verifyHash( $raw, $hash )
      {
		return 0 === strcmp ( $raw , $hash );
      }
}
