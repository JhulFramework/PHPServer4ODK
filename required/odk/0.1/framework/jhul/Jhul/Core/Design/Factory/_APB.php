<?php namespace Jhul\Core\Design\Factory;

/* @Author : Manish Dhruw [1D3N717Y12@gmail.com]
+=======================================================================================================================
| Access Perspective Based Factory
| -A = Anonymous
| -O = Other User
| -S = UserSelf
+---------------------------------------------------------------------------------------------------------------------*/

//Access Perspective Based

trait _APB
{

	protected $_accessPerspective;

	//Set Access Perspective
	public function SAP( $_accessPerspective )
	{
		$this->_accessPerspective = $_accessPerspective;
		return $this;
	}

	public function entityClass()
	{
		if( isset( $this->entityClasses()[ $this->_accessPerspective ] ) )
		{
			return $this->entityClasses()[ $this->_accessPerspective ] ;
		}

		throw new \Exception('Entity Class Not Found For Context "'.$this->_accessPerspective.'" !  in '.get_called_class());
	}

}
