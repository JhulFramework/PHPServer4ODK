<?php namespace Jhul\Components\Parser;

 /* @Authur : Manish Dhruw [saecoder@gmail.com]
+=======================================================================================================================
| By Deafult it not not parse but Html encode parser tags are found
|
| to use markdown one has to use [<m][m>]
| to use BBCODE one has to use [<bbcode][/bbcode]
| TODO use [code=language] For syntac highlighting [/code]
|
| TL;DR
| - <(m) markdown (m}>
| - <(b) bbcode (b)>
| - <(c=php) <?php ?> (c)> TODO
+---------------------------------------------------------------------------------------------------------------------*/


class Parser
{
	protected $_parsedown;


	function encode( $string )
	{
		return htmlspecialchars($string);
	}

	function parse( $string )
	{
		if( FALSE !== strpos( $string, '{m}_' ) &&  strpos( $string, '_{m}' ) )
		{
			$string = $this->parseMD( $string );
		}

		return new Parsed( $string, [], [] );
	}

	function parseMD( $string )
	{
		//preg_match_all("/\<\{m\}(.*?)\{m\}\>/s", $string , $matches );
		preg_match_all('|\{m\}\_(.*?)\_\{m\}|s', $string , $matches );

		foreach ($matches[1] as  $value )
		{
			$search = '{m}_'.$value.'_{m}';
			$string = str_replace( $search, $this->parseDown( $value ), $string );
		}

		return $string;
	}

	function parseDown( $string )
	{
		if( empty( $this->_parsedown ) )
		{
			$this->_parsedown = new \Parsedown();
		}

		return $this->_parsedown->parse($string);
	}

	function isSingleton()
	{
		return TRUE;
	}


}
