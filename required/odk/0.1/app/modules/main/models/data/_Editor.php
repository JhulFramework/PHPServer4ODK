<?php namespace _modules\main\models\data;

class _Editor extends \Jhul\Components\Database\Store\Data\Editor
{
	protected function beforeCreate()
	{
		$time  = $this->J()->cx('time')->make( time() );

		$this->write( 'year', (int) $time->year('Y') );
		$this->write( 'month', (int) $time->month('m') );
		$this->write( 'day', (int) $time->day('j') );
		$this->write( 'created', (int) $time->value() );
	}

}
