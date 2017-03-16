<?php namespace Jhul\Core\Application\Page;

abstract class _Class
{

	use \Jhul\Core\_AccessKey;

	public $statusCode = 200;

	public $title = '' ;

	public $indexing = FALSE ;

	public static function I() { return new static(); }

	public abstract function makeWebPage();

	public final function make()
	{

		if( $this->getApp()->user()->request()->mode() == 'json'  )
		{
			$this->makeJSON();
		}

		if( $this->getApp()->user()->request()->mode() == 'webpage'  )
		{
			$this->makeWebPage();

			if( !empty( $this->title ) )
			{
				$this->getApp()->response()->page()->setTitle( $this->title );
			}

			if( TRUE == $this->indexing )
			{
				$this->getApp()->response()->page()->setIndexing( TRUE );
			}
		}

		$this->getApp()->response()->setStatusCode( $this->statusCode );
	}

	public function cookText( $text )
	{
		$this->getApp()->response()->page()->addContent($text);
	}

	public function cook( $name, $params = [] ) { $this->getApp()->response()->page()->cook( $name, $params ); }
}
