<?php namespace _modules\main\nodes\pub\xform;

class Handler extends \Jhul\Core\Application\Node\Handler\_Class
{
	public function nextNodeNameType()
	{
		return 'pdn';
	}

	public function run()
	{
		if( NULL != $this->next() )
		{

			$xform = \_modules\user\models\xform\M::I()->store()->byIk( $this->next() )->fetch();

			$this->getApp()->outputAdapter()->setUseLayout(FALSE);

			$this->J()->cx('http')->R()->headers->set('Content-Type', 'text/xml');
			$this->J()->cx('http')->R()->headers->set('Content-Disposition','attachment; filename="'.$xform->name().'.xml"');
			$this->getApp()->outputAdapter()->addContent( $xform->getContent() );
		}
	}
}
