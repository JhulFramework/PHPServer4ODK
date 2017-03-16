<?php namespace Jhul\Components\Cache;

class Cache
{
	use \Jhul\Components\Application\Traits\Application_Access;

	protected $_pool;

	protected $dir = 'cache';

	function cachePath()
	{
		return $this->getApp()->publicRoot().'/'.$this->dir;
	}

	function get( $itemPath )
	{
		return $this->getItem( $itemPath )->get();
	}

	function set( $itemPath, $data )
	{
		$this->pool()->save( $this->getItem( $itemPath )->set($data) );
	}

	function getItem( $itemPath )
	{
		return $this->pool()->getItem( $itemPath );
	}


	function pool()
	{
		if( empty($this->_pool) )
		{
			// Create Driver with default options
			$driver = new \Stash\Driver\FileSystem( ['path'=> $this->cachePath() ] ) ;

			// Inject the driver into a new Pool object.
			$this->_pool = new \Stash\Pool($driver);
		}

		return $this->_pool;
	}
}
