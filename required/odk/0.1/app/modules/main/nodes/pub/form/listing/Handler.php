<?php namespace _modules\main\nodes\pub\form\listing;

class Handler extends \Jhul\Core\Application\Node\Handler\_Class
{
	public function run()
	{

		$this->J()->cx('http')->R()->headers->set('Content-Type', 'text/xml; charset=utf-8');

		$xforms = \_modules\user\models\xform\M::I()->store()->fetchAll();

		$this->getApp()->outputAdapter()->setUseLayout(FALSE)->cook( 'form_list', ['xforms' => $xforms] );
	}
}
