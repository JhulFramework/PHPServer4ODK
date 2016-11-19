<?php namespace Jhul\Components\Application\Form;
/*----------------------------------------------------------------------------------------------------------------------
 *@Aauthor [Manish Dhruw] <1D3N717Y12@gmail.com>
 *
 *@Created On - Friday 19 June 2015 09:16:10 AM IST
 *--------------------------------------------------------------------------------------------------------------------*/
abstract class DBEntity extends Base
{

	public function __construct()
	{
		parent::__construct();

		foreach( $this->fieldsToSave() as $field  )
		{
			if( !property_exists( $this, $field ) )
				$this->$field = NULL ;
		}
	}

	//Saves record
	public function saveEntity( $validate = TRUE )
	{
		if(  ( $validate == FALSE && !$this->hasError() ) || ( $this->validate() && !$this->hasError() ) )
		{
			foreach( $this->fieldsToSave() as $f )
			{
				$this->entity()->set( $f, $this->$f );
			}

			return $this->entity()->save();
		}
	}

	//this method return  current db entity
	abstract public function entity();

	abstract protected function fieldsToSave();

	//only those fields defined here, will get saved in the database
	//AND only these fields get validated
	/*public function fieldsToSave()
	{
		throw new \Exception('Please define Method fieldsToSave() in your model to return ,
			to return array of fields which needs to be save in database');
	}*/


}
