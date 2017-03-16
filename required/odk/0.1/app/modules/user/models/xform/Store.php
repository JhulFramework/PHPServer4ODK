<?php namespace _modules\user\models\xform;

class Store extends \Jhul\Components\Database\Store\_Class
{
	public function items()
	{
		return
		[
			'write' =>
			[
				'class' => __NAMESPACE__.'\\M',
				'select' => '*',
			],
		];
	}


	public function deleteForm( $item )
	{
		$file = $this->getApp()->publicRoot().'/'.$item->rurl();

		if( is_file($file) )
		{
			@unlink( $file );
		}

		$item->delete();
	}
}
