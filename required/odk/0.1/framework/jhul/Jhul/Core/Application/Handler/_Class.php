<?php namespace Jhul\Core\Application\Handler;

abstract class _Class
{

	use \Jhul\Core\_AccessKey;

	//override it to implement conditional handling
	public function canHandleNextNode() { return FALSE; }

	protected function breadcrumb(){ return []; }

	public function canHandle(){ return TRUE; }

	public function handle()
	{
		throw new \Exception( 'Please define method "handle()" in class "'.get_called_class().'"' , 1);
	}

	public function mPath()
	{
		return $this->getApp()->user()->request()->route()->nav();
	}

	public function route()
	{
		return $this->getApp()->user()->request()->route();
	}

	public function nextHandler(){}

	//@Structure: [ 'nextNodeNameType' => 'handler' ]
	// types [ string, alnum . . . ]
	public function nextNodeNameTypes(){ return []; }

	//@Structure: [ 'next_path_match' => 'handler' ]
	public function nextNodeNames(){ return []; }

	public function renderPage( $page = NULL  )
	{
		return NULL != $page ? $this->getApp()->renderPage( $page ) : $this->renderLocalPage() ;
	}

	public function renderLocalPage( $page = 'Page' )
	{
		return $this->renderPage( $this->J()->fx()->getFromNamespace( $page , get_called_class() ) ) ;
	}

	public function switchTo(){}

}
