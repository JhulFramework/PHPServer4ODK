<?php namespace Jhul\Components\BBCodeParser;

class BBCodeParser
{
	protected static $_allowed_url_map = [];

	protected $_registeredCSS = [];

	protected $_registeredJS = [];

	public function registerCSS( $css )
	{
		$this->_registeredCSS[] = $css;
	}

	public function registerJS( $JS )
	{
		$this->_registeredJS[] = $JS;
	}


	public function isSingleton()
	{
		return TRUE;
	}

      public function __construct()
      {
            $this->_parser = new \JBBCode\Parser();
		$this->_parser->addCodeDefinitionSet( new DefaultDefinitionSet() );
		$this->loadCustomDefinitions();
      }

      private $_parser;

	public function parser()
	{
		return $this->_parser;
	}

      public function parse( $text )
      {
		$this->_registeredJS = [];
		$this->_registeredCSS = [];
            $this->_parser->parse($text);
            return new Parsed ( $this->_parser->getAsHtml(), $this->_registeredCSS, $this->_registeredJS ) ;
      }


	public function purify( $html )
	{
		$config = \HTMLPurifier_Config::createDefault();

		// configuration goes here:
		$config->set('Core.Encoding', 'UTF-8'); // replace with your encoding
		$config->set('HTML.Doctype', 'XHTML 1.0 Transitional'); // replace with your doctype

		$purifier = new \HTMLPurifier($config);

		return $purifier->purify( $html );
	}

	protected function addDefinition( $builder )
	{
		$this->_parser->addCodeDefinition($builder);
	}

	public function loadSmileys()
	{
		$builder = new Smiley;
	}

	public function loadCustomDefinitions()
	{
		$this->addDefinition( new Definitions\URL($this) );
		$this->addDefinition( new Definitions\Color($this) );

		$this->addDefinition( new Definitions\Code($this) );


		/* [img] image tag */
		$builder = new \JBBCode\CodeDefinitionBuilder('img', '<img src="{param}" />');
		$builder->setUseOption(false)->setParseContent(false)->setBodyValidator($this->urlValidator());
		$this->addDefinition( $builder->build() );

		/* [img=alt text] image tag */
		$builder = new \JBBCode\CodeDefinitionBuilder('img', '<img src="{param}" alt="{option}" />');
		$builder->setUseOption(true)->setParseContent(false)->setBodyValidator($this->urlValidator());
		$this->addDefinition( $builder->build() );

	}



	protected $_URLValidator;

	public function URLValidator()
	{
		if( NULL == $this->_URLValidator )
		{
			$this->_URLValidator = new Validator\URL( $this->allowedURLMap() ) ;
		}

		return $this->_URLValidator;
	}

	public function allowedURLMap()
	{
		return require __DIR__.'/_allowed_url_map.php';
	}

	public function colorNameMap()
	{
		return require __DIR__.'/_color_name_map.php';
	}
}
