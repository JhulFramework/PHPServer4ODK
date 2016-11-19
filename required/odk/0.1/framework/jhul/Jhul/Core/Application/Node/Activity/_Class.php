<?php namespace Jhul\Core\Application\Node\Activity;

abstract class _Class
{
	use \Jhul\Core\_AccessKey;

	abstract function cookWebpage();

	public function dump( $data )
	{
		ob_start();

		echo __LINE__.'---'.__FILE__.'<pre>';
		var_dump( $data );
		echo '</pre>';

		$str = ob_get_clean();

		return $this->getApp()->outputAdapter()->addContent( $str );
	}

	public static function I()
	{
		return new static();
	}

	public function cook( $name, $params = [] )
	{
		return $this->getApp()->outputAdapter()->cook( $name, $params );
	}
}
