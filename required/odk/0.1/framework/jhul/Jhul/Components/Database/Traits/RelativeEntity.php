<?php namespace Jhul\Components\Database\Traits;

//Realtive Database Enties Handler
trait RelativeEntity
{
	// get Database Entity Component
	protected function getRDB( $name )
	{
		return $this->_RDBTable( $name )->byParams(  $this->getRDBEParams( $name, 'search' ) );
	}

	protected function _RDBTable( $name )
	{
		$cClass =  $this->getRDBEParams( $name, 'class' );

		if( class_exists( $cClass ) )
		{
			return $cClass::table();
		}

		throw new \Exception( ' Element class "'.$cClass.'" Not found in runk Type "'.get_called_class().'" ' , 1);

	}

	function getRDBEParams( $name, $param )
	{
		return $this->relativeDatabaseEntities()[$name][$param];
	}

	function hasRDBEParams( $name, $param )
	{
		return isset( $this->relativeDatabaseEntities()[$name][$param] );
	}

	//Create New Relative Database Entity
	function createRDBE( $name, $params = [] )
	{

		$params =  $this->getRDBEParams( $name, 'create' ) + $params;

		$record = $this->_RDBTable( $name )->createNew( $params );

		if( $this->hasRDBEParams($name, 'set_after_create') )
		{
			$toSet = $this->getRDBEParams($name, 'set_after_create');

			foreach ( $toSet as $key => $value)
			{
				$record->write( $key, $value );
			}

			$record->commit();
		}

		return $record;
	}


	abstract function relativeDatabaseEntities();

}
