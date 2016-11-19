<?php namespace _modules\main\models\form;

class Store extends \Jhul\Components\Database\Store\_Class
{

	public function dataClasses()
	{
		return
		[
			's' => __NAMESPACE__.'\\Data',
		];
	}

	public function name()
	{
		return 'submitted_forms';
	}

	public function itemKeyName(){ return 'ik'; }

	public function add( $form )
	{
		$entity = $this->make
		([
			'name' => $form->name()
		]);

		$entity->commit();

		Data\Content::I()->store()->add
		([
			'ik'		=> $entity->ik(),
			'content'	=> $form->__toString(),
		]);

		return $entity;
	}

	//before aading a new record
	public function beforeAdd( $entity )
	{
		$time  = $this->J()->cx('time')->make( time() );

		$entity->write( 'year', (int) $time->year('Y') );
		$entity->write( 'month', (int) $time->month('m') );
		$entity->write( 'month', (int) $time->day('j') );
		$entity->write( 'submitted_on', (int) $time->value() );

		return;
	}
}
