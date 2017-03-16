<?php namespace Jhul\Components\Database\Store\Data;

/* @Author : Manish Dhruw [ 1D3N717Y12@gmail.com ]
+=====================================================================================================================
| @Created : 2016-August-13
+--------------------------------------------------------------------------------------------------------------------*/

interface _Interface
{
	public function context();

	//Check if this entity has field
	public function has( $field );

	//Check if this entity has field
	public function hasAccessToColumn( $field );

	public function hasWriteAccess();

	// retursn the primary key value of this record entity
	public function key();

	public function keyName();

	public function read(  $field );

	public function store();

	public function storeClass();
}
