<?php namespace Jhul\Components\BBCodeParser\Definitions;

class URL extends \JBBCode\CodeDefinition
{

	protected $_container;

	public function __construct( $container )
	{
		$this->_container = $container;

		parent::__construct();
		$this->setParseContent(true);
		$this->setUseOption(true);
		$this->setTagName('url');
	}

	public function asHtml( \JBBCode\ElementNode $el)
	{
		$flag_URLValid = false;
		$content = '';
		foreach($el->getChildren() as $child)
		{
            	$content = $child->getAsBBCode();
		}

		return  $this->_container->URLValidator()->validate( $el->getAttribute()['url'] ) ?  '<a href="'.$el->getAttribute()['url'].'" >'.$content.'</a>' : $el->getAsBBCode() ;
	}


}
