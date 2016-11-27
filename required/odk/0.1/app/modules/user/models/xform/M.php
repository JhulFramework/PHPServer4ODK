<?php namespace _modules\user\models\xform;

class M extends \Jhul\Components\Database\Store\Data\_Class
{
	use \Jhul\Components\Database\Store\Data\_WriteAccessKey;

	public function storeClass()
	{
		return __NAMESPACE__.'\\Store';
	}

	public function queryParams()
	{
		return
		[
			'select' => '*',
		];
	}

	public function name()
	{
		return $this->read('name');
	}

	public function url()
	{
		return $this->getApp()->url().'/download/'.$this->ik();
	}

	public function deletionurl()
	{
		return $this->getApp()->url().'/manage_forms/'.$this->ik().'/delete';
	}

	public function rurl()
	{
		return $this->read( 'r_url' );
	}

	public function getContent()
	{
		return file_get_contents( $this->getApp()->url().'/'.$this->rurl() );
	}

	//XForm Version
	public function md5(){ return $this->read('md5') ; }

}
