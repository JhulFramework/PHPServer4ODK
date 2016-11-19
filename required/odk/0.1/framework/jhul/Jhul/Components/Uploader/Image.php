<?php namespace mwapp\components\uploader;

/*----------------------------------------------------------------------------------------------------------------------
 *@author Manish Dhruw <1D3N717Y12@gmail.com>
 
 *@created -Friday 16 January 2015 04:08:13 PM IST-  
----------------------------------------------------------------------------------------------------------------------*/

class Image
{

	private $src;

	private $width;
	
	private $height ;

	private $type;

	private $mime;

	private $size ;

	private $validFlag = FALSE;

	public function __construct( $src )
	{
		$this->src = $src;
		$this->loadImageInfo();
	}

	private function loadImageInfo()
	{
		if( FALSE != ( $info = getimagesize($this->src) ) )
		{
			$this->validFlag = TRUE;
		
			$this->width =  $info[0] ;
		
			$this->height =  $info[1] ;

			$this->type =  $info[2] ;
		
			$this->mime =  $info['mime'] ;
		
			$this->size = filesize( $this->src );
		}
	}

	public function isValid()
	{
		return $this->validFlag ;
	}

	public function width()
	{
		return $this->width;
	}

	public function height()
	{
		return $this->height;
	}

	public function size()
	{
		return $this->size;
	}

	public function type()
	{
		return $this->type;
	}

	public function mime()
	{
		return $this->mime;
	}

	public function src()
	{
		return $this->src;
	}
}
