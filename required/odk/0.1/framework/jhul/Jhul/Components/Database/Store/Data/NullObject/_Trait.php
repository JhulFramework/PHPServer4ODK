<?php namespace Jhul\Components\Database\Design\Entity\NullObject;

/* NULL OBJECT ENTITY
+=======================================================================================================================
| @Author : Manish DHruw [1D3N717Y12@gmail.com]
| @Created : 2016-August-13

+---------------------------------------------------------------------------------------------------------------------*/


trait _Trait
{

	protected $_statement;

	protected $_store;

	public function __construct( $store )
	{
		$this->_store = $store ;
	}

	public function store()
	{
		return $this->_store;
	}


	public function isNULL() { return TRUE; }

	public function nullObjectClass(){ return __NAMESPACE__ ; }

	public function setStatement( $statement )
	{
		$this->_statement = $statement;
		return $this;
	}

	public function statement( $statement )
	{
		$this->_statement ;
	}

	public function write( $field, $value ) { $this->inverse()->write( $field, $value ); }

	public function inverse()
	{
		throw new \Exception( 'Please use custom NullObject' , 1);
	}
}
