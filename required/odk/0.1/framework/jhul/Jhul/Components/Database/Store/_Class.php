<?php namespace Jhul\Components\Database\Store;

/* @Author : Manish Dhruw [ 1D3N717Y12@gmail.com ]
+=======================================================================================================================
|
+---------------------------------------------------------------------------------------------------------------------*/

abstract class _Class extends _Base
{

	//item dispenser
	public static function get( $context  )
	{
		$dataClass = static::I()->getItemClass( $context );

		return $dataClass::I();
	}

	//item dispenser
	public static function D( $context )
	{
		$dataClass = static::I()->getItemClass( $context );

		return $dataClass::D();
	}


	//only create and return datamodel using data array, but does not saves it to database
	public function create(  $context, $params = []  )
	{
		return $this->initilizeFields( static::get( $context ), $params );
	}

	//create data model from data array, saves it database and return datamodel
	public function createAndCommit( $context, $params = [] )
	{
		return $this->commit( $this->create( $context, $params ) );
	}
}
