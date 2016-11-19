<?php namespace Jhul\Core\Application\DataType\_Value;

abstract class _Class implements _Interface
{
	use \Jhul\Core\Containers\_Error;

	//original value
	protected $_input;

	protected $_dataType;

	public function inputValue()
	{
		return $this->_input;
	}

	public function __construct( $inputValue, $type )
	{
		$this->_input = $inputValue;

		$this->_dataType = $type;
	}

	public function type(){ return $this->dataType()->type() ; }

	public function dataType()
	{
		return $this->_dataType;
	}

	public function isValid()
	{
		return !$this->hasError();
	}

	
}
