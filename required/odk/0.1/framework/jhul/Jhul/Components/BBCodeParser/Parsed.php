<?php namespace Jhul\Components\BBCodeParser;

class Parsed
{
	public $style = [];

	public $script = [];

	public $content;

	public function __construct( $content, $CSS, $JS )
	{
		$this->content = $content;

		$this->style = $CSS;

		$this->script = $JS;
	}


	public function value()
	{
		return $this->content;
	}

	public function __toString()
	{
		return $this->content;
	}
}
