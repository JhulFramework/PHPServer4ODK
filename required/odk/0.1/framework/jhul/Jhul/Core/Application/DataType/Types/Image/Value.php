<?php namespace Jhul\Core\Design\Data\Value\Type\Image ;


class Value extends \Jhul\Core\Design\Data\_Value\_Class implements _Interface
{

	public function __construct( $file, &$dataType )
	{
		if( 0 != $file['error'] )
		{
			$this->addError( 'Error While Uploading Image' );
		}

		$this->_dataType = $dataType;
	}

	protected $_p = [];

	public function height()
	{
		return $this->p('H');
	}

	private function loadImageInfo()
	{
		if( FALSE != ( $info = getimagesize( $this->source() ) ) )
		{
			$this->_p['W'] =  $info[0] ;

			$this->_p['H'] =  $info[1] ;

			$this->_p['T'] =  $info[2] ;

			$this->_p['M'] =  $info['mime'] ;

			$this->_p['S'] = filesize( $this->source() );
		}
	}

	public function mime()
	{
		return $this->_p['M'];
	}

	public function p( $name )
	{
		return isset( $this->_p[$name] ) ? $this->_p[$name] : NULL ;
	}

	public function size()
	{
		return $this->p('S');
	}

	public function source()
	{
		return $this->inputValue();
	}

	public function __toString()
	{
		return $this->inputValue();
	}

	public function type()
	{
		return $this->p('T');
	}

	public function ifIsImage()
	{
		return !empty( $this->_p['T'] );
	}

	public function validate()
	{
		if( $this->ifisImage() )
		{
			$this->clearErrors();

			$validationOrder = $this->attribute()->validationOrder();

			asort( $validationOrder );

			foreach ( $validationOrder as $vMethod => $order )
			{
				if( !$this->attribute()->$vMethod( $this->raw() ) )
				{
					$this->addError( $this->attribute()->errorMessages()[ $vMethod ] );
				}
			}

		}

		return $this->isValid();
	}

	public function width()
	{
		return $this->p('W');
	}

	public function encode64()
	{
		return base64_encode( $this->value() );
	}

	public function embed()
	{
		return 'data:image/'.$this->type().';base64,'.$this->encode64();
	}
}
