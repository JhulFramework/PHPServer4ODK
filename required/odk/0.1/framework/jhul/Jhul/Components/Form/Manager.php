<?php namespace Jhul\Components\Form;

// Created:2017-02-01
// For generating form tokens and implimenting brute force defense,
// unique for keys are required, which is managed by this class
// BETA NOT IN USE
class Manager
{
	//@Structure: [ formKey => formClass ]
	protected $_forms = [];

	//@Structure: [ formName => formKey ]
	protected $_formNames=[];

	public function register( $name, $form = [] )
	{
		if( is_array($name) )
		{
			foreach ( $name as $n => $f)
			{
				$this->register( $n, $f );
			}
			return;
		}

		if( empty($key) )
		{
			throw new \Exception( 'Key form form "'.$key.'" must not be empty' , 1);
		}

		if( isset($this->_forms[$key]) && $this->_forms[$key] != $form['class'] )
		{
			throw new \Exception( 'Form key "'.$key.'" is already registered for form "'.$this->_forms[$key].'" and cannot be registered to "'.$form['class'].'" ' , 1 );
		}
	}
}
