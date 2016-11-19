<?php namespace Jhul\Core\Application\DataType\Types\String;



class Value extends \Jhul\Core\Application\DataType\_Value\_Class
{
	public function value()
	{
		return $this->isValid() ?  $this->inputValue() : '' ;
	}

	public function __toString()
	{
		return $this->value();
	}


}
