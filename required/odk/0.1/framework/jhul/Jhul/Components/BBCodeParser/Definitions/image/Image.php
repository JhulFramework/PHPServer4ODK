<?php namespace Jhul\Components\BBCodeParser\Definitions\URL;

class URL extends \JBBCode\CodeDefinition
{

	protected $_allowed_url_map;

	public function __construct()
	{
		parent::__construct();
		$this->setTagName('url');

		$this->_allowed_url_map = require( __DIR__.'/_allowed_url_map.php' );
	}

	public function asHtml( \JBBCode\ElementNode $el)
	{
		$flag_URLValid = false;
		$content = "";
		foreach($el->getChildren() as $child)
		{
            	$content .= $child->getAsBBCode();
		}

		if( isset( $el->getAttribute()['url'] ) )
		{
			$info = parse_url( $el->getAttribute()['url'] );

			if( isset($info['scheme']) && isset( $info['host'] ) )
			{
				$base = $info['scheme'].'://'.$info['host'].'/';

				$flag_URLValid = in_array( $base, $this->_allowed_url_map );
			}
		}

		return NULL == $flag_URLValid ? '' : '<a href="'.$el->getAttribute()['url'].'" >'.$content.'</a>' ;
	}

}
