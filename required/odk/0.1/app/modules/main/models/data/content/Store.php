<?php namespace _modules\main\models\data\content;

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


	public function add( $context, $data )
	{
		return $this->createAndCommit( 'write', $data );
	}

}
