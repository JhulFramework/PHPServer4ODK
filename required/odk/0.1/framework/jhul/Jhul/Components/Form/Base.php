<?php namespace Jhul\Components\Form;

/* @Author : Manish Dhruw < 1D3N717Y12@gmail.com >
+=======================================================================================================================
|@Dependencies-
| - AntiCSRF Component
|
|@Updated:
|	-Saturday 03 January 2015 07:01:22 PM IST
|	-Saturday 10 January 2015 03:54:05 PM IST
|	-Tuesday 16 June 2015 01:23:44 PM IST
+---------------------------------------------------------------------------------------------------------------------*/

abstract class Base extends Base_Zero
{
	public $autoCollect = TRUE;

	protected $_captcha ;

	//we will auto create properties which are defined in field definitions;
	public function __construct()
	{
		foreach( $this->fields() as $field => $r )
		{
			if( !property_exists( $this, $field ) )
			{
				$this->$field = NULL ;
			}
		}
	}


	//@param array $data(raw data e.g. either from POST or GET)
	//Collects and set form data can be supplied as argument. eg $formModel->collect( $_GET )
	//Auto collect from $_POST if autocollect is set to TRUE eg formModel->collect()
	//Uses form name to retrive data
	//Only collects those filelds which are defined in field definition
	public function collect( $data = NULL )
	{
		if( ( NULL === $data ) && $this->autoCollect && array_key_exists( $this->name(), $_POST ) )
		{
			$data = $_POST[ $this->name() ] ;
		}

		if( is_array( $data )  )
		{
			foreach( $this->fields() as $field => $dataType )
			{
				if( array_key_exists( $field, $data ) )
				{
					$this->$field = $this->getApp()->mDataType( $dataType )->make( $data[$field] );
				}
				else
				{
					//createing nULL VALUE OBJECT
					$this->$field = $this->getApp()->mDataType( $dataType )->make( NULL );
				}

				$this->addErrors( $field, $this->$field->error()->getAll() );
			}

			return TRUE ;
		}

		return FALSE;
	}

	public function validate()
	{
		if( $this->captcha()->isActive() )
		{
			if( !$this->captcha()->validate() )
			{
				$this->addError( $this->captcha()->name(), 'ERROR_CAPTCHA_CODE_FAILED' );
			}
		}

		return !$this->hasError();
	}

	//Define attributes which we want to collect from array of raw data,
	protected abstract function fields();

	//returns HTML form field name
	public function fieldName( $field )
	{
		return 'name = "'.$this->name().'['.$field.']"';
	}

	//Restores client sumitted data, to avoid refilling the form
	public function restore( $key )
	{
		if( isset( $_POST[ $this->name() ] ) && isset( $_POST[ $this->name() ][ $key ] ) )
			return $this->HTMLEncode( $_POST[ $this->name() ][ $key ] );
	}

	public function error( $key )
	{
		if( NULL != ($e = parent::error($key)) )
		{
			return $this->getApp()->lipi()->t($e);
		}
	}

	protected $_strings = [];

	public function string( $key )
	{
		if( empty( $this->_strings ) )
		{
			$this->_strings = $this->getApp()->lipi()->t( $this->stringKeys() );
		}

		return isset( $this->_strings[$key] ) ? $this->_strings[$key] : $key ;
	}

	protected function stringKeys()
	{
		return  [];
	}

	public function authAttempts( $UIK )
	{
		return $this->J()->cx('bfd')->get( $UIK, $this->name() );
	}


	public function captcha()
	{
		if( NULL == $this->_captcha )
		{
			$this->_captcha = new Captcha( $this );
		}

		return $this->_captcha;
	}

	//return unsanitize raw POST value
	public function fieldValue( $fieldName )
	{
		if( isset( $_POST[$this->name()][$fieldName] ) )
		{
			return  $_POST[$this->name()][$fieldName];
		}
	}

	public function onAuthorizationFail( $UIK )
	{
		$this->authAttempts( $UIK )->register()->commit();

		if( $this->authAttempts( $UIK )->countAttempts()  > 12 )
		{
			$this->captcha()->activate();
		}
	}

	public function onAuthorizationSuccess( $UIK )
	{
		$this->captcha()->deactivate();
		$this->authAttempts( $UIK )->clear()->commit();
	}
}
