<?php namespace Jhul\Utils\Traits;

/*----------------------------------------------------------------------------------------------------------------------
> @Author Manish Dhruw < 1D3N717Y12@gmail.com >

Thursday 13 February 2014 06:09:31 PM IST
----------------------------------------------------------------------------------------------------------------------*/

trait Errorable
{


	private $_errors = [] ;

	public function hasError( $attrib = NULL )
	{
		if($attrib != NULL) return isset( $this->_errors[$attrib] );

		return !empty($this->_errors) ;
	}


	public function error( $attribute )
	{
		return isset( $this->_errors[$attribute] ) ? $this->_errors[$attribute][0] : null ;
	}

	public function errors( $attribute = null  )
	{
		if( $attribute != null )
		{
			return isset($this->_errors[$attribute]) ? $this->_errors[$attribute] : [] ;
		}

		return $this->_errors;
	}

	// add muliple erros for single field
	public function addErrors( $field, $errors )
	{
		foreach( $errors as $error ) $this->addError( $field, $error );
	}

	// add muliple erros for single field
	public function addError($attribute, $error)
	{
		if( !isset($this->_errors[$attribute] ) ) $this->_errors[$attribute] = array();

		$this->_errors[$attribute][] = $error ;
	}

	public function clearError($attribute = null)
	{
		unset($this->_errors[$attribute]);
	}

	public function clearErrors()
	{
		$this->_errors = array();
	}

	public function setErrors( $errors )
	{
		$this->_errors = $errors ;
	}

}
