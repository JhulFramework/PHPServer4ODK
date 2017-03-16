<?php namespace Jhul\Core\Application;


class ConfigLoader
{
	use \Jhul\Core\_AccessKey;

	public function load( &$obj )
	{
	 	$this->_configure( $obj );

		$this->mapResources( $obj->path() );
	}

	public function registerPages( $path, $namespace = NULL )
	{
		$this->getApp()->mPage()->register
		(
			$this->loadConfigFile( $path.'/config/_pages', FALSE ),

			$namespace
		);
	}

	public function registerHandlers( $path, $namespace = NULL )
	{

		$this->getApp()->mHandler()->register
		(
			$this->loadConfigFile( $path.'/config/_handlers', FALSE ),

			$namespace
		);
	}

	protected function _configure( &$obj )
	{
		//$module->_s( 'path', $this->J()->fx()->dirPath( $module->getClass() ) );

		$obj->config()->add
		(
			$this->loadConfigFile( $obj->path().'/config/_main', FALSE )
		);

		// $this->getApp()->mHandler()->register
		// (
		// 	$obj->name(),
		// 	$this->loadConfigFile( $obj->path().'/config/_handlers', FALSE )
		// );

		$this->getApp()->mDataType()->register
		(
			$this->loadConfigFile( $obj->path().'/datatypes/_datatypes', FALSE )
		);

		$obj->elementMap = $this->loadConfigFile( $obj->path().'/config/elements/_map', FALSE );
	}


	public function mapResources( $path )
	{
		$res = $this->loadConfigFile( $path.'/res/_res' );


		if( $this->getApp()->user()->isWebPageConsumer()  )
		{
			if( isset( $res['templates'] ) )
			{
				$this->getApp()->response()->page()->mTemplate()->register
				(
					$this->loadConfigFile( $res['templates'] ), NULL, $res['templates']
				);
			}

			if( isset($res['styles']) )
			{
				$this->getApp()->response()->page()->mStyle()->register
				(
					$this->loadConfigFile( $res['styles'] ), NULL, $res['styles']
				);
			}
		}

		if( isset( $res['i18n'] ) )
		{
			$this->getApp()->lipi()->register( $this->loadConfigFile( $res['i18n']  ) );
		}
	}

	protected function loadConfigFile( $file, $required = TRUE )
	{
		return $this->J()->fx()->loadConfigFile( $file, $required );
	}

}
