<?php namespace Jhul\Components\Database\Store\Data;

/* @Author : Manish DHruw [1D3N717Y12@gmail.com]
+-----------------------------------------------------------------------------------------------------------------------
| @Created : 2017-01-07
+=====================================================================================================================*/

abstract class _Class_L10N extends _Base
{
	protected $_l10n;

	public function __construct( $l10n )
	{
		if( empty($l10n) )
		{
			throw new \Exception('Language code must not be empty', 1);

		}
		$this->_l10n = $l10n ;
	}

	public function _l10n(){ return $this->_l10n; }

	public function _l10n_iso(){ return  $this->getApp()->lipi()->get( $this->_l10n, 'iso6393' ) ; }

	public static function I( $l10n )
	{
		return new static( $l10n ) ;
	}

	//dispenser
	public static function D( $l10n )
	{
		$item = new static( $l10n );

		return $item->getDatabase()->dispenser( $item );
	}
}
