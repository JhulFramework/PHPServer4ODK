<?php namespace Jhul\Core\Design\Data\Store;

//Attribute Element Trunk

trait _Trait
{
	//Loaded Attribute Element
	protected $_LAE = [];

	public function hasAE( $name )
	{
		return isset( $this->elementMap()[$name] );
	}

	//attrinbute element map
	public function elementMap()
	{
		return [];
	}

	// @param $name data type name
	// @param $def data typefdefinition for overriding default definition
	public function getAE( $name, $def = NULL )
	{
		if( empty( $this->_LAE[$name] ) && $this->hasAE($name) );
		{
			$this->_LAE[$name] = $this->_loadAE($name, $def);

			if( empty( $this->_LAE ) && $throwExceptionOnFail )
			{
				throw new \Exception( 'Data Type "'.$name.'" Not Found in "'.get_called_class().'"' , 1);

			}
		}

		return $this->_LAE[$name];
	}

	//Get Element Attribute
	protected function _loadAE( $name, $def = NULL )
	{
		if( strpos($name, '::') &&  NULL != ( $type = $this->getDataType($name) ) )
		{
			return $this->_loadAE( $type, $def );
		}


		if( $this->hasAE( $name ) )
		{

			$AEC = $this->elementMap()[$name];

			if( is_array( $AEC ) )
			{
				$class =  $AEC['c'] ;
			}
			else
			{
				$class = $AEC ;
			}

			$element = $class::I()->setDefinition( $def );

			if( isset( $AEC['p'] ) )
			{
				$element->setConfigurationMap( require( $AEC['p'].'.php' ) );
			}

			return $element;
		}

		//throw new \Exception('AE "'.$name.'" not Found in "'.get_called_class().'" ')
	}


	public function getDataType( $definition )
	{
		$i = explode( '::', $definition );

		return  empty( $i[0] ) ? NULL: $i[0];
	}
}
