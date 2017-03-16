<?php namespace Jhul\Components\HTML\Tab ;

/* @Author Manish Dhruw [1D3N717Y12@gmail.com]
+=======================================================================================================================
| Sat 10 Oct 2015 07:35:32 PM IST
+---------------------------------------------------------------------------------------------------------------------*/

class Tab
{


	protected static $_mStyle ;

	protected $_content = [];

	protected $_text;

	//parameter Manager
	protected $_mParam;

	public function __construct( $size = 1, $unit = 'px' )
	{
		$this->_size = $size;
		$this->_unit = $unit;

	}

	public function size(){ return $this->_size; }

	public function unit(){ return $this->_unit; }

	public function containerClass()
	{
		return 'm'.$this->size().$this->width();
	}

	public function unit()
	{
		return $this->mParam()->unit();
	}

	public function mStyle()
	{
		if( empty( static::$_mStyle ) )
		{
			static::$_mStyle = new MStyle;
		}

		return static::$_mStyle;
	}

	public function T( $text )
	{
		$this->_content = $text ;
	}

	public function done()
	{

	}

	protected function _done()
	{

	}

	public function __toString()
	{
		return $this->done();
	}
}
