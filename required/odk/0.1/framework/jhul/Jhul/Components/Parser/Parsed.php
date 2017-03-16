<?php namespace Jhul\Components\Parser;

class Parsed
{
	public $CSS = [];

	public $JS = [];

	public function __construct( $content, $CSS, $JS )
	{
		
		$this->_content = $content;

		$this->CSS = $CSS;

		$this->JS = $JS;
	}


	public function value()
	{
		return $this->_content;
	}

	public function __toString()
	{
		return $this->value();
	}
}
