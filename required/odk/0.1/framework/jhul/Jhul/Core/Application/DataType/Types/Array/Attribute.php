<?php namespace Jhul\Core\Application\DataType\Types\Array;

/* @Author : Manish Dhriuw [1D3N717Y12@gmail.com]
+=======================================================================================================================
|@Created : 2016-July-24
+---------------------------------------------------------------------------------------------------------------------*/


class DataType extends \Jhul\Core\Application\DataType\_Attribute\_Class
{

	public function valueEntityClass()
	{
		return __NAMESPACE__.'\\Value';
	}

	public function __construct()
	{
		$this->mErrorCode()->add
		([
			'validateRequired'	=> 'VALUE_FAILED',
			'validateExactLength'	=> 'EXACT_LENGTH_FAILED',
			'validateMaxLength'	=> 'MAX_LENGTH_FAILED',
			'validateMinLength'	=> 'MIN_LENGTH_FAILED',
			'validateType'		=> 'TYPE_FAILED',
		]);


		$this->config()->add
		([
			'required'			=> TRUE,
			'validation_steps'	=> 'type:minLength:maxLength',
		]);
	}

	public function make( $value_string  )
	{
		$class = $this->valueEntityClass();

		$value = new $class( $value_string, $this );

		$vMethods = $this->validationSteps();

		foreach ( $vMethods as $vMethod )
		{
			if( FALSE == $this->$vMethod( $value_string ) )
			{
				$value->error()->add( $this->mErrorCode()->get( $vMethod ) );

				return $value;
			}
		}

		return $value;
	}

	public function validateMaxLength( $value )
	{
		if( $this->d()->has('max_length') )
		{
			return mb_strlen( $value, $this->charSet() ) <=  $this->d()->get('max_length') ;
		}

		return TRUE;

	}

	public function validateMinLength( $value )
	{
		if( $this->d()->has('min_length') )
		{
			return mb_strlen( $value, $this->charSet() ) >= $this->d()->get('min_length') ;
		}

		return TRUE;
	}

	public function validateExactLength( $value )
	{
		if( $this->d()->has('exact_length') )
		{
			return mb_strlen( $value, $this->charSet() ) == $this->d()->get('exact_length') ;
		}
		return TRUE;

	}

	public function validateType( $value )
	{
		return is_array( $value );
	}

	public function type(){ return 'string'; }
}
