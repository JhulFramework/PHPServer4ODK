<?php namespace Jhul\Utils\Traits ;

/*----------------------------------------------------------------------------------------------------------------------
 *@Author Manish Dhruw < 1D3N717Y12@gmail.com >
 *
 *NEEDS to Define property $map[] in parent class
 *
 *@created -
 * -Friday 07 March 2014 12:39:07 PM IST 
 *
 @Updated
 * -Saturday 23 May 2015 06:27:46 PM IST 
 *--------------------------------------------------------------------------------------------------------------------*/



trait EasyArray
{

	public function explode( $string )
	{
		return explode( self::$_childSeparator, $string );
	}

	public static function traitEasyArrayVersion()
	{
		return '0.2';
	}

	private static $_childSeparator = ':';

	public function setChildSeparator( $separator )
	{
		self::$_childSeparator = $separator;
	}

	/*
	 * @returns $default if key not set 
	*/
	public function get( $path, $toBeReturnedOnFail = null )
	{
		$keys = $this->explode($path);

		$aOrV = &$this->map;

		if( !empty($keys) )
		{
			foreach ($keys as $key)
			{
				if ( is_array($aOrV) and array_key_exists($key, $aOrV) ) $aOrV = &$aOrV[$key];

				else return $toBeReturnedOnFail;
			}
		}

		return $aOrV;	
	}


	public function exists( $path )
	{
		return $this->get( $path, false ) !== false ;
	}

	public function has( $path )
	{
		return $this->get( $path, false ) !== false ;
	}

	/* sets key value only if, key already not exists */
	public function setDefault( $path, $value )
	{
		return $this->exists($path) ? false : $this->set($path, $value, false ) ;
	}

	public function setArraySeperator( $s )
	{
		$this->_arraySeperator = $s ;
	}

	/*
	* @ returns,
	- On Fail - returns Error Message if set, returns false ( default ),
	- On Succes - true;
	
	* it will overwrite values
	* does not create array of dublicate keys, instead overWrites them or fail
	*/
	public function set( $path, $value, $overWrite = false, $toBeReturnedOnFail = false )
	{
	
		$keys = $this->explode($path);

		$count = count($keys);

		$aOrV = &$this->map;
		
		$error = null ;

		while( $count > 0 && $error == null )
		{
			$count--;

			$key = array_shift($keys);


			if(  array_key_exists($key, $aOrV) && is_array($aOrV[$key])  ) $aOrV = &$aOrV[$key] ;

			elseif( !array_key_exists($key, $aOrV)  || $overWrite )
			{
				$aOrV[$key] = array();
				$aOrV = &$aOrV[$key] ;
			}

			else $error =  'Either, "'.$key.'" already exists or is not array . Set fourth arg true to OverWrite';
		}

		if( empty($keys) && $error == null )
		{
			if( empty($aOrV) )
			{
				$aOrV = $value;
				return true;
			}
			elseif( $overWrite  )
			{
				$aOrV = is_array($value) && is_array($aOrV) ? array_merge($aOrV, $value) : $value;
				return true;
			}
		}

		return $toBeReturnedOnFail === null ? $error : $toBeReturnedOnFail ;
	}

	public function remove( $path )
	{
		$keys = $this->explode($path);

		$lastKey = array_pop($keys);

		$aOrV = &$this->map;
		
		$error = null ;

		$count = count( $keys );

		while( $count > 0 && $error == null )
		{
			--$count ;

			$key = array_shift($keys);

			if( array_key_exists($key, $aOrV) && is_array($aOrV[$key])  ) $aOrV = &$aOrV[$key] ;
		}


		if( $count == 0 && isset($aOrV[$lastKey]) )
		{
			unset( $aOrV[$lastKey] ) ; 
			return TRUE ;
		}

		return FALSE;
	}

	// get and remove
	public function pull( $path )
	{
		$keys = $this->explode($path);

		$lastKey = array_pop($keys);

		$aOrV = &$this->map;
		
		$error = null ;

		$count = count( $keys );

		while( $count > 0 && $error == null )
		{
			--$count ;

			$key = array_shift($keys);

			if( array_key_exists($key, $aOrV) && is_array($aOrV[$key])  ) $aOrV = &$aOrV[$key] ;
		}


		if( $count == 0 && isset($aOrV[$lastKey]) )
		{
			$v = $aOrV[$lastKey] ;
			unset( $aOrV[$lastKey] ) ; 
			return $v ;
		}

		return FALSE;
	}
	


	public function merge( $from, $overWrite = false )
	{
		$this->_merge( $from, $this->map, $overWrite ) ;
	}

	private function _merge( $from, &$to, $overWrite = false  )
	{

		foreach( $from as $k => $v )
		{
			if( array_key_exists( $k, $to) )
			{
				if( is_array( $v ) && is_array($to[$k]) )
				{
					$this->_merge( $v, $to[$k], $overWrite );
				}

				elseif( $overWrite ) $to[$k] = $v;
			}

			else $to[$k] = $v;
		}
	}

	public function iterator()
	{
		return new \ArrayIterator($this->map);
	}

}


