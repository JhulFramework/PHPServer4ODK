<?php namespace Jhul\Components\Database\Traits;

// Hard Database Entity Component
// trait for DB Entity which hold other DB entity components
// This laod dataabse entity component from aprent databse entity
// if it does exist it will creates it, its similary to lazily creating databse record
trait RDBEComponentContainer
{
	use RelativeEntity;

	// Database Entity Components Hard
	protected $_DEC_H = [];

	function getRDBEComponent( $name )
	{
		if( empty( $this->_DEC_H[$name] ) )
		{
			$this->_DEC_H[$name] = $this->_getRDBEComponent($name);
		}

		return $this->_DEC_H[$name];
	}

	// get Database Entity Component
	protected function _getRDBEComponent( $name )
	{
		$component = $this->getRDB( $name )->fetch();

		if( empty( $component ) )
		{
			$component = $this->createRDBE( $name );

			if( $this->hasRDBEParams($name, 'import' ) )
			{
				foreach ( $this->getRDBEParams( $name, 'import' )  as $key => $asKey )
				{
					$this->write( $asKey, $component->read($key) );
				}

				$this->commit();
			}

			return $this->getRDBEComponent( $name );
		}

		return $component;
	}

}
