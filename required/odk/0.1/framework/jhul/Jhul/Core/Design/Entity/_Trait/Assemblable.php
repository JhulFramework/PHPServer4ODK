<?php namespace Jhul\Core\Design\Entity\_Trait;

/* @Author : Manish Dhrue [eskylite@gamil.com]
+=====================================================================================================================+=
| @Created : 2016-Aug-02
+---------------------------------------------------------------------------------------------------------------------*/

trait Assemblable
{
	abstract public function assemblerClass();


	public function ifAssemblyRequired()
	{
		return TRUE;
	}
}
