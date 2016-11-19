<?php namespace _modules\main\models\form\Data;

class Content  extends \Jhul\Components\Database\Store\Data\_Class
{
	use \Jhul\Components\Database\Store\Data\_WriteAccessKey;

	protected $_name;

	protected $_asArray;

	protected $_asXML;

	public function setName( $name ) { $this->_name = $name; }

	public function name(){ return $this->_name ; }

	public function storeClass()
	{
		return __NAMESPACE__.'\\Store';
	}


	public function asArray()
	{
		if( empty( $this->_asArray ) )
		{
		 	$this->_asArray = unserialize( $this->read('content') );
		}

		return $this->_asArray;
	}

	public function asXML()
	{
		if( empty( $this->_asXML ) )
		{
			$this->_asXML = $this->J()->cx('x2h')->arrayToXML( '<nm id="'.$this->name().'" ></nm>', $this->asArray() );
		}

		return $this->_asXML;
	}

	public function raw()
	{
		return $this->read('content');
	}

	public function accessMode()
	{
		return 's';
	}

	public function queryParams()
	{
		return [ 'select' => '*' ];
	}

}
