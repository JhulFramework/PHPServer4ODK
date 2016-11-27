<?php namespace _modules\main\models\data\content;

class Store extends \Jhul\Components\Database\Store\_Class
{

	public function dataClasses()
	{
		return
		[
			's' => __NAMESPACE__.'\\M',
		];
	}

	public function name()
	{
		return 'submitted_data_content';
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
