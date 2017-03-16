<?php namespace Jhul\Components\Lipi ;


class _Resource
{
	//translation files map
	protected $_translation_map = [];

	//translation files map
	protected $_file_map = [];

	protected $_lipi;

	protected $_loaded_files = [];

	protected $_registered_files = [];


	public function __construct( $lipi )
	{
		$this->_lipi = $lipi;
	}

	public function load( $_language_name )
	{
		foreach ( $this->fileMap( $_language_name )  as $file )
		{
			$this->loadFile( $file, $_language_name );
		}
	}

	public function loadFile( $file, $name )
	{
		if( !isset( $this->_loaded_files[$file] )  )
		{
			$_translation_map = require( $file );

			if( is_array($_translation_map) )
			{
				foreach ( $_translation_map as $key => $value )
				{
					$this->_translation_map[$name][$key] = $value;
				}

				$this->_loaded_files[ $file ] = $name;
			}
		}
	}

	public function get( $key, $language_name )
	{
		if( isset( $this->_translation_map[ $language_name ][$key] ) )
		{
			return $this->_translation_map[ $language_name ][$key];
		}

		return $key;
	}

	public function register( $language, $file = NULL )
	{
		if( is_array( $language ) )
		{
			foreach ( $language as $key => $value )
			{
				$this->register( $key, $value );
			}

			return;
		}

		if(  NULL != ( $name = $this->_lipi->get( $language , 'name' ) ) )
		{
			if( empty($file) )
			{
				throw new \Exception( 'Translation Resource File Must Not Be Empty' , 1);
			}

			if( !isset( $this->_registered_files[ $file ] ) )
			{
				$this->_registered_files[$file] = $name ;

				$this->_file_map[$name][] = $file;

				if( $this->_lipi->currentLanguage()->match( $name ) )
				{
					$this->loadFile( $file , $name );
				}
			}

		}
	}

	public function registerFile( $language, $file )
	{
		$code = $this->make($language)->code();

		$this->_translation_files[ $code ][] = $file;

		//if the new the translation files are mapped and if its the current langauge, it should be loaded immediatly
		if( $this->currentlanguage()->match( $languageCode ) && !isset( $this->_loadedFiles[ $file ] ) )
		{
			$this->loadTransLationFiles( $file );
		}
	}

	public function map( $name = NULL )
	{
		if( !empty( $name ) )
		{
			if( isset( $this->_translation_map[$name]) )
			{
				return $this->_translation_map[ $name ] ;
			}
		}
		return $this->_translation_map ;
	}

	public function fileMap( $name = NULL )
	{
		if( !empty( $name ) )
		{
			if( isset( $this->_file_map[$name]) )
			{
				return $this->_file_map[ $name ] ;
			}
		}
		return $this->_file_map ;
	}
}
