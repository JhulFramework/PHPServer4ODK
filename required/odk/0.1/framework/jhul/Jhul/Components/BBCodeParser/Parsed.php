<?php namespace Jhul\Components\BBCodeParser;

class Parsed
{
	public $style = [];

	public $script = [];

	public function __construct( $content, $CSS, $JS )
	{
		$this->_content = $content;

		$this->style = $CSS;

		$this->script = $JS;
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
