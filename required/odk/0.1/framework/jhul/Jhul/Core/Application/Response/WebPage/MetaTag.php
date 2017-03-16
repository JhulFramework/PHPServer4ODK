<?php namespace Jhul\Core\Application\Response\WebPage;

class MetaTag
{

	private $tags = [] ;

	public function add( $name, $content )
	{
		$this->tags[$name] = '<meta name="'.$name.'" content="'.$content.'" /> ';
	}

	public function addHttpEquiv( $httpEquiv, $content )
	{
		$this->tags[$httpEquiv] = '<meta http-equiv="'.$httpEquiv.'" content="'.$content.'" /> ';
	}

	public function toString()
	{
		return implode('', $this->tags) ;
	}

	public function __toString()
	{
		return $this->toString();
	}
}
