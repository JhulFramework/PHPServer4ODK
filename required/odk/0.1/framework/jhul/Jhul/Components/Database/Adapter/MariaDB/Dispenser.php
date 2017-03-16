<?php namespace Jhul\Components\Database\Adapter\MariaDB;


class Dispenser extends Statement\Types\Select
{

	use \Jhul\Core\_AccessKey;

	protected $_protoType;

	public function __call( $method, $params = [] )
	{
		$method = strtolower($method);

		if( 0 === strpos( $method, 'by' ) )
		{
			$field = substr( $method, 2 );

			if( !$this->protoType()->hasAccessToColumn( $field ) )
			{
				throw new \Exception( 'This entity "'.get_class($this->protoType()).'" cannot access field "'.$field.'" ' , 1);
			}

			array_unshift( $params, $field );

			return call_user_func_array( [$this, 'where' ], $params );

		}

		throw new \Exception( 'Call to undefined method  "'.static::class.': :'.$method.'()"',  1);
	}

	public function __construct( $_protoType )
	{
		$this->_protoType = $_protoType;

		$this->select( $this->_protoType->queryColumns() )->setTable( $this->_protoType->tableName() );
	}

	public function protoType()
	{
		return clone $this->_protoType;
	}

	public function database() { return $this->J()->cx('dbm')->getDB(); }


	public function findByKey( $key )
	{
		if( !empty($key) )
		{
			return $this->byKey( $key  )->fetch();
		}

		return $this->cookItem( NULL, 'find by empty key' );
	}

	public function cookItem( $record, $statementString )
	{
		if( !empty($record) )
		{
			return $this->store()->_callAfter( 'populate',  $this->protoType()->_populate( $record, $statementString ) );
		}

		if( $this->store()->useNULLDataModel() )
		{
			$nullClass = $this->store()->getItemClass('null');
			return new $nullClass( $statementString );
		}
	}

	//public function byParams( $params ) { return $this->qb()->byParams( $params ) ; }

	public  function byKey( $key ) { return $this->where( $this->protoType()->keyName(), $key ); }

	public function store(){ return $this->protoType()->store(); }

	public function findByKeys( $keys )
	{
		if( !empty( $keys) )
		{
			return $this->whereIn( $this->protoType()->keyName(), $keys )->fetchAll();
		}

		return [];
	}
}
