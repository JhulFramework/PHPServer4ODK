<?php namespace Jhul\Core\Application\DataType\Types\Image;


class Attribute extends \Jhul\Core\Application\DataType\_Attribute\_Class
{




	public function allowedTypes()
	{
		return [ 'jpg', 'gif', 'png' ];
	}

	public function __construct()
	{
		$this->mErrorCode()->add
		([
			'validateImageType'	=> 'IMAGE_TYPE_FAILED',

			'validateMinSize'		=> 'MIN_SIZE_FAILED',
			'validateMaxSize'		=> 'MAX_SIZE_FAILED',

			'validateMinWidth'	=> 'MIN_WIDTH_FAILED',
			'validateMaxWidth'	=> 'MAX_WIDTH_FAILED',

			'validateMinHeight'	=> 'MIN_HEIGHT_FAILED',
			'validateMaxHeight'	=> 'MAX_HEIGHT_FAILED',

			'validateType'		=> 'IMAGE_FAILED',
		]);


		$this->config()->add
		([
			'definition'		=> 'S=12-1024000:D=1024',
			'required'			=> TRUE,
			'validation_steps'	=> 'type:imageType:minSize:maxSize:minWidth:maxWidth:minHeight:maxHeight',
		]);
	}


	public function definitionEntityClass()
	{
		return __NAMESPACE__.'\\Definition';
	}

	public function valueEntityClass()
	{
		return __NAMESPACE__.'\\Value';
	}

	//Chreck if it png, jpg or gif
	public function validateImageType( $image )
	{
		$image = $this->_make( $image );

		return in_array( $image->type(), $this->allowedTypes() ) ;
	}

	public function prepareValue( $image )
	{
		throw new \Exception("Error Processing Request", 1);

	}

	private function _make( $image )
	{
		return is_string( $image ) ? $this->make( $image, FALSE ) : $image ;
	}

	public function type() { return 'image'; }

	public function validateMinSize( $image )
	{
		if( $this->d()->has('min_size') )
		{
			$image = $this->_make( $image );

		 	return !( $image->size() < $this->d()->get('min_size') ) ;
		}
	}

	public function validateMaxSize( $image )
	{
		if( $this->d()->has('max_size') )
		{
			$image = $this->_make( $image );

		 	return !( $image->size() > $this->d()->get('max_size') ) ;
		}
	}

	public function validateMinWidth( $image )
	{
		if( $this->d()->has('min_width') )
		{
			$image = $this->_make( $image );

		 	return !( $image->width() < $this->d()->get('min_width') ) ;
		}
	}

	public function validateMaxWidth( $image )
	{
		if( $this->d()->has('max_width') )
		{
			$image = $this->_make( $image );

		 	return  !( $image->width() > $this->d()->g('max_width') ) ;
		}
	}

	public function validateMinHeight( $image )
	{
		if( $this->d()->has('min_height') )
		{
			$image = $this->_make( $image );

		 	return !( $image->height() < $this->d()->get('min_height') ) ;
		}
	}

	public function validateMaxHeight( $image )
	{
		if( $this->d()->has('max_height') )
		{
			$image = $this->_make( $image );

		 	return  !( $image->height() > $this->d()->get('max_height') ) ;
		}
	}

	public function validateImage( $image )
	{
		return $this->_make($image)->isImage() ;
	}

	public function validateType( $image )
	{
		return $this->validateImage() && $this->ifImageTypeValid( $image );
	}

}
