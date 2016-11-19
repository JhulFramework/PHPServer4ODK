<?php namespace Jhul\Core\Application\Node;

/* @Author : Manish Dhruw [1D3N717Y12@gmail.com]
+=======================================================================================================================
| @Created : Sun 08 Nov 2015 07:10:09 PM IST
+---------------------------------------------------------------------------------------------------------------------*/

abstract class _Class extends _Abstract
{
	const VERSION = '1.0';

	//@TYPE OBJECT
	private static $_pointer;

	private static $_loaded = [] ;

	protected $ifAutoHandleNextNode = FALSE;
	protected $autoNextNodeClass ;

	public function pointer()
	{
		if( NULL == self::$_pointer )
		{
			self::$_pointer = new Pointer;
		}

		return self::$_pointer;
	}

	public function moveTo( $name )
	{
		if( FALSE !== strpos( $name, '\\' ) )
		{
			return $name::I()->handle();
		}

		return $this->$name();
	}

	protected function moveToNext()
	{
		if( $this->isVirtual() ) return ;

		$this->pointer()->increment();
	}

	public function isVirtual(){ return FALSE; }

	//name of next path
	public function next()
	{

		if( !isset( self::$_loaded[ $this->pointer()->next() ] ) )
		{
			self::$_loaded[ $this->pointer()->next() ] = $this->loadNext();
		}

		return self::$_loaded[ $this->pointer()->next() ];
	}

	//Next Requested Node
	//Unsafe to use
	protected function NRN()
	{
		return $this->path()->get( $this->pointer()->next() );
	}

	private function loadNext()
	{



		if( NULL != $this->NRN()  )
		{

			if( isset( $this->autoNextNodeNames()[ $this->NRN() ] ) )
			{

				$this->autoNextNodeClass =  $this->autoNextNodeNames()[ $this->NRN() ] ;
				return;
			}

			//Checking against explicit declaration of Next Node Name
			if( NULL != $this->nextNodeName() && ( $this->path()->get( $this->pointer()->next()  )  == $this->nextNodeName() ) )
			{
				return $this->nextNodeName();
			}

			foreach ($this->nextNodeNames() as $node)
			{
				if(  $this->path()->get( $this->pointer()->next() ) ==  $node )
				{
					return $node ;
				}
			}

			//verifying next node by provide type
			if( NULL != ( $type = $this->nextNodeNameType() )  )
			{
				$nextPath = $this->getApp()->mDataType( $type )->make( $this->path()->get( $this->pointer()->next()  ) )->value();

				return !empty( $nextPath ) ? $nextPath : NULL ;
			}
		}
	}


	//name of current path
	public function current()
	{
		return $this->path()->get( $this->pointer()->value() );
	}

	//check if this is last path
	public function isEnd()
	{
		return $this->current() == $this->path()->last();
	}

	//next node name type, eg string, alnum, alpha, posdecnum
	protected function nextNodeNameType(){}

	//Explicite Declaration of node name
	protected function nextNodeName(){}

	protected function nextNodeNames(){ return []; }

	protected function autoNextNodeNames(){ return []; }

	protected function conditionalNodes(){ return []; }

	public function path()
	{
		return $this->getApp()->route()->path();
	}

}
