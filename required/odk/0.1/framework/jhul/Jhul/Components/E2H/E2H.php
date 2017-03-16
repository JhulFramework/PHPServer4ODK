<?php namespace Jhul\Components\E2H ;

/*
# @Author [ beautifulByte@gmail.com ]
*/

class E2H
{
	private  $_m_purn_vowels_II =
	[

		'/0aa/',		'/0ii/',		'/0uu/',		'/0ee/',		'/0oo/',		'/0m2/',	'|o2|',	'|m3|'

	];

	private $_r_purn_vowels_II =
	[

		'आ', 			'ई',			'ऊ',			'ऐ',			'औ',			'अं',		'ॅ',		'ँ',

	];


	private  $_m_start_vowels_II =
	[
		'/\saa/',		'/\sii/',		'/\suu/',		'/\see/',		'/\soo/',		'/\sm2/',	'|\so2|', '|\sm3|'

	];

	private $_r_start_vowels_II =
	[
		' आ', 		' ई',			' ऊ',			' ऐ',			' औ',			' अं',	' अॅ',		' अँ'
	];


	#SET A
	private $_m_start_vowels_I =
	[
		'/\sa/',	'/\si/',	'/\su/',	'/\se/',	'/\so/',	'/\s:/'
	];

	private $_r_start_vowels_I =
	[
		' अ',		' इ',		' उ',		' ए',		' ओ',		' अः'
	];


	#SET A
	private $_m_purn_vowels_I =
	[
		'/0a/',	'/0i/',	'/0u/',	'/0e/',	'/0o/',	'/0:/'
	];

	private $_r_purn_vowels_I =
	[
		'अ',		'इ',		'उ',		'ए',		'ओ',		'अः'
	];




	private $_m_consonents_II =
	[
		'/g2/',		'/d5/',		'/c2/',		'/j2/',		'/n3/',		'/t3/',		'/t4/',		'/d4/',

		'/d3/',		'/n2/',		'/t2/',		'/d2/',		'/b2/',		'/s3/',		'/s2/',		'/c3/',

		'|m2|', 		'|r2|',	 	'|r3|',		'|m3|',		'|g3|', 		'|o2|'
	];

	private $_r_consonents_II =
	[
		'घ', 			'ङ',			'छ',			'झ',			'ञ',			'ट',			'ठ', 			'ड' ,

		'ढ',			'ण',			'थ',			'ध',			'भ',			'ष',			'स',			'क्ष',

		'ं',			'॔', 			'ृ',			'ँ',			'ज्ञ',		'ॅ'
	];



	private $_m_consonents_I =
	[
		'/k/',		'/q/',		'/g/',		'/c/',		'/j/',		'/t/',

		'/d/',		'/n/',		'/p/',		'/f/',		'/b/',		'/m/',

		'/y/',		'/r/',		'/l/',		'/v/',		'/s/',		'/h/',


	];

	private $_r_consonents_I =
	[
		'क',		'ख', 		'ग', 		'च',		'ज',		'त', 		'द', 		'न',		'प',

		'फ', 		'ब',		'म',		'य',		'र',		'ल', 		'व',		'श',		'ह',
	];


	private $_m_vowels_II =
	[
		'/ii/',	'/uu/',	'/ee/',	'/oo/',
	];

	private $_r_vowels_II =
	[
		'ी',		'ू',		'ै',		'ौ',
	];

	private $_m_last_pref =
	[
		'/a/',	'/i/',	'/u/',	'/e/',	'/o/',	'|-|',	'/:/',
	];

	private $_r_last_pref =
	[
		'ा',		'ि',		'ु',		'े',		'ो',		'्', 		'ः',

	];


	public static function I()
	{
		return new static();
	}

	public function convert( $text )
	{
		$text = ' '.strtolower($text); #prefix sapace, for maccthing starting vowels

		$text = preg_replace( $this->_m_start_vowels_II , $this->_r_start_vowels_II, $text );

		$text = preg_replace( $this->_m_start_vowels_I , $this->_r_start_vowels_I, $text );


		$text = preg_replace( $this->_m_purn_vowels_II , $this->_r_purn_vowels_II, $text );

		$text = preg_replace( $this->_m_purn_vowels_I , $this->_r_purn_vowels_I, $text );


		$text = preg_replace( $this->_m_consonents_II , $this->_r_consonents_II, $text );

		$text = preg_replace( $this->_m_consonents_I , $this->_r_consonents_I, $text );

		$text = preg_replace( $this->_m_vowels_II , $this->_r_vowels_II, $text );

		$text = preg_replace( $this->_m_last_pref , $this->_r_last_pref, $text );

		$text = str_replace( '0्', '0-', $text);

		return trim($text);
	}


	public function replace( $match, $replace, $text )
	{
		return preg_replace( '/'.$match.'/', $replace, $text );
	}

	public function vowelMap()
	{
		return require( __DIR__.'/_vowel_map.php' );
	}

	public function consonentMap()
	{
		return require( __DIR__.'/_consonent_map.php' );
	}

	public function extraMap()
	{
		return require( __DIR__.'/_extra_map.php' );
	}

	public function map()
	{
		return
		[
			'vowel' => $this->vowelMap(),
			'consonent' => $this->consonentMap(),
			'extra' => $this->extraMap()
		];
	}

	public function mapJSON()
	{
		$map = new \stdCLass();

		$map->vowels = $this->vowelMap();
		$map->consonents = $this->consonentMap();
		$map->extra = $this->extraMap();

		return $map;
	}

	public function testMap()
	{

		return $this->_testMap( $this->vowelMap() +  $this->consonentMap() + $this->extraMap() ) ;
	}

	private function _testMap( $map )
	{
		$string = '';

		foreach ($map as $value => $key)
		{


			$converted = $this->convert($key);

			$string .= '<br/> ('.$key.'='.$value.') =ConvetedTo=> '.$converted;

			$string .= '<br/> key =>'.$key;
			$string .= '<br/> value =>'.$value;
			$string .= '<br/> Converted =>'.$converted;

			if(  $converted != $value  )
			{
				$string .= ' -WRONG';
			}
			$string .= '<hr/>';
		}

		return $string;
	}

	public function isSingleton()
	{
		return TRUE;
	}
}
