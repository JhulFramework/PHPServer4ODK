<?php namespace Jhul\Components\Event;

class Event
{

	protected $event = array();

	public function trigger( $eventId )
	{
		if( isset($this->event[$eventId]) )
		{
			call_user_func( $this->event[$eventId] );

		}
	}

	public function add( $eventId, $callable )
	{
		$this->event[$eventId] = $callable ;
	}

	public function has( $eventId )
	{
		return isset( $this->event[$eventId] ) ;
	}


	public function addAll( $events )
	{
		foreach( $events as $eventId => $callable )
		{
			$this->add( $eventId, $callable );
		}
	}

	public function isSingleton()
	{
		return TRUE;
	}
}
