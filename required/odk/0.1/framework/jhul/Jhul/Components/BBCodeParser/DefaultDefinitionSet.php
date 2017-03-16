<?php namespace Jhul\Components\BBCodeParser;

/**
 * Provides a default set of common bbcode definitions.
 *
 * @author jbowens
 */
class DefaultDefinitionSet implements \JBBCode\CodeDefinitionSet
{

    /** @var CodeDefinition[] The default code definitions in this set. */
    protected $definitions = array();

	protected $_defaults =
	[
		'b' => '<strong>{param}</strong>',
		'i' => '<em>{param}</em>',
		'u' => '<u>{param}</u>'

	];

    /**
     * Constructs the default code definitions.
     */
	public function __construct()
	{
		foreach ( $this->_defaults as $tag => $replace)
		{
			$this->definitions[] = $this->builder( $tag, $replace  )->setParseContent(TRUE)->build();
	    	}
    	}

	public function builder( $tag, $replace )
	{
		return new \JBBCode\CodeDefinitionBuilder( $tag, $replace );
	}

    /**
     * Returns an array of the default code definitions.
     *
     * @return CodeDefinition[]
     */
    public function getCodeDefinitions()
    {
        return $this->definitions;
    }

}
