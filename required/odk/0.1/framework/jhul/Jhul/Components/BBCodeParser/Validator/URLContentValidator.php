<?php namespace Jhul\Components\BBCodeParser;

class URLContentValidator  implements \JBBCode\InputValidator
{

	protected $_allowedURLMap = [];

	public function __construct()
	{
		$this->_allowedURLMap = require( __DIR__.'/_allowed_url_map.php' );
	}

	/**
	 * Returns true iff $input is a valid url.
	 *
	 * @param string $input  the string to validate
	 * @return boolean
	 */
	public function validate($URL)
	{
		$info = parse_url( $URL );

		if( false != strpos( '.', $URL ) )
		{
			if( isset($info['scheme']) && isset( $info['host'] ) )
			{
				$base = $info['scheme'].'://'.$info['host'].'/';

				return in_array( $base, $this->_allowedURLMap );
			}
		}
		return FALSE;
	}
}
