<?php namespace Jhul\Components\EX ;

/*
------------------------------------------------------------------------------------------------------------------------
> @ Copyright (c) 2013-2014 Manish Dhruw [1D3N717Y12@gmail.com ]

> @ License see LICENSE

> @Author manish dhruw < 1D3N717Y12@gmail.com >

- Wrapper class for real handler
- Since we may use this class to throw exceptions we must use itself as Actual Exception Handler
- Thursday 06 March 2014 04:03:46 PM IST
------------------------------------------------------------------------------------------------------------------------
*/

defined('JHUL_EX_HANDLER_PATH') or define( 'JHUL_EX_HANDLER_PATH', __DIR__ );

class EX extends Sys\_Core
{
	const VERSION = '1.3' ;
}
