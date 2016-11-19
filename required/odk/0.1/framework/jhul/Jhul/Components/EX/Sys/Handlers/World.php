<?php namespace Jhul\Components\EX\Sys\Handlers ;

/*
------------------------------------------------------------------------------------------------------------------------
> @Author manish dhruw < 1D3N717Y12@gmail.com >


- Saturday 08 March 2014 09:00:21 PM IST
------------------------------------------------------------------------------------------------------------------------
*/

class World extends Handler{ public function handle( $exception ) { return $this->html()->render( 'world' ) ; } }
