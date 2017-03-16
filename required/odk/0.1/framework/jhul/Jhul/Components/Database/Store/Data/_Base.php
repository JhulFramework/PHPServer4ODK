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

abstract class _Base implements _Interface
{

	use \Jhul\Core\_AccessKey;

	protected $_accessibleColumns = [];

	protected $_dataBags = [];

	protected $_executedQuery;

	protected $_inflated = [];

	protected $_queryColumns = [];

	abstract public function context() ;

	abstract public function keyName() ;

	abstract public function storeClass();

	abstract public function tableName() ;

	public function getDB() { return $this->J()->cx('dbm')->getDB(); }

	public function getDataBag( $name )
	{
		if( !isset( $this->_dataBags[ $name ]  ) )
		{
			$this->_dataBags[$name] = new DataBag( $this );
		}

		return $this->_dataBags[$name];
	}

	public function has( $field ){ return $this->_pData()->has($field); }

	public function hasWriteAccess() { return FALSE; }

	public function ifEmpty( $field, $silent )
	{
		return empty( $this->read($field, $silent) );
	}

	//if its nul Data model
	public function isNull(){ return FALSE ;}

	public function key()
	{
		return $this->_pData()->read( $this->keyName() );
	}


	//Persitent Data (committed to the database)
	public function _pData(){ return $this->getDataBag('persistent'); }

	// @Param $data : from database
	// @Param $sql : used sql to load this data from database
	public function _populate( array $data, $sql )
	{
		$this->_pData()->_set( $data );

		$this->_executedQuery = $sql ;

		return $this;
	}

	public function read( $field, $silent = FALSE )
	{
		if( isset( $this->_prepared[$field] ) ) return $this->_prepared[$field];

		// pass to custom datareader
		if( isset( $this->readHandlers()[ $field ] ) && !$byPass )
		{
			$readHandler = $this->readHandlers()[ $field ];

			$this->_prepared[$field] = $this->$readHandler( $this->_read( $field, $silent ) );
		}

		$this->_prepared[$field] = $this->store()->inflateValue( $this->_read($field), $field );

		return $this->_prepared[$field];
	}

	//returns encoded value
	public function _read( $field, $silent = FALSE )
	{
		if( $this->hasAccessToColumn( $field )  )
		{
			return $this->_pData()->read( $field );
		}

		if( !$silent )
		{
			throw new \Exception( 'ERROR_NO_READ_ACCES to field "'. get_called_class().'::'.$field.'" ' , 1);
		}

		return NULL;
	}

	protected function readHandlers(){ return []; }

	public function store()
	{
		return $this->J()->cx('dbm')->getStore( $this->storeClass() );
	}

	public function accessibleColumns()
	{
		if( '*' == $this->queryColumns() )
		{
			if( empty($this->_accessibleColumns) )
			{
				$this->_accessibleColumns =  $this->getDB()->getTableColumns( $this->tableName() );
			}

			return $this->_accessibleColumns;
		}

		return $this->queryColumns();
	}


	public function queryColumns()
	{
		if( empty($this->_queryColumns) )
		{
			$this->_queryColumns = $this->store()->getQueryColumns( $this );
		}

		return $this->_queryColumns;
	}

	public function hasAccessToColumn($key)
	{
		if( '*' == $this->accessibleColumns() ) return TRUE;

		return in_array( $key, $this->accessibleColumns() );
	}



	public function executedQuery(){ return $this->_executedQuery; }

	public function write( $key, $value )
	{
		throw new \Exception( 'This DB Enitity "'.get_called_class().'" has no write access' , 1);
	}

	public function _write( $key, $value )
	{
		throw new \Exception( 'This DB Enitity "'.get_called_class().'" has no write access' , 1);
	}
}
