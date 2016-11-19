<?php namespace Jhul\Core\Containers;

class Error
{

	protected $_errors = [];

	public function add( $value )
	{
		if( is_array($value) )
		{
			foreach ( $value as $k => $v )
			{
				$this->add( $k, $v );
			}

			return;
		}

		$this->_errors[] = $value;
	}

	public function get(){ if( isset($this->_errors[0]) ) return $this->_errors[0]; }

	public function isEmpty(){ return empty($this->_errors); }

	public function getAll(){ return $this->_errors ; }

	public function __toString(){ return $this->get(); }
}
