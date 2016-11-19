<?php namespace Jhul\Components\Application\Form;
/*----------------------------------------------------------------------------------------------------------------------
 *@author Manish Dhruw < 1D3N717Y12@gmail.com >
 *
 *
 *@created Saturday 10 January 2015 03:54:05 PM IST
 *--------------------------------------------------------------------------------------------------------------------*/

abstract class EditDBEntity extends DBEntity
{


	private $_entity ;

	public function __construct( $entity )
	{
		$this->_entity = $entity ;
		parent::__construct();
	}

	public function entity()
	{
		return $this->_entity ;
	}

	public function restore( $key )
	{
		if( NULL != ( $oldValue = parent::restore( $key ) ) )
		{
			return $oldValue;
		}

		if( $this->entity()->has( $key ) )
		{
			return $this->entity()->get( $key ) ;
		}
	}
}
