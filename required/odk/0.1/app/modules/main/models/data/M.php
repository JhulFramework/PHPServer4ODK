<?php namespace _modules\main\models\data;

class M  extends \Jhul\Components\Database\Store\Data\_Class
{
	use \Jhul\Components\Database\Store\Data\_WriteAccessKey;

	public function tableName()
	{
		return 'submitted_data';
	}

	public function keyName()
	{
		return 'identity_key';
	}

	public function storeClass()
	{
		return __NAMESPACE__.'\\Store';
	}

	public function name()
	{
		return $this->read('name');
	}

	public function context()
	{
		return 'write';
	}

	protected $_content;

	public function content()
	{
		if( empty( $this->_content ) )
		{
			$this->_content = content\M::D()->byKey( $this->key() )->fetch();

			if( !empty($this->_content) )
			{
				$this->_content->setName( $this->name() );
			}
		}

		return $this->_content;
	}

	public function url()
	{
		return $this->getApp()->url().'/data/'.$this->key();
	}

	public function xmlUrl()
	{
		return $this->url().'/?download=xml';
	}

	public function jsonUrl()
	{
		return $this->url().'/?download=json';
	}

}
