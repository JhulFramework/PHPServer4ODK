<?php namespace _modules\main\nodes\pub\view_data;

class Handler extends \Jhul\Core\Application\Node\Handler\_Class
{
	public function nextNodeNameType()
	{
		return 'pdn';
	}

	public function run()
	{

		if( $this->isEnd() )
		{
			$data = \_modules\main\models\form\Data::I()->store()->limit(10)->fetchAll();

			return $this->getApp()->outputAdapter()->cook( 'view_data_list', [ 'data' => $data ] );
		}

		if( NULL != $this->next() )
		{

			$this->getApp()->m('user'); //loading xml datatype from user module

			$form = \_modules\main\models\form\Data::I()->store()->byik( $this->next() )->fetch();
		
			$this->getApp()->outputAdapter()->mStyle()->embed( $this->getApp()->mDataType('xml')->style() );

			return $this->getApp()->outputAdapter()->addContent( $this->getApp()->mDataType('xml')->formatArray( $form->content()->asArray() ) );
		}
	}
}
