<?php namespace Jhul\Components\Database\Design\Entity;

/* @Author : Manish Dhruw [ 1D3N717Y12@gmail.com ]
+=====================================================================================================================
| @Created : 2016-August-13
+--------------------------------------------------------------------------------------------------------------------*/

interface _Interface
{
	public function context();

	//Check if this entity has field
	public function has( $field );

	public function hasWriteAccess();

	// retursn the primary key value of this record entity
	public function ik();



	public function queryParams();

	public function read(  $field, $byPass = FALSE );
	public function write( $field, $value, $byPass = FALSE );

	public function store();

	public function tableClass();
}
