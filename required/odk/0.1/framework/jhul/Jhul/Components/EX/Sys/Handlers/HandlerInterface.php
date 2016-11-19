<?php namespace Jhul\Components\EX\Sys\Handlers ;

/*
------------------------------------------------------------------------------------------------------------------------
> @Author manish dhruw < 1D3N717Y12@gmail.com >
- Wednesday 05 February 2014 11:54:02 AM IST
------------------------------------------------------------------------------------------------------------------------
*/

interface HandlerInterface
{
	public function handle( $exception );

	public function setException( $exception );

	/* Returns Exception */
	public function exception();
}
