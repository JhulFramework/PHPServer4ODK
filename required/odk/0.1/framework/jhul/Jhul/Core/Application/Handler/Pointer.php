<?php namespace Jhul\Core\Application\Handler;


class Pointer
{
	private $_value = 0 ;

	public function __toString()
	{
		return $this->value();
	}

	public function value()
	{
		return $this->_value;
	}

	public function increment()
	{
		++$this->_value;
	}

	public function next( $value = 1 )
	{
		return $this->value() + $value;
	}

}
