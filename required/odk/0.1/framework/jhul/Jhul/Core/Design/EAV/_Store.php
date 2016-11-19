<?php namespace Jhul\Core\Design\EAV;

trait _Store
{
	protected $_instantiated_EAV = [] ;

	abstract function elementMap();

	public function getEAV( $name )
	{
		if( isset( $this->_instantiated_EAV[$name]  ) )
		{
			return $this->_instantiated_EAV[ $name ];
		}

		return $this->_getEAV( $name );
	}

	private function _getEAV( $name )
	{
		if( isset( $this->elementMap()[$name]) )
		{
			$class = $this->elementMap()[$name];

			return $this->_instantiated_EAV[$name] =  new $class( $name, $this );
		}

		throw new \Exception('EAV "'.$name.'" Not Mapped in "'.get_called_class().'" ', 1);
	}
}
