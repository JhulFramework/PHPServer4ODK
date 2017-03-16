<?php namespace _modules\user\models\user;

class Manager
{
	use \Jhul\Core\_AccessKey;

	public function findByIName( $iname )
	{
		if( $this->getApp()->mDataType('iname')->make($iname)->isValid() )
		{
			return M::D()->where( 'iname', $iname )->fetch();
		}
	}

	public function getAsVisitor( $user_key )
	{
		return M::D()->byKey( $user_key )->fetch();
	}

}
