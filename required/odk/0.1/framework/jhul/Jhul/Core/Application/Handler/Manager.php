<?php namespace Jhul\Core\Application\Handler;

/* @Author Manish Dhruw < 1D3N717Y12@gmail.com >
+=======================================================================================================================
| @Created : 2016-October-16
+---------------------------------------------------------------------------------------------------------------------*/

class Manager
{
	use \Jhul\Core\_AccessKey;

	protected $_trace = [];

	protected $_handlers = [];

	protected $_pointer ;

	public function pointer()
	{
		if( empty($this->_pointer) )
		{
			$this->_pointer = new Pointer();
		}

		return $this->_pointer;
	}

	public function register(  $name, $class = NULL )
	{



		if( is_array($name) )
		{
			//module name prefix
			if(!empty($class)) $class .=  $this->J()->cx('router')->nodeIdentifier() ;

			foreach ( $name as $n => $c)
			{
				$this->register( $class.$n, $c );
			}

			return;
		}

		if( empty($class) ) throw new \Exception( 'Handler "'.$name.'" class must not be empty ', 1);

		if( isset( $this->_handlers[$name] )  && $this->_handlers[$name] != $class )
		{
			throw new \Exception( 'Clash for HANDLER name "'.$name.'" betwen alreday registered class "'.$this->_handlers[$name].'" and new class "'.$class.'" ', 1);
		}

		$this->_handlers[ $name ] = $class;
	}

	public function map()
	{
		return $this->_handlers;
	}

	public function resolveClass( $name )
	{
		if( isset( $this->_handlers[$name] ) )
		{
			$name = $this->_handlers[$name];
		}

		if( strrpos( $name, '\\' ) ) return $name;

		$h = explode( $this->J()->cx('router')->nodeIdentifier() , $name );

		if( isset($h[0]) && isset($h[1]) )
		{
			$this->getApp()->m( $h[0] );

			if( isset( $this->map()[ $name]) )
			{
				return $this->map()[ $name ];
			}

			throw new \Exception( 'Module "'.$h[0].'" does not contains any handler named "'.$h[1].'" ' , 1);
		}

		throw new \Exception( 'Handler "'.$name.'". not found! ', 1 );
	}


	//@param : $path ( url path )
	//@param : $handler ( $handler )
	public function run( $handler )
	{
		$handler = $this->resolveClass( $handler );

		$this->_trace[ $this->mPath()->current() ] = $handler;

		$handler = $this->findEndHandler( new $handler );

		if( !$this->mPath()->hasNext() || $handler->canHandleNextNode() )
		{
			return $handler->canHandle() ? $handler->handle() : NULL ;
		}
	}



	public function findEndHandler( $handler )
	{
		$next = $this->findNext( $handler );

		if( !empty( $next ) )
		{
			$next = $this->resolveClass( $next );
			$this->mPath()->moveToNext();
			$this->_trace[ $this->mPath()->current() ] = $next;
			return $this->findEndHandler( new $next );
		}

		$switchToHandler = $handler->switchTo();

		if( !empty( $switchToHandler ) )
		{
			$switchToHandler = $this->resolveClass( $switchToHandler );
			$this->_trace[ count($this->_trace).'-switched' ] = $switchToHandler;
			return $this->findEndHandler( new $switchToHandler) ;
		}

		return $handler;
	}

	public function findNext( $handler )
	{

		if( !$this->mPath()->hasNext() ) return ;

		foreach ( $handler->nextNodeNames() as $path => $next )
		{
			if(  $this->mPath()->next() == $path )
			{
				return $next;
			}
		}

		foreach( $handler->nextNodeNameTypes()  as $t => $h )
		{
			if( $this->getApp()->mDataType( $t )->make( $this->mPath()->next() )->isValid())
			{
				return $h;
			}
		}

		return $handler->nextHandler();
	}

	public function mPath()
	{
		return $this->getApp()->user()->request()->route()->nav() ;
	}

	public function running() { return empty( $this->_running ); }

	public function showTrace()
	{
		$html = '';

		foreach ($this->_trace as $key => $value)
		{
			$html .= '<br/>'.$key.' => '.$value;
		}

		return $html;
	}

}
