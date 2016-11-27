<?php namespace _modules\main\nodes\data;

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
			$this->J()->cx('uiloader')->mbreadcrumb()->add( 'SUBMITTED DATA', $this->getApp()->url()  );

			$data = \_modules\main\models\data\M::I()->store()->limit(10)->fetchAll();

			return $this->getApp()->outputAdapter()->cook( 'data_list', [ 'data' => $data ] );
		}

		if( NULL != $this->next() )
		{

			$this->getApp()->m('user'); //loading xml datatype from user module

			$data = \_modules\main\models\data\M::I()->store()->byik( $this->next() )->fetch();

			if( empty($data) ) return ;

			if( isset( $_GET['download'] ) )
			{
				if( 'xml' == $_GET['download'] )
				{
					$this->getApp()->outputAdapter()->setUseLayout(FALSE);
					$this->J()->cx('http')->R()->headers->set('Content-Type', 'text/xml');
					$this->J()->cx('http')->R()->headers->set('Content-Disposition','attachment; filename="'.$data->name().'.xml"');
					$this->getApp()->outputAdapter()->addContent( $data->content()->asXML() );

					return ;
				}

				if( 'json' == $_GET['download'] )
				{
					$this->getApp()->outputAdapter()->setUseLayout(FALSE);
					$this->J()->cx('http')->R()->headers->set('Content-Type', 'text/json');
					$this->J()->cx('http')->R()->headers->set('Content-Disposition','attachment; filename="'.$data->name().'.json"');
					$this->getApp()->outputAdapter()->addContent( $data->content()->asJSON() );
					return;
				}
			}


			$this->getApp()->outputAdapter()->mStyle()->embed( $this->getApp()->mDataType('xml')->style() );

			return $this->getApp()->outputAdapter()->addContent( $this->getApp()->mDataType('xml')->formatArray( $data->content()->asArray() ) );
		}
	}
}
