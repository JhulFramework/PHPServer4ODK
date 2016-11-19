<?php namespace Jhul\Components\BBCodeParser\Definitions;

class Code extends \JBBCode\CodeDefinition
{

	protected $_container;

	public $syntaxHighlighters =
	[
		'html' => 'html_syntax_highlighter',
	];

	public function __construct( $container )
	{
		$this->_container = $container;

		parent::__construct();
		$this->setParseContent(true);
		$this->setUseOption(true);
		$this->setTagName('code');
	}

	public function asHtml( \JBBCode\ElementNode $el)
	{
		$flag_URLValid = false;
		$content = '';
		foreach($el->getChildren() as $child)
		{
            	$content = $child->getAsBBCode();
		}

		if( isset( $el->getAttribute()['code'] ) && isset( $this->syntaxHighlighters[ $el->getAttribute()['code'] ] ) )
		{
			$asset =  $this->syntaxHighlighters[ $el->getAttribute()['code'] ];

			$this->_container->registerCSS(  $asset );
			$this->_container->registerJS(  $asset );
			return $this->build( $content,  $el->getAttribute()['code']   );
		}

		return  $el->getAsBBCode() ;
	}

	public function build( $content, $code )
	{
		return '<pre><code class="language-'.$code.'" >'.$content.'</code></pre>';
	}

}
