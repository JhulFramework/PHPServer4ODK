<?php namespace _modules\user\models\xform;

class Store extends \Jhul\Components\Database\Store\_Class
{
	public function dataClasses()
	{
		return [ 's' => __NAMESPACE__.'\\M', ];
	}

	public function itemKeyName(){ return 'ik'; }

	public function name(){ return 'xforms'; }

	public function byName( $name )
	{
		return $this->where( 'name', $name );
	}

	public function deleteForm( $item )
	{
		$file = $this->getApp()->publicRoot().'/'.$item->rurl();
		@unlink( $file );
		$item->delete();
	}
}
