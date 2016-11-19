<?php namespace Jhul\Core;

use \Jhul\Components\EX\EX ;

class _Assembler
{
	public static function I()
	{
		return new static();
	}

	public function assemble( &$j )
	{

		//Settting up Exception Handler
		$j->s( 'ex', EX::I() );

		if( JHUL_ENABLE_EX_HANDLER )
		{
			if( JHUL_IF_ENABLE_DEBUG )
			{
				$j->ex()->setDebug( TRUE );
			}

			$j->ex()->activate();

			if( JHUL_DISABLE_FRAMEWORK_ERROR === TRUE) $this->ex()->removeTracesFrom( JHUL_FRAMEWORK_PATH );
		}


		//Settting up FileSystem
		$j->s( 'fx' ,  new FX ) ;

		$j->fx()->add( 'Jhul', JHUL_FRAMEWORK_PATH.'/Jhul' ) ;

		// // //Setting up Config Container
		// $j->s( 'mBag', new Bags\Manager );

		//Setting up Component Loader
		$j->s( 'cx', new CX );
	}


}
