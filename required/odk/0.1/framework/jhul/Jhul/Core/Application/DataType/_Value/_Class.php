<?php namespace Jhul\Core\Application\DataType\_Value;

abstract class _Class implements _Interface
{

	protected $_errors = [];

	public function addError( $value )
	{
		if( is_array($value) )
		{
			foreach ( $value as $k => $v )
			{
				$this->addError( $k, $v );
			}

			return;
		}

		$this->_errors[] = $value;
	}

	public function error(){ if( isset($this->_errors[0]) ) return $this->_errors[0]; }

	public function hasError(){ return !empty($this->_errors); }

	public function errors(){ return $this->_errors ; }

	//original value
	protected $_input;

	protected $_dataType;

	public function inputValue()
	{
		return $this->_input;
	}

	public function __construct( $inputValue, &$type )
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
