<?php namespace Jhul\Components\Lipi ;

/* @Author : Manish Dhruw <1D3N717Y12@gmail.com>
+========================================================================================================================================
| @Created -Saturday 23 May 2015 06:29:05 PM IST
|
|@API -
| 	- registerTranslationFiles( $map );
| 	- registerTranslationFile( $languageCode, $translationFile );
|
| 	 //Configure default language code
| 	- setLanguageCode( $languageCode );
|
| 	 //get word translated configured language code
| 	- p( $word );
|
| @Update-
|	-Wed 10 Feb 2016 03:15:51 PM IST
+--------------------------------------------------------------------------------------------------------------------------------------*/

class Lipi
{

	const VERSION = '0.5';


	private $_default_language = 'english' ;

	//Language Object
	private $_current_language ;

	//translation data
	private $_data_map = [];

	protected $_languages = [];

	protected $_codes = [];

	protected $_resource;

	public function __construct()
	{
		$this->_codes['numeric'] = require( __DIR__.'/_digital_codes.php' );
		$this->_codes['iso6393'] = require( __DIR__.'/_iso6393_codes.php' );

		$this->_resource = new _Resource( $this );

		$this->setCurrentLanguage( $this->_default_language );
	}

	public function getCode( $language_name, $type = 'numeric' )
	{
		if( !empty( $this->_codes[$type][$language_name] ) )
		{
			return $this->_codes[$type][$language_name] ;
		}
	}

	public function get( $language, $type = 'numeric' )
	{
		if( strlen($language) == 2  && ( $name = array_search( $language, $this->_codes['numeric'] ) ) )
		{
			if( 'numeric' == $type ) return $language;

			if( 'name' == $type ) return $name;

			if( 'iso6393' == $type ) return $this->_codes['iso6393'][$name] ;
		}

		if( strlen($language) == 3 && NUll != ( $name =  array_search( $language, $this->_codes['iso6393'] ) ) )
		{
			if( 'numeric' == $type ) return $this->_codes['numeric'][$name];

			if( 'name'	== $type ) return $name;

			if( 'iso6393' == $type ) return $language;
		}

		if( isset( $this->_codes['numeric'][$language] ) )
		{
			if( 'numeric' == $type ) return $this->_codes['numeric'][$language];

			if( 'name'	== $type ) return $language;

			if( 'iso6393' == $type ) return $this->_codes['iso6393'][$language] ;
		}

		throw new \Exception( 'Language "'.$language.'" Not Found!' , 1);

	}

	public function currentLanguage()
	{
		return $this->_current_language;
	}

	public function make( $language )
	{
		return new _Lipi( $this->get( $language, 'name' ) , $this );
	}

	public function resource()
	{
		return $this->_resource;
	}

	public function register(  $_language_name, $file = NULL )
	{
		$this->resource()->register(  $_language_name, $file );
	}

	//Sets language code
	public function setCurrentLanguage( $language )
	{
		if( empty( $this->_current_language ) || !$this->_current_language->match( $language )  )
		{
			$this->_current_language = $this->make( $language );
			$this->resource()->load( $this->currentLanguage()->name() );
		}
	}

	public function setDigitalCodeMap( array $map )
	{
		$this->_codes['numeric'] = $map;

		return $this;
	}

	//TRANSLATE
	public function T( $key )
	{
		if( is_array( $key ) )
		{
			$strings = [];

			$language_name = $this->currentLanguage()->name();

			foreach ($key as $k)
			{
				$strings[$k] = $this->resource()->get( $k, $language_name );
			}

			return $strings ;
		}

		return $this->resource()->get( $key, $this->currentLanguage()->name() );
	}

	//@param can be language name or numeric code or iso6393 code
	public function verify( $language)
	{

		if( strlen($language) == 2 )
		{
			return in_array( $language, $this->_codes['numeric'] );
		}

		if( strlen($language) == 3 )
		{
			return in_array( $language, $this->_codes['iso6393'] );
		}

		return !empty($this->_codes['numeric'][$language] );
	}

	public function verifyName( $name )
	{
		return isset($this->_codes['numeric'][$name] );
	}
}
