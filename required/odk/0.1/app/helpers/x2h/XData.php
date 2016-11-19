<?php namespace app\helpers\x2h;

class XData
{
	protected $_errors = [] ;

	protected $_name;

	protected $_data;

	protected $_x2h;

	public function __construct( $xmlArray, $x2h )
	{
		$this->_x2h = $x2h;

		$this->_name = $xmlArray['@attributes']['id'];

		unset( $xmlArray['@attributes'] );

		$this->_data = $xmlArray;
	}

	public function asArray(){ return $this->_data; }

	public function asHTML()
	{
		return $this->_x2h->formatArray( $this->asArray() );
	}

	public function name() { return $this->_name; }

	public function __toString(){ return serialize( $this->_data ); }
}
