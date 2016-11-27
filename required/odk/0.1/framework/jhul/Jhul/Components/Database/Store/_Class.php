<?php namespace Jhul\Components\Database\Store;

/* @Author : Manish Dhruw < saecoder@gmail.com >
+=======================================================================================================================
| @Updated
| [
|	Thursday 09 April 2015 04:15:30 PM IST,
| 	Friday 10 April 2015 04:45:28 PM IST,
| 	2016-jun-29,
| 	2016-july-21,
| 	2016-august-06,
|	2016-August-11,
|	2016-Sep-04,
| ];
+---------------------------------------------------------------------------------------------------------------------*/

abstract class _Class
{

	use \Jhul\Core\_AccessKey;



	const VERSION = '0.8' ;


	protected $_data_model;



	// @Structure : [ 'access_mode' => 'entity\\class' ]
	abstract public function dataClasses();

	//Primary key of this table
	abstract public function itemKeyName();

	//Table Name
	abstract public function name();


	public function __construct( $_data_model = NULL )
	{
		$this->_data_model =  $_data_model ;
		$this->_prepare();
	}


	public function where( $key, $value, $rel = '=' )
	{
		return $this->makeSelectStatement()->where( $key, $value, $rel );
	}

	public  function limit( $limit )
	{
		return $this->makeSelectStatement()->limit( $limit );
	}

	public  function byIK( $ik )
	{
		return $this->makeSelectStatement()->where( $this->itemKeyName(), $ik );
	}

	public  function byParams( $params )
	{
		return $this->makeSelectStatement()->byParams( $params ) ;
	}

	private function _cookDataModel( $record, $statementString )
	{
		if( !empty($record) )
		{
			return $this->dataModel()->_populate( $record, $statementString );
		}

		if( $this->useNULLDataModel() )
		{
			$nullClass = $this->getDataCLass('null');
			return new $nullClass( $statementString );
		}
	}

	public function defaultValues() { return []; }

	public function database()
	{
		if( empty($this->_database_ik) )
		{
			$this->_database_ik = $this->_data_model->databaseIK();
		}

		return $this->J()->cx('database')->get( $this->_database_ik );
	}


	//Updates a row by ik
	public function delete( $item_ik )
	{
		return $this->database()->executeStatement
		(
			$this->makeStatement('delete')->where( $this->itemKeyName(),  $item_ik )
		);
	}

	// IMPORTANT : DO NOT MODIFY original data model
	final protected function dataModel( $clone = TRUE )
	{
		return  !$clone ? $this->_data_model : clone $this->_data_model ;
	}


	protected function _dataModel()
	{
		return $this->_data_model;
	}


	public final function fetch( $commandBuilder )
	{
		$pdos = $this->database()->executeStatement( $commandBuilder );

		$record = $pdos->fetch( \PDO::FETCH_ASSOC );

		$pdos = NULL; //NOT tested if it is required

		return $this->_cookDataModel( $record, $commandBuilder->show() );
	}

	public function fetchAll( $statement = NULL )
	{
		if( empty($statement) )
		{
			$statement = $this->makeSelectStatement();
		}

		$rows = $this->database()->executeStatement( $statement )->fetchAll( \PDO::FETCH_ASSOC );

		//$rows = $statement->fetchAll( \PDO::FETCH_ASSOC );

		$queryString = $statement->show();

		$statement = NULL; //NOT tested if it is required

		$records = [];

		foreach( $rows as $row )
		{

			if( !empty($row) )
			{
				$records[] = $this->dataModel()->_populate( $row, $queryString );
			}
		}

		return $records;
	}

	public function getDataCLass( $accessMode )
	{
		if( isset( $this->dataClasses()[$accessMode] ) )
		{
			return $this->dataClasses()[$accessMode] ;
		}

		if( 'null' == $accessMode )
		{
			return '\\Jhul\\Components\\Database\\Store\\Data\\_NULL';
		}

		throw new \Exception( 'No Entity Class is Defined for context "'.$context.'" in  "'.get_called_class().'" ' );
	}

	//TODO CAHE loaded Query params
	public function getQueryParams( $type )
	{
		$queryParams = $this->_dataModel()->queryParams();

		if( isset( $queryParams[$type] ) )
		{
			$q =   $queryParams[$type] ;

			if( is_string($q) && strpos( $q, '|' ) ) return explode( '|', $q );

			return $q;
		}

		throw new \Exception( '"'.$type.'" Query Params are not Defined Entity Class "'.get_class( $this->_dataModel() ).'" ' , 1);
	}

	public function hasField( $column_name )
	{
		return isset( $this->schema()['columns'][$column_name] );
	}

	static function I(  ) { return new static() ;}

	public function inflate( $value, $field )
	{

		if( isset($this->inflators()[$field] )  )
		{
			$inflator = $this->inflators()[$field];

			return $this->$inflator( $value, $field);
		}

		return $value;
	}

	public function inflators(){ return []; }

	public function lastInsertId()
	{
		return $this->_lastInsertId;
	}


	public function schema()
	{
		return $this->database()->tables( $this->name() ) ;
	}

	public function makeStatement( $type )
	{
		return $this->database()->makeStatement( $type  )->setTable( $this ) ;
	}

	public function insert( $data )
	{
		$this->database()->pdo()->beginTransaction();



		$statement =  $this->database()->executeStatement
		(
			$this->makeStatement('insert')->setData( $data )
		);

		if( isset( $data[ $this->itemKeyName() ] ) )
		{
			$ik = $data[ $this->itemKeyName() ];
		}
		else
		{

			$ik = $this->database()->pdo()->lastInsertId();
		}


		$this->database()->pdo()->commit();

		$statement = null;

		return $ik ;

	}

	public function makeSelectStatement()
	{
		return $this->makeStatement('select')->select( $this->getQueryParams('select') );
	}

	//Updates a row by ik
	public function updateRow( $row_ik, $data )
	{
		return $this->database()->executeStatement
		(
			$this->makeStatement('update')->setData( $data )->where( $this->itemKeyName(),  $row_ik )
		);
	}

	//Create New record
	//When createing new record, it is alaways top accessMode mode
	public function make( $p )
	{
		$ik_value = '';

		$this->SAM( 's' );

		$entity = $this->dataModel();

		$params = $this->defaultValues();

		foreach ( $p as $key => $value)
		{
			$params[$key] = $value;
		}

		if(empty($params))
		{
			throw new \Exception( 'Record "'.get_class($entity).'" cannot be created with empty params' , 1);

		}

		foreach ( $params as $key => $value)
		{
			if( $this->itemKeyName() == $key  )
			{
				$ik_value = $value;
			}

			$entity->editor()->write( $key, $value );
		}

		$entity->commit();

		if( !empty( $ik_value ) )
		{
			return $this->byIk( $ik_value )->fetch();
		}

		return $entity;
	}

	//constructor for child
	protected function _prepare()
	{

	}

	//data Set Access Mode
	public function sam( $accessMode, $params = [] )
	{
		if( empty($this->_data_model) || $accessMode != $this->_data_model->accessMode() )
		{
			$cClass = $this->getDataClass( $accessMode );


			if( class_exists($cClass) )
			{
				return $cClass::I( $params )->store();
			}

			throw new \Exception( 'Entity Class "'.$cClass.'" Not Found in "'.get_called_class().'"  ' );
		}

	}

	public function useNULLDataModel(){ return FALSE; }

}
