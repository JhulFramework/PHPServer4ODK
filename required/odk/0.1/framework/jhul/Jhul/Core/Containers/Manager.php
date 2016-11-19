<?php namespace Jhul\Core\Bags;

//Data Container
class Manager
{
	public function newBag($name)
	{
		$bagClass = __NAMESPACE__.'\\'.ucfirst($name);
		return new $bagClass;
	}
}
