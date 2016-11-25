<?php namespace _modules\user\datatypes\xml;

class DataType extends \Jhul\Core\Application\DataType\Types\String\Attribute
{
	public function valueEntityClass()
	{
		return __NAMESPACE__.'\\Value';
	}

	public function arrayToXML( $rootString, $array )
	{
		$xmlObj = new \SimpleXMLElement( $rootString );

		array_walk_recursive( $array , array ( $xmlObj , 'addChild') );

		return $xmlObj->asXML();
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

	public function arrayToCsv( array &$fields, $delimiter = ';', $enclosure = '"', $encloseAll = false, $nullToMysqlNull = false )
	{
		$delimiter_esc = preg_quote($delimiter, '/');
		$enclosure_esc = preg_quote($enclosure, '/');

		$output = array();
		foreach ( $fields as $field )
		{
			if ($field === null && $nullToMysqlNull)
			{
				$output[] = 'NULL';
				continue;
			}

			// Enclose fields containing $delimiter, $enclosure or whitespace
			if ( $encloseAll || preg_match( "/(?:${delimiter_esc}|${enclosure_esc}|\s)/", $field ) )
			{
				$output[] = $enclosure . str_replace($enclosure, $enclosure . $enclosure, $field) . $enclosure;
			}
			else
			{
				$output[] = $field;
			}
		}

		return implode( $delimiter, $output );
	}

}
