<?php namespace Jhul\Core\Containers;

trait _Error
{
	protected $_error;

	public function error()
	{
		if( empty($this->_error) ) { $this->_error = new Error; }

		return $this->_error;
	}

	public function hasError()
	{
		if(empty($this->_error)) return FALSE;

		return  !$this->_error->isEmpty();
	}

}
