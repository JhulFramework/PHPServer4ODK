<?php namespace Jhul\Core\Application;


class ConfigLoader
{
	use \Jhul\Core\_AccessKey;

	public function load( &$obj )
	{
		$this->J()->cx('classmapper')->register
		(
			$this->loadConfigFile( $obj->path().'/config/_class_map', FALSE )
		);

	 	$this->_configure( $obj );

		$this->mapResources( $obj->path() );
	}

	protected function _configure( &$obj )
	{
		//$module->_s( 'path', $this->J()->fx()->dirPath( $module->getClass() ) );

		$obj->config()->add
		(
			$this->loadConfigFile( $obj->path().'/config/_main', FALSE )
		);

		$this->getApp()->mActivity()->register
		(
			$obj->name(),
			$this->loadConfigFile( $obj->path().'/config/_activities', FALSE )
		);

		$this->getApp()->mHandler()->register
		(
			$obj->name(),
			$this->loadConfigFile( $obj->path().'/config/_handlers', FALSE )
		);

		$this->getApp()->mDataType()->register
		(
			$this->loadConfigFile( $obj->path().'/datatypes/_datatypes', FALSE )
		);

		$obj->elementMap = $this->loadConfigFile( $obj->path().'/config/elements/_map', FALSE );
	}


	public function mapResources( $path )
	{
		$res = $this->loadConfigFile( $path.'/res/_res' );


		if( $this->getApp()->endUser()->ifConsumes( 'webpage' )  )
		{

			if( isset( $res['templates'] ) )
			{
				$this->getApp()->outputAdapter()->mTemplate()->register
				(
					$this->loadConfigFile( $res['templates'] ), NULL, $res['templates']
				);
			}


			if( isset($res['styles']) )
			{
				$this->getApp()->outputAdapter()->mStyle()->register
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
