<?php namespace Jhul\Core\Application\OutputAdapters\WebPage;

/* @Author : Manish Dhruw [1D3N717Y12@gmail.com]
+=======================================================================================================================
| @Created : Wed 06 Apr 2016 01:59:09 PM IST
+---------------------------------------------------------------------------------------------------------------------*/

class JS
{

	use \Jhul\Core\_AccessKey;

	public $publicJS = [];

	protected $_linked = [] ;

	public function registerPublicJS( $name, $path = [] )
	{
		if( is_array($name) )
		{
			foreach ($name as $key => $value)
			{
				$this->registerpublicJS( $key, $value );
			}

			return;
		}

		$this->publicJS[$name] = $path;
	}

	public function link( $name )
	{
		if( !isset( $this->_linked[$name] ) )
		{
			if( !isset( $this->publicJS[$name] ) )
			{


				throw new \Exception('Public JS '.$name.' not Mapped ', 1);
			}

			$this->_linked[$name] = $this->_link( $this->getApp()->URL().'/'.$this->publicJS[$name].'.js' );
		}
	}

	private function _link( $url )
	{
		return '<script src="'.$url.'"></script>' ;
	}

	public function links()
	{
		return implode( '', $this->_linked );
	}

	public function __toString()
	{
		return $this->links();
	}
}
