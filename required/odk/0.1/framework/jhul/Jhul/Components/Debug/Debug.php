<?php namespace Jhul\Components\Debug ;

class Debug
{
	private $_ubench;

	function uBench()
	{
		if( $this->_ubench == null )
		{
			$this->_ubench = new Ubench;
		}
		return $this->_ubench;
	}

	function output()
	{
		$this->uBench()->start(JHUL_START_TIME)->end();
		return "<br/>time -- ".$this->uBench()->getTime()."<br/> memory -- ". $this->uBench()->getMemoryPeak(). "<br/>";
	}

	function kintDump( $data )
	{
		require_once( __DIR__.'/kint/Kint.class.php' );

		\Kint::dump($data);

	}

	function isSingleton()
	{
		return TRUE;
	}
}
