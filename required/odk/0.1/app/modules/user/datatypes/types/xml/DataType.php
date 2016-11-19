<?php namespace _modules\user\datatypes\types\xml;

class DataType extends \Jhul\Core\Application\DataType\Types\String\Attribute
{
	public function valueEntityClass()
	{
		return __NAMESPACE__.'\\Value';
	}

	public function make( $value )
	{


		if( is_file($value) )
		{
			$value = file_get_contents( $value );
		}

		return parent::make( simplexml_load_string($value, "SimpleXMLElement", LIBXML_NOCDATA) );
	}

	//takes simplexml_load_string() object
	public function xmlToArray( $xmlObject )
	{


		return  json_decode( json_encode( $xmlObject ) , TRUE )  ;
	}

	public function type() { return 'xml'; }

	public function validateType( $value )
	{
		return TRUE;
	}

	public function formatArray( $data )
	{
		return '<div class="x2h" >'.$this->_cookArray( $data ).'</div>' ;
	}

	protected function _cookArray( $data )
	{

		$str = '<div>';
		foreach ( $data as $name => $value )
		{
			$str .= '<span class="border_right" >'
				. $this->_cookName( $name )
				. $this->_cookValue( $value )
				. '</span>';
		}

		$str .='</div>';

		return $str;
	}

	protected function _cookName( $name )
	{
		return '<div class="border_bottom" >'.$name.'</div>' ;
	}

	protected function _cookValue( $value )
	{
		if( is_array( $value ) )
		{
			return $this->_cookArray( $value );
		}
		return '<div>'.$value.'</div>';
	}

	public function style()
	{
		if( empty($this->_style) )
		{
			$this->_style = file_get_contents( __DIR__.'/x2h.css' );
		}

		return $this->_style;
	}


}
