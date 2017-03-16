<?php namespace Jhul\Components\Router;

class Handler
{
	protected $_node;
	protected $_module;

	public function __construct( $H )
	{
		$this->_node	= $H['N'];
		$this->_module_ik	= $H['M'];
	}

	public function moduleIK()
	{
		return $this->_module_ik;
	}

	public function node()
	{
		return $this->_node;
	}
}
