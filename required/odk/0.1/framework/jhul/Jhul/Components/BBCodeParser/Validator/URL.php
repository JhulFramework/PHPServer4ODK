<?php namespace Jhul\Components\BBCodeParser\Validator;

class URL  implements \JBBCode\InputValidator
{

	protected $_allowed_url_map = [];

	public function __construct( $map )
	{
		$this->_allowed_url_map = $map;
	}

	/**
	 * Returns true iff $input is a valid url.
	 *
	 * @param string $input  the string to validate
	 * @return boolean
	 */
	public function validate($URL)
	{

		//TO Prevent XSS
		if( false !== strpos( $URL,  '?javascript' ) || false !== strpos( urldecode($URL),  '?javascript' ) )
		{
			return false;
		}

		$info = parse_url( $URL );

		$host = '';

		if(  isset( $info['host'] ) )
		{
			$host = strrev( $info['host'] );
		}


		foreach ($this->_allowed_url_map as $allowed)
		{
			if( 0 === strpos( $host, strrev($allowed) ) )
			{
				return TRUE ;
			}
		}

		return FALSE;
	}
}
