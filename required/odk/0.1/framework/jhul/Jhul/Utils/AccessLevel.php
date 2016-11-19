<?php namespace Jhul\Utils;

class AccessLevel
{
	const SWAYAM = 0;
	const CONTACTS = 1;
	const WORLD = 2;

	public static function I()
	{
		return new static();
	}

	public function isValid( $accessLevel )
	{
		return AccessLevel::SWAYAM == $accessLevel || AccessLevel::CONTACTS == $accessLevel ||  AccessLevel::WORLD == $accessLevel ;
	}
}
