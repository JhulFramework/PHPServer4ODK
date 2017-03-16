<?php namespace Jhul\Components\HTML\Tab ;

class MParam
{
	protected $_size;

	protected $_unit;

	public function __construct( $size = 1, $unit = 1 )
	{
		$this->_size = $size;
		$this->_unit = $unit;
	}

	public function size(){ return $this->_size; }

	public function unit(){ return $this->_unit; }

	public function class()
	{
		return 'm'.$this->size().$this->width();
	}
}
