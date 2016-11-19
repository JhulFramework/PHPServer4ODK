<?php namespace _modules\user\datatypes\types;

class Password extends \Jhul\Core\Application\DataType\Types\String\Attribute
{
	use \Jhul\Core\_AccessKey;

      public function createHash( $raw )
      {
      	return $this->module()->security()->hashSA($raw);
      }

      public function verifyHash( $raw, $hash )
      {
            return $this->module()->security()->hashSAMatch( $raw, $hash );
      }
}
