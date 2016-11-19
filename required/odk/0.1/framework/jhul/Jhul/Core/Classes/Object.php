<?php namespace \mwapp\core\classes;

/*----------------------------------------------------------------------------------------------------------------------
 *@author Manish Dhruw < 1D3N717Y12@gmail.com >
 *
 * just kept as a definition
 * usable
 * for flexibility not usin it directly, though still using methods
 *Friday 19 December 2014 08:18:13 PM IST
 *---------------------------------------------------------------------------------------------------------------------*/
 
abstract class Object implements \mwapp\core\interfaces\Object
{
	public static function I()
	{
		return \mwapp\MW::I()->objectMaker()->make( new static() );
	}
}
