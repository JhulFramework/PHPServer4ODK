<?php namespace Jhul\Components\BBCodeParser\Definitions;

class Color extends \JBBCode\CodeDefinition
{

	protected $_color_name_map = [];

	protected $_tagname = 'color';



	public function __construct( $container )
	{
		$this->_color_name_map = $container->colorNameMap();

		parent::__construct();
		$this->setParseContent(true);
		$this->setUseOption(true);
		$this->setTagName( $this->_tagname );
	}

	public function asHtml( \JBBCode\ElementNode $el)
	{
		$content = '';

		foreach($el->getChildren() as $child)
		{
            	$content .= $child->getAsBBCode();
		}

		if( isset( $el->getAttribute()[ $this->_tagname ] ) )
		{
			$color =  $el->getAttribute()[ $this->_tagname ];

			if( isset( $this->_color_name_map[ $color ] ) )
			{
				$color = $this->_color_name_map[ $color ];
			}

			if( ctype_xdigit( $color ) && strlen( $color ) == 6 )
			{
				return '<font color="#'.$color.'" >'.$content.'</font>' ;
			}
		}


		return $el->getAsBBCode() ;
	}


}
