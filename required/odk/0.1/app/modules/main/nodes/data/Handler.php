<?php namespace _modules\main\nodes\data;

class Handler extends \Jhul\Core\Application\Handler\_Class
{
	public function canHandleNextNode()
	{
		return TRUE;
	}

	public function handle()
	{
		$this->getApp()->showFlash();

		if( !$this->mPath()->hasNext() )
		{
			$this->J()->cx('uiloader')->mbreadcrumb()->add( 'SUBMITTED DATA', $this->getApp()->url()  );

			$data = \_modules\main\models\data\M::D()->limit(10)->fetchAll();

			return $this->getApp()->response()->page()->cook( 'data_list', [ 'data' => $data ] );
		}

		if( $this->mPath()->hasNext() )
		{

			$this->getApp()->m('user'); //loading xml datatype from user module

			$data = \_modules\main\models\data\M::D()->byKey( $this->mPath()->next() )->fetch();

			if( empty($data) ) return ;

			if( isset( $_GET['download'] ) )
			{
				if( 'xml' == $_GET['download'] )
				{
					$this->r()->page()->setUseLayout(FALSE);
					$this->R()->addHeader('Content-Type', 'text/xml');
					$this->R()->addHeader('Content-Disposition','attachment; filename="'.$data->name().'.xml"');
					$this->r()->page()->addContent( $data->content()->asXML() );

					return ;
				}

				if( 'json' == $_GET['download'] )
				{
					$this->R()->page()->setUseLayout(FALSE);
					$this->R()->addHeader('Content-Type', 'text/json');
					$this->R()->addHeader('Content-Disposition','attachment; filename="'.$data->name().'.json"');
					$this->R()->page()->addContent( $data->content()->asJSON() );
					return;
				}
			}


			$this->r()->page()->mStyle()->embed( $this->getApp()->mDataType('xml')->style() );

			return $this->r()->page()->addContent( $this->getApp()->mDataType('xml')->formatArray( $data->content()->asArray() ) );
		}
	}

	public function r()
	{
		return $this->getApp()->response();
	}
}
