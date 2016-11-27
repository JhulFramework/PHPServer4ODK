<?php namespace _modules\user\models\user;

class Manager
{
	use \Jhul\Core\_AccessKey;

	public function findByIName( $iname )
	{
		if( $this->getApp()->mDataType('iname')->make($iname)->isValid() )
		{
			return M::I()->store()->byIName( $iname )->fetch();
		}
	}

	public function find( $ik )
	{
		return M::I()->store()->byIk( $ik )->fetch();
	}
}
