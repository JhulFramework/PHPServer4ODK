<?php namespace _modules\main\models\form\Data;

class Store extends \Jhul\Components\Database\Store\_Class
{

	public function dataClasses()
	{
		return
		[
			's' => __NAMESPACE__.'\\Content',
		];
	}

	public function name()
	{
		return 'submitted_forms_data';
	}

	public function itemKeyName(){ return 'ik'; }

	public function add( $data )
	{
		$entity = $this->make
		([
			'ik'	=> $data['ik'],
			'content' => $data['content'],
		]);

		$entity->commit();

		return $entity;
	}

}
