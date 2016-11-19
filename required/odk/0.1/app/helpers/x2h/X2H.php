<?php namespace app\helpers\x2h;

/* @Author : Manish Dhruw <eskylite@gmail.com>
+=======================================================================================================================
| @Created : 2016-Nov-09
|
| @TODO SIZE Check and Validation
----------------------------------------------------------------------------------------------------------------------*/


class X2H
{

	protected $_style ;

	public function make( $xml )
	{
		if( is_file($xml) )
		{
			$xml = file_get_contents($xml);
		}

		$data = simplexml_load_string($xml, "SimpleXMLElement", LIBXML_NOCDATA);

		$data = json_encode( $data );

		return new XData( json_decode( $data,TRUE), $this );
	}

	public function format( $xml )
	{
		return $this->make( $xml )->asHTML();
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


	/*
	| @params $rootStrin
	| Example : $this->arrayToXML( <?xml version=\"1.0\"?><user></user>, $arrayData )
	| Example : $this->arrayToXML( <user id="12"></user>, $arrayData )
	|
	*/
	public function arrayToXML( $rootString, $array )
	{
		$xmlObj = new \SimpleXMLElement( $rootString );

		array_walk_recursive( $array , array ( $xmlObj , 'addChild') );

		return $xmlObj->asXML();
	}
}
