<?php namespace Jhul\Components\Database\Store\Data;

/* @Author : Manish Dhruw [ 1D3N717Y12@gmail.com ]
+=====================================================================================================================
| @Created Saturday 15 February 2014 10:35:28 AM IST
|
| -Does not validates internally
|
| @Updated
| -Saturday 03 January 2015 06:17:04 PM IST
| -Thursday 09 April 2015 04:14:58 PM IST
| -2016-July-07
| -2016-August-[ 06, 13 ]
| -2016-September-04
| TODO  encode data before storing in database, to avoid encode on each request, appears safe and effecient
+--------------------------------------------------------------------------------------------------------------------*/

abstract class _Class
{

	use \Jhul\Core\_AccessKey;

	const VERSION = '0.8';


	// hold the value from database table  */
	protected $_persistent_data = [];

	protected $_inflated_data = [];

	protected $_executedQuery;

	abstract public function accessMode();

	abstract public function queryParams();

	abstract protected function storeClass();


	public function afterLoading(){}

	public function databaseIK()
	{
		return 'default';
	}

	public function hasDeflators() { return FALSE; }

	public function hasWriteAccess() { return FALSE; }

	public static function I( $params = NULL ) { return new static( $params ); }

	protected function getDatabase() { return $this->J()->cx('database')->get( $this->databaseIK() ) ; }



	public function ifEmpty( $field )
	{
		return empty( $this->read($field) );
	}

	public function isNull(){ return FALSE ;}

	//this method can be used to prepare raw data before access
	// primary key value of self
	//returns the value of primaryKey
	public function ik()
	{
		return isset( $this->_persistent_data[ $this->identityKeyName()  ] ) ? $this->_persistent_data[  $this->identityKeyName() ] : NULL ;
	}

	//key of identity key
	public function identityKeyName()
	{
		return $this->store()->itemKeyName();
	}

	//If Has Field
	public final function has( $name ){ return $this->store()->hasField( $name ) ; }

	public function persistentData()
	{
		return $this->_persistent_data;
	}

	public function inflatedData()
	{
		return $this->_inflated_data;
	}

	// @Param $data : from database
	// @Param $sql : used sql to load this data from database
	public function _populate( array $data, $sql )
	{

		$this->_persistent_data = $data ;

		$this->_executedQuery = $sql ;

		$this->afterLoading();

		return $this;
	}

	public function read( $field, $byPass = FALSE )
	{

		if( array_key_exists( $field, $this->inflatedData() ) )
		{
			return $this->inflatedData()[$field];
		}

		if( array_key_exists( $field, $this->persistentData() ) )
		{
			$value = $this->persistentData()[ $field ] ;

			$this->_inflated_data[$field] = $byPass ? $value : $this->store()->inflate( $value, $field );

			return $this->_inflated_data[$field];
		}

		if( $this->store()->hasField( $field ) )
		{
			$this->J()->showError( 'ERROR_COLUMN_NOT_SELECTED', [ 'column' => $field ], $this );
		}

		$this->J()->showError( 'ERROR_COLUMN_NOT_FOUND', [ 'column' => $field ], $this );
	}

	/* Relative Database Entity Handling
	+================================================================================================================*/

	protected $_RDBEManager;

	//Relative Database Entity Manager
	public function RDBEManager()
	{
		if( empty( $this->_RDBEManager ) )
		{
			$class = $this->RDBEManagerClass();
			$this->_RDBEManager = new $class( $this );
		}

		return $this->_RDBEManager;
	}

	public function RDBEManagerClass()
	{
		return __NAMESPACE__.'\\RDBEManager';
	}


	//We will prepare group accorfidng to context of this enetity, and store the group
	public function store()
	{
		$key = $this->sign();

		if( !$this->getDatabase()->hasStore( $key ) )
		{

			$storeClass = $this->storeClass();

			$this->getDatabase()->addStore( $key, new $storeClass( $this ) );
		}

		return $this->getDatabase()->getStore( $key );
	}

	protected function sign() { return get_called_class().'::'.$this->accessMode() ; }

	public function editor()
	{
		throw new \Exception( 'This DB Ebtity "'.get_called_class().'" has no write access' , 1);
	}

	public function executedQuery()
	{
		return $this->_executedQuery;
	}
}
