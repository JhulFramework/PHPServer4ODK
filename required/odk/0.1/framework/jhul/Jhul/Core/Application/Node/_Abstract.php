<?php namespace Jhul\Core\Application\Node;

abstract class _Abstract
{

	use \Jhul\Core\_AccessKey ;

	// public function renderAs( $IK, $view, $params = [] )
	// {
	// 	$this->getApp()->page()->loadAs( $IK, $view, $params ) ;
	// }

	public function render( $view, $params = [] )
	{
		$this->getApp()->page()->load( $view, $params ) ;
	}

	public function addJData( $key , $data )
	{
		return $this->J()->com('JData')->add( $key, $data );
	}


	public function data()
	{
		return $this->getApp()->data();
	}

	protected function nodes()
	{
		return $this->getApp()->data()->nodes();
	}

	static function I()
	{
		return new static();
	}

	public function dump( $data )
	{
		ob_start();

		echo __LINE__.'---'.__FILE__.'<pre>';
		var_dump( $data );
		echo '</pre>';

		$str = ob_get_clean();

		return $this->getApp()->page()->addContent( $str );
	}

	public function redirect( $URL )
	{
		$this->getApp()->redirect( $URL );
	}
}
