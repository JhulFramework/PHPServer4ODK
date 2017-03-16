<?php namespace Jhul\Core\Application\Page;

/* @Author Manish Dhruw < 1D3N717Y12@gmail.com >
+=======================================================================================================================
| @Created : 2016-October-16
+---------------------------------------------------------------------------------------------------------------------*/

class Manager
{
	use \Jhul\Core\_AccessKey;

	protected $_pages = [];

	public function register( $name, $namespace = '' )
	{
		if( is_array($name) )
		{
			// module name prefix
			if(!empty($namespace)) $namespace .= '.';

			foreach ( $name as $n => $p)
			{
				$this->register( $namespace.$n, $p );
			}

			return;
		}

		$this->_pages[ $name ] = $namespace;
	}

	public function pages() { return $this->_pages; }

	public function resolvePath( $name )
	{
		if( isset( $this->_pages[$name] ) )
		{
			$name = $this->_pages[$name];
		}

		if( strrpos( $name, '\\' ) ) return $name;



		$a = explode( '.', $name );


		if( isset($a[0]) && isset($a[1]) )
		{
			//since page belong to module we need make sure module is loaded
			$this->getApp()->m( $a[0] );

			if( isset( $this->pages()[ $name ]) )
			{
				return $this->pages()[ $name ];
			}

			throw new \Exception( 'Module "'.$a[0].'" does not contains any page named "'.$a[1].'" ' , 1);
		}

		throw new \Exception( 'Page "'.$name.'" not Mapped ' , 1);
	}

	//accespts name of registered page or class
	public function render( $page )
	{
		$page = $this->resolvePath( $page );

		if( !class_exists( $page ) )
		{
			throw new \Exception( 'page Class "'.$page.'" Not Found' , 1);
		}

		$page::I()->make();

	//	$page->make();

		// $this->getApp()->response()->setStatusCode( $page->statusCode );
		//
		// if( $this->getApp()->response()->page()->type() == 'webpage' )
		// {
		// 	if( !empty( $page->title ) )
		// 	{
		// 		$this->getApp()->response()->page()->setTitle( $page->title );
		// 	}
		//
		// 	if( TRUE == $page->indexing )
		// 	{
		// 		$this->getApp()->response()->page()->setIndexing( TRUE );
		// 	}
		// }

	}
}
