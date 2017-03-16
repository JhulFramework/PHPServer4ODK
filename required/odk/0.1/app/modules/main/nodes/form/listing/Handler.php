<?php namespace _modules\main\nodes\form\listing;

class Handler extends \Jhul\Core\Application\Handler\_Class
{
	public function handle()
	{
		$this->getApp()->response()
		->addHeader('Content-Type', 'text/xml; charset=utf-8')
		->addHeader('X-OpenRosa-Accept-Content-Length',	'10000000')
		->addHeader('X-OpenRosa-Version', '1.0');

		$xforms = \_modules\user\models\xform\M::D()->fetchAll();

		$this->getApp()->response()->page()->setUseLayout(FALSE)->cook( 'form_list', ['xforms' => $xforms] );
	}
}
