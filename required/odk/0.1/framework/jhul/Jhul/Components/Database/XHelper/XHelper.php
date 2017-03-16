<?php namespace Jhul\Components\Database\XHelper;

class XHelper extends \Jhul\Components\XHelper\_Design
{
	use \Jhul\Core\_AccessKey;

	public function handlerMap()
	{
		return
		[
			'ERROR_COLUMN_NOT_SELECTED' => 'columnNotSelected',
		];
	}


	public function columnNotSelected( $params, \Jhul\Components\Database\Design\Data\_Class $entity  )
	{
		$class = get_class( $entity );
		return 'Column "'.$params['column'].'" is NOT SELECTED. <br/> Executed SQL was '.$entity->executedQuery()
		.'<br/> Check method "'.$class.'::queryParams()" IN '.
		$this->showClass( $class );
	}
}
