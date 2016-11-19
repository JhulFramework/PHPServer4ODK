<?php namespace Jhul\Components\Database\Design\Data;

/* @Author : Manish Dhruw [ 1D3N717Y12@gmail.com ]
+=====================================================================================================================
| @Created : 2016-Sepotember-04
+--------------------------------------------------------------------------------------------------------------------*/

abstract class _Static
{

	use \Jhul\Core\_AccessKey;

	public $sql;

	abstract public function storeName();
	abstract public function identityKeyName();



	public function inflators() { return []; }

	public function elementMap(){ return []; }



	private function _r( $field )
	{
		if( array_key_exists( $field, $this->persistentData() ) ) return $this->persistentData()[ $field ] ;

		\Jhul::I()->com('XHelper')->show( 'ERROR_COLUMN_NOT_SELECTED', [ 'column' => $field ], $this );
	}

	//@param $direct to byPass getter method
	//NOTE Maybe save decoded fields
	private function _inflate( $field, $byPass = FALSE )
	{

		if( !$byPass && isset( $this->inflators()[$field] ) )
		{
			$inflator = $this->inflators()[$field] ;

			if( method_exists( $this, $inflator ) ) return $this->$inflator( $value, $field ) ;

			throw new \Exception(' Direct access is disabeld for field "'.$field.'" in ActiveModel "'.$this->store()->name() .'" ');
		}

		return $this->_r( $field );
	}

	public function read( $field, $byPass = FALSE )
	{
		if( $this->has($field) )
		{
			return $this->_inflate( $field, $byPass );
		}

		throw new \Exception( 'Field name "'.$field.'" not found for DB table '.$this->store()->name()  );
	}

	public function RDBEManagerClass()
	{
		return __NAMESPACE__.'\\RDBEManager';
	}



	//We will prepare group accorfidng to context of this enetity, and store the group
	public function group()
	{
		$key = $this->entityContextKey();

		if( !$this->getDatabase()->has( $key ) )
		{
			$tableClass = static::tableClass();

			$this->getDatabase()->add( $key, new $tableClass( $this ) );
		}

		return $this->getDatabase()->get( $key );
	}
}
