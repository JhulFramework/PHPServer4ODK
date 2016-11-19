<?php namespace Jhul\Core\Design\Trunk;

/* @Author : Manish Dhruw ['eskylite']
+=======================================================================================================================
| @Created : 2016-July-23
}
| @Design : as similar as trunk containing many branches
|	-each branch have differenct classes
|	-branches can be configurable
+---------------------------------------------------------------------------------------------------------------------*/

trait _Trait
{
	//Created Branches
	protected $_instantiated_elements = [];

	//@returns array
	//lets say branch map[]
	public abstract function elementMap();

	//Get Element By Identity Key
	public function e( $name )
	{
		if( empty( $this->_instantiated_elements[$name] )  )
		{
			if( isset($this->elementMap()[$name] ) )
			{
				if( is_array( $this->elementMap()[$name] ) )
				{
					$class =  $this->elementMap()[$name]['c'] ;
				}
				else
				{
					$class = $this->elementMap()[$name] ;
				}

				$element = new $class($this);

				if( isset( $this->elementMap()[$name]['p'] ) )
				{
					$element->setConfigurationMap( require( $this->elementMap()[$name]['p'].'.php' ) );
				}


				$this->_instantiated_elements[$name] = $element;
			}

			else
			{
				throw new \Exception( 'Object "'.$name.'" not available in Store '.get_called_class() , 1 );
			}

		}

		return $this->_instantiated_elements[$name];
	}
}
