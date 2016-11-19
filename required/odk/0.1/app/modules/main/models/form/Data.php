<?php namespace _modules\main\models\form;

class Data  extends \Jhul\Components\Database\Store\Data\_Class
{
	use \Jhul\Components\Database\Store\Data\_WriteAccessKey;

	public function editorClass()
	{
		return __NAMESPACE__.'\\_Editor';
	}

	public function storeClass()
	{
		return __NAMESPACE__.'\\Store';
	}

	public function name()
	{
		return $this->read('name');
	}

	public function accessMode()
	{
		return 's';
	}

	public function queryParams()
	{
		return [ 'select' => '*' ];
	}

	protected $_content;

	public function content()
	{
		if( empty( $this->_content ) )
		{
			$this->_content = Data\Content::I()->store()->byIk( $this->ik() )->fetch();
		}

		return $this->_content;
	}

	public function url()
	{
		return $this->getApp()->url().'/data/'.$this->ik();
	}
}
