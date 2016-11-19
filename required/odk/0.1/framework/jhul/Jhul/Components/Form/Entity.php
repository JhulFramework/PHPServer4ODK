<?php namespace Jhul\Components\Application\Html\Form;
/*----------------------------------------------------------------------------------------------------------------------
 *@Author Manish Dhruw < 1D3N717Y12@gmail.com >
 *
 *
 *@Created - Friday 10 July 2015 08:38:33 PM IST 
 *--------------------------------------------------------------------------------------------------------------------*/

abstract class Entity
{

	use \Jhul\Core\Traits\DependencyProvider;

	const VERSION = '0.1';

	protected $autoCollect = TRUE;

	private $_entity;

	//set whether or not autocollect post data
	public function setAutoCollect( $bool )
	{
		$this->autoCollect = (bool) $bool;
		return $this ;
	}

	public static function I() { return new static() ; }

	//@param array $data(raw data e.g. either from POST or GET)
	//Collects and set form data can be supplied as argument. eg $formModel->collect( $_GET )
	//Auto collect from $_POST if autocollect is set to TRUE eg formModel->collect()
	//Uses form name to retrive data
	//Only collects those filelds which are defined in field definition
	public function collect( $value = NULL )
	{
		if( ( NULL === $value ) && $this->autoCollect && array_key_exists( $this->name(), $_POST ) )
		{
			$value = $_POST[ $this->name() ] ;
			
			$class = $this->entityClass();
			$this->_entity = new $class( $value );
			
			return TRUE;
			
		}

		if( is_array( $value )  )
		{

			if( isset( $value[ $this->name() ] ) )
			{
				$class = $this->entityClass();
				$this->_entity = new $class(  $value[ $this->name() ]  );
			}

			return TRUE ;
		}

		return FALSE;
	}

	public function validate(){ return $this->entity()->validate(); }

	public function error()
	{
		if( NULL != $this->entity() )
		{
			return $this->entity()->error();
		}
	}
	
	public function errors()
	{
		if( NULL != $this->entity() )
		{
			return $this->entity()->errors();
		}
	}

	protected $_name ;

	//returns form name
	//Override , to set form name ,
	//By Default form model name will be used as form name
	public function name()
	{
		if( NULL == $this->_name )
		{
			$class = get_called_class();

			$this->_name = substr( $class, strrpos( $class, '\\'  ) + 1 );	
		}
		return $this->_name;
	}

	//Restores client sumitted data, to avoid refilling the form
	public function restore( $key )
	{
		if( isset( $_POST[ $this->name() ] ) ) return $this->com('Html')->encode( $_POST[ $this->name() ] );
	}


	//insert anti csrf field in the form
	public function CSRFCheckField() { return $this->com( 'AntiCSRF' )->field(); }

	//Csrf Check
	public function CSRFCheck() { return $this->com( 'AntiCSRF' )->validate(); }

	public function entity()
	{
		return $this->_entity;
	}

	protected abstract function entityClass();
}

