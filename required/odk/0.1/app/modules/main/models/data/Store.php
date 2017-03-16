<?php namespace _modules\main\models\data;

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



	public function add( $form )
	{
		$entity = $this->createAndCommit ( 'write', [ 'name' => $form->name() ] );

		content\M::I()->store()->add
		( 'write', [
			'data_key'		=> $entity->key(),
			'content'	=> $form->__toString(),
		]);

		return $entity;
	}

	public function inflateCreated( $value )
	{
		return strtoupper(date( 'Y-M-d : H-i-s', $value ));
	}

	public function valueinflaters()
	{
		return
		[
			'created' => 'inflateCreated',
		];
	}

	protected function beforeInsert( $item )
	{
		$time  = $this->J()->cx('time')->make( time() );

		$item->write( 'year', (int) $time->year('Y') );
		$item->write( 'month', (int) $time->month('m') );
		$item->write( 'day', (int) $time->day('j') );
		$item->write( 'created', (int) $time->value() );

		return $item ;
	}
}
