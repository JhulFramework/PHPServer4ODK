<?php namespace Jhul\Components\Database\Traits;

trait OldValueGetter
{
	protected $_oldValues = [];

	protected getOld( $key )
	{
		$this->_oldValues[$key];
	}

	function commitRecord()
	{
		$this->_oldValues = $this->fields;
		parent::commitRecord();
	}
}
