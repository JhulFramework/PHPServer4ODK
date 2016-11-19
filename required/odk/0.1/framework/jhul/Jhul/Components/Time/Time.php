<?php namespace Jhul\Components\Time ;

class Time
{

	public $defaultFormat = 'd M Y';

	public function make( $time )
	{
		return new _Time( $time );
	}
}
