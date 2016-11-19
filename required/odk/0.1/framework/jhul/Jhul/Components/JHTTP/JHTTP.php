<?php namespace Jhul\Components\JHTTP;

 /* @Author : [Manish Dhruw] <1D3N717Y12@gmail.com>
+=======================================================================================================================
|@Created : Friday 22 May 2015 07:10:33 PM IST
|
|@Updated :
|	-Saturday 23 May 2015 08:35:34 AM IST
|	-Tuesday 16 June 2015 04:38:14 PM IST
|	-Tue 05 Apr 2016 02:49:06 PM IST
| 	-2016-october-01
+---------------------------------------------------------------------------------------------------------------------*/

class JHTTP
{

	use \Jhul\Core\Design\Component\_Trait;

	const VERSION = '0.5';

	protected $_Q;
	protected $_R;

	public function Q() { return $this->_Q; }

	public function R(){ return $this->_R; }

}
