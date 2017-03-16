<?php namespace _modules\main\nodes\form\download;

class Handler extends \Jhul\Core\Application\Handler\_Class
{
	public function canHandleNextNode() { return TRUE ; }

	public function handle()
	{
		if(  !$this->mPath()->hasNext() || !ctype_digit( $this->mPath()->next() )  ) return;
		$xform = \_modules\user\models\xform\M::D()->byKey( $this->mPath()->next() )->fetch();
		$this->getApp()->response()->page()->setUseLayout(FALSE);
		$this->getApp()->response()->addHeader('Content-Type', 'text/xml');
		$this->getApp()->response()->addHeader('Content-Disposition','attachment; filename="'.$xform->name().'.xml"');
		$this->getApp()->response()->page()->addContent( $xform->getContent() );
	}
}
