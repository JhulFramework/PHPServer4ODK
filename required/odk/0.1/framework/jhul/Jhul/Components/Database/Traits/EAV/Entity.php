<?php namespace Jhul\Components\Database\Traits\EAV;

//Trait For Entiy Model

trait Entity
{

	protected $_instantiated_EAV = [] ;

	abstract function EAVMap();

	function EAV( $name )
	{
		if( isset( $this->_instantiated_EAV[$name]  ) )
		{
			return $this->_instantiated_EAV[ $name ];
		}

		return $this->_EAV( $name );
	}

	private function _EAV( $name )
	{
		if( isset( $this->EAVMap()[$name]) )
		{
			$class = $this->EAVMap()[$name];

			if( !class_exists($class) ){ throw new \Exception( 'Class "'.$class.'" does not exists' , 1); }

			return $this->_instantiated_EAV[$name] =  new $class( $name, $this );
		}

		throw new \Exception('EAV "'.$name.'" Not Mapped in "'.get_called_class().'" ', 1);
	}
}
