<?php namespace _modules\user\datatypes\xml;

class Value extends \Jhul\Core\Application\DataType\_Value\_Class
{
	protected $_name;

	public function __construct( $value , $dataType )
	{
		parent::__construct( $value, $dataType );


		$this->_asArray = $this->dataType()->xmlToArray( $this->inputValue() );
	}

	public function asArray(){ return $this->_asArray; }

	public function asHTML()
	{
		return $this->dataType()->formatArray( $this->asArray() );
	}

	public function name() { return $this->_name; }

	public function __toString(){ return serialize( $this->value()->asXML() ); }

	public function show()
	{
		return htmlspecialchars( $this->value()->asXML(), ENT_QUOTES, 'utf-8' );
	}

	public function asXML(){ return $this->value()->asXML(); }

	public function value()
	{
		return !$this->hasError() ? $this->inputValue() : NULL ;
	}

}
