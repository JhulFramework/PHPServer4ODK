<?php namespace Jhul\Components\Database;


class _Assembler extends \Jhul\Core\Design\Entity\_Assembler
{
	use \Jhul\Components\Application\_AccessKey;



	public function assemble()
	{

		//registering database Error Troubleshooter
		$this->J()->com('XHelper')->register( __NAMESPACE__.'\\XHelper\\XHelper', 'DB_ERROR_HELPER' );
		return $this->e();
	}
}
