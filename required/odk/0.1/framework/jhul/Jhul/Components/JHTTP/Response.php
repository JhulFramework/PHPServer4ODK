<?php namespace Jhul\Components\JHTTP;


class Response extends \Symfony\Component\HttpFoundation\Response
{

	protected $_ifStatusCodeSet = FALSE ;

	public function ifStatusCodeSet()
	{
		return $this->_ifStatusCodeSet;
	}

	public function setStatusCode( $code, $text = NULL )
	{
		$this->_ifStatusCodeSet = TRUE;

		parent::setStatusCode( $code, $text );
	}
}
