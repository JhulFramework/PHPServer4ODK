<?php namespace _modules\user\models;

class MUser
{
	use \Jhul\Core\_AccessKey;

	public function findByIName( $iname )
	{
		if( $this->getApp()->mDataType('iname')->make($iname)->isValid() )
		{
			return User::I()->store()->byIName( $iname )->fetch();
		}
	}

	public function find( $ik )
	{
		return User::I()->store()->byIk( $ik )->fetch();
	}
}
