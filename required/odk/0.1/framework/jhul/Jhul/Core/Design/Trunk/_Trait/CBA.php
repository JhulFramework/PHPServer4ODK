<?php namespace Jhul\Core\Design\Trunk\_Trait;

/* @Author : Manish Dhruw [1D3N717Y12@gmail.com]
+=======================================================================================================================
| Access Perspective Based Factory
| -A = Anonymous
| -O = Other User
| -S = UserSelf
+---------------------------------------------------------------------------------------------------------------------*/

//Context Based Access
trait CBA
{

	protected $_context;

	//Set Access Perspective
	public function setContext( $context )
	{
		$this->_context = $context;
		return $this;
	}

	public function entityClass()
	{
		if( isset( $this->_entityClasses[ $this->_context ] ) )
		{
			return $this->_entityClasses[ $this->_context ] ;
		}

		throw new \Exception('Entity Class Not Found For Context "'.$this->_context.'" !  in '.get_called_class());
	}


}
