<?php namespace Jhul\Components\EX\Sys;

/*
------------------------------------------------------------------------------------------------------------------------
> @ Copyright (c) 2013-2014 Manish Dhruw [ 1D3N717Y12@gmail.com ]

> @ License see LICENSE

> @Author Manish Dhruw [ 1D3N717Y12@gmail.com ]

- Friday 07 March 2014 09:45:13 AM IST
------------------------------------------------------------------------------------------------------------------------
*/

class Page
{



	protected $content ;

	public $layout = 'layout';


	public function encode($text){ return htmlspecialchars($text, ENT_QUOTES, 'UTF-8'); }


	public function cssCode(){ return file_get_contents( $this->resource( 'style', 'css' ) ); }


	public function resource( $file, $ext = 'php' )
	{
		if( strpos($file, '/') === 0 ) return $file ;

		return JHUL_EX_HANDLER_PATH.'/resources/'.$file.'.'.$ext ;
	}


	/* add Raw Content */
	public function addContent( $content ) { $this->content .= $content ; }

	private function _render( $file, $params = array() )
	{
		ob_start();
		extract( $params, EXTR_OVERWRITE );
		require( $file );
		return ob_get_clean();
	}

	public function render( $file, $params = array() )
	{
		$this->content .= $this->_render( $this->resource( $file ) , $params );
	}

	public function snaps( $frames, $frameHeight = 3 )
	{


		$html = '';

		foreach( $frames as $frame )
		{

			if( !file_exists( $frame['file'] ) )
			{
				     return '';

			}


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

	public function display()
	{
		$params =
		[

			'title'		=> 'Error',

			'content'	=> $this->content,

			'cssCode'	=> $this->cssCode().' '.$this->_render( $this->resource('prism', 'css') ),

			'javaScript'	=> $this->_render( $this->resource('prism', 'js') ),
		];


		if( $this->layout != null )
		{
			$this->content = $this->_render( $this->resource( $this->layout ), $params );
		}

		echo $this->content ;
	}

	public static function I()
	{
		return new static();
	}
}
