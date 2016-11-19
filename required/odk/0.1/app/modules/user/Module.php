<?php namespace _modules\user;

class Module extends \Jhul\Core\Application\Module\_Class
{
	protected $_mUser;

	public  function mUser()
	{
		if( empty($this->_mUser) )
		{
			$this->_mUser = new models\MUser;
		}

		return $this->_mUser;
	}

	public function security()
	{
		return $this->J()->cx('security');
	}
}
