<?php namespace Jhul\Components\EX\Sys;

/*
------------------------------------------------------------------------------------------------------------------------
> @ Copyright (c) 2013-2014 Manish Dhruw [ 1D3N717Y12@gmail.com ]

> @ License see LICENSE

> @Author Manish Dhruw [ 1D3N717Y12@gmail.com ]

- Friday 07 March 2014 09:45:13 AM IST
------------------------------------------------------------------------------------------------------------------------
*/

class Formatter
{

	public function encode($text){ return htmlspecialchars($text, ENT_QUOTES, 'UTF-8'); }

	public function snaps( $frames, $frameHeight = 3 )
	{


		$html = '';

		foreach( $frames as $frame )
		{

			$lines = file($frame['file']);

			array_unshift($lines, 'fix');


			$fromLineNumber = ( $frame['line'] - $frameHeight );

			$length = ( $frameHeight * 2 ) + 1 ;

			$toLineNumber = ( $frame['line'] + $frameHeight ) ;


			if( isset( $lines[$fromLineNumber ] ) )
					$lines = array_slice( $lines, $fromLineNumber, null , true  );

			if( isset($lines[ $toLineNumber ]) ) $lines = array_slice( $lines, 0, $length, true);


			$html .= '<div class = "file">';

			$html .=	'<div class="file-name" >'
					.$this->encode( $frame['file'].':'.$frame['line'] )
					.'</div>';


			foreach($lines as $no => $code )
				$html .= $this->createLine( $no, $code, $no == $frame['line'] );

			$html .= '</div>';
		}

		return $html;
	}


	public function createLine( $no, $code, $match = false )
	{
		$class = $match ? 'main line' : 'line' ;
		return '<span class="'.$class.'" >'.$no.' <code class="language-php">'.$this->encode($code).'</code> </span>';
	}

}
