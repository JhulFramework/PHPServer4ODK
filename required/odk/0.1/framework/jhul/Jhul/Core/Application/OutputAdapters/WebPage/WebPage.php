<?php namespace Jhul\Core\Application\OutputAdapters\WebPage;

/* @Author : Manish Dhruw < 1D3N717Y12@gmail.com >
+=======================================================================================================================
|
| @Updated-
| -Saturday 18 April 2015 05:22:09 PM IST
| -Mon 16 Nov 2015 08:46:36 PM IST, [2016-Oct-17, 2016-Nov-05 ]
+---------------------------------------------------------------------------------------------------------------------*/

class WebPage
{
	use \Jhul\Core\Design\Trunk\_Trait;
	use \Jhul\Core\_AccessKey;

	const VERSION = '1';

	private static $_mBreadCrumb;

	protected $_useLayout = TRUE;

	public function setUseLayout( $bool )
	{
		$this->_useLayout = $bool;

		return $this;
	}

	public function mBreadCrumb()
	{
		if( NULL == self::$_mBreadCrumb )
		{
			self::$_mBreadCrumb = MBreadCrumb::I();
		}

		return self::$_mBreadCrumb;
	}

	protected function elementMap()
	{
		return
		[

			'style'	=>  __NAMESPACE__.'\\Style',

			'J'	=> __NAMESPACE__.'\\JS',

			'content'	=> __NAMESPACE__.'\\Content',

			'M'	=> __NAMESPACE__.'\\MetaTag',

			'V'	=> __NAMESPACE__.'\\TemplateManager',

			'image'	=> __NAMESPACE__.'\\Image',

		];
	}

	/* Elements Access
	+===============================================================================================================*/


	//Image Manager
	public function mImage()
	{
		return $this->e('image');
	}


	public function mJS()
	{
		return $this->e('J');
	}

	//Style(CSS) Manager
	public function mStyle()
	{
		return $this->e('style');
	}

	public function type()
	{
		return 'webpage';
	}

	//Template Manager
	public function mTemplate()
	{
		return $this->e('V');
	}

	public function content()
	{
		return $this->e('content');
	}

	public function metaTag()
	{
		return $this->e('M');
	}

	/* Elements Access
	+---------------------------------------------------------------------------------------------------------------*/


	/* Page indexing
	+===============================================================================================================*/

	//by default page will not be indexed
	private $_enableIndexing = FALSE;

	//enable/disable page indexing for search engine robots
	public function setIndexing( $bool )
	{
		$this->_enableIndexing = $bool;
	}

	/*--------------------------------------------------------------------------------------------------------------*/


	/* Page Title
	================================================================================================================*/
	public function setTitle( $title )
	{
		$this->content()->s( 'title', $title) ;
	}


	public function makeTitle()
	{
		if( NULL != $this->content()->g('title') )
		{
			return '<title>'.$this->content()->g('title').'</title>';
		}

		if( $this->getApp()->name() != '' )
		{
			return '<title>'. ucfirst( $this->getApp()->name() ) .'</title>';
		}
	}

	/* Page Title
     -----------------------------------------------------------------------------------------------------------------*/

	public function isEmpty()
	{
		return !$this->content()->has('content');
	}

	//Returns page Header contents
	protected function makeHead()
	{
		if( FALSE == $this->_enableIndexing )
		{
			$this->metaTag()->add('robots', 'noindex');
		}

		return $this->content()->g('head').$this->metaTag().$this->mStyle().$this->makeTitle() ;
	}

	public function addContent( $content )
	{
		$this->content()->a('content', $content);
	}

	public function cook( $view, $params = [] )
	{
		$this->addContent( $this->mTemplate()->load( $view, $params ) ) ;
	}

	public function loadAs( $ik, $view, $params = [] )
	{
		$this->data()->a( $ik, $this->mTemplate()->load( $view, $params ) );
	}


	public function make()
	{
		if( !$this->_useLayout ) return  $this->content()->g('content') ;

		$params =
		[
			'body'		=> $this->mTemplate()->load( 'body', [ 'content' => $this->content()->g('content') ]  ) ,

			'head' 		=> $this->makeHead(),

			'js'			=> $this->mJS(),
		];

		return $this->e('V')->load( 'layout', $params );
	}

	public function sendResponse()
	{

		if( $this->isEmpty() )
		{
			$this->addContent( $this->mTemplate()->load('error404') );

			if( !$this->J()->cx('http')->R()->ifStatusCodeSet() ) $this->J()->cx('http')->R()->setStatusCode(404);
		}

		$this->J()->cx('http')->R()->setContent( $this->make() );

		$this->J()->cx('http')->R()->send();

		return $this->J()->cx('http')->R()->getStatusCode() ;
	}


	public function __toString()
	{
		return $this->make();
	}
}
