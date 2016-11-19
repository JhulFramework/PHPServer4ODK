<?php namespace Jhul\Core\Application\Node\Handler;

abstract class _Class extends \Jhul\Core\Application\Node\_Class
{

	//records the handle
	protected static $_trace;

	public function trace()
	{
		return static::$_trace;
	}

	protected function runActivity( $activity = NULL  )
	{
		return NULL != $activity ? $this->getApp()->runActivity( $activity ) : $this->runLocalActivity() ;
	}

	protected function runLocalActivity( $activity = 'Activity' )
	{
		return $this->runActivity( $this->J()->fx()->getFromNamespace( $activity , get_called_class() ) ) ;
	}


	public function handle( )
	{
		static::$_trace[ $this->current() ] = get_called_class();

		$this->moveToNext();

		//loading if next path
		$this->next();


		if( [] != $this->breadcrumb()  )
		{
			$this->getPage()->breadcrumbs()->add
			(
				$this->getApp()->lipi()->t( $this->breadcrumb()['label'] ),

				$this->breadcrumb()['URL']
			);
		}


		if( $this->ifAutoHandleNextNode &&  NULL != $this->autoNextNodeClass )
		{

			$handler = $this->autoNextNodeClass;

			return $handler::I()->handle();
		}



		if( $this->run() )
		{
			return TRUE;
		}


		if( \Jhul::ifDebugOn() )
		{
			$this->J()->cx('xhelper')->cookMessage( 'ERROR_PATH_HANDLING_FAILED', [], $this );
		}


	}

	protected function autoHandleNextNode()
	{
		if( NULL != $this->next() )
		{
			foreach ( $this->matchNodeNames() as $nodeName => $handler)
			{
				if( $this->next() == $nodeName )
				{
					$handler::I()->handle();
					$this->_ifAutoHandled = TRUE;
				}
			}
		}
	}

	protected function breadcrumb(){ return []; }

	abstract protected function run( );

	//forward to handler
	public function forwardTo( $name )
	{
		return $this->getApp()->mHandler()->handle( $name );
	}

}
