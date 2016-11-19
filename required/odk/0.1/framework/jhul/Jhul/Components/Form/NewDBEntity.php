<?php namespace Jhul\Components\Application\Form;

/* @Author Manish Dhruw < 1D3N717Y12@gmail.com >
+=======================================================================================================================
|
 *
 *@created
 *-Saturday 10 January 2015 03:54:05 PM IST
 *@Updated-
 * -Friday 19 June 2015 09:12:24 AM IST
 +--------------------------------------------------------------------------------------------------------------------*/

abstract class NewDBEntity extends DBEntity
{

	private $_entity;

	public function entity()
	{
		if( NULL == $this->_entity && NULL != ( $class = $this->entityClass() ) )
		{
			if( FALSE === strpos( $class, '\\' ) )
			{
				$class = $this->j()->g('D')->g('ClassMapper')->getClass( $class );
			}

			$this->_entity = new $class  ;
		}

		return $this->_entity ;
	}

	//since its new record , we need to reload the entity from db after been created
	public function saveEntity( $validate = TRUE )
	{
		if( parent::saveEntity( $validate ) )
		{
			$eClass = $this->entityClass();

			$eClass = $eClass::table();

			foreach( $this->fieldsToSave() as $f )
			{
				$eClass->where( $f, '=', $this->entity()->get($f) );
			}

			$this->_entity = $eClass->fetch();

			return TRUE;
		}

		return FALSE;
	}

	//we need to define entity class, active record model name
	protected function entityClass()
	{
		throw new \Exception( ' Please define method "entityClass()" to return entity class, in form model "'. get_called_class().'"' );
	}
}
