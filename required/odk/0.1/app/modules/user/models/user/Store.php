<?php namespace _modules\user\models\user;

class Store extends \Jhul\Components\Database\Store\_Class
{

	public function dataClasses()
	{
		return [ 's' => __NAMESPACE__.'\\M', ];
	}

	public function itemKeyName() { return 'ik' ; }


	public function name() { return 'users'; }

	public function byIName( $iname )
	{
		return $this->where( 'iname', $iname );
	}
}
