<?php namespace Jhul\Components\Database\Store;

/* @Author : Manish Dhruw [ 1D3N717Y12@gmail.com ]
+=======================================================================================================================
|
+---------------------------------------------------------------------------------------------------------------------*/

abstract class _Base
{

	use \Jhul\Core\_AccessKey;

	protected $_fields = [];

	// save record to database
	// @return modified datamodel
	// @param $item can be data entity
	private function insert( $item )
	{
		$item = $this->_callBefore( 'insert', $item );

		$this->getDB()->insert( $item );

		$key = $this->getDB()->pdo()->lastInsertId();

		//setting persistent data as old data
		$item->_oData()->_set( $item->_pData()->_get() );

		//setting modified data as persistent data
		$item->_pData()->_set( $item->_mData()->_get() );

		if( $item->_mData()->has( $item->keyName() ) )
		{
			$key = $item->_mData()->read( $item->keyName() );
		}

		$item->_pData()->_set( $item->keyName(), $key );

		return $this->_callAfter( 'insert', $item );
	}

	public function _callBefore( $method, $item )
	{
		$method = 'before'.$method;

		return method_exists( $this, $method ) ? $this->$method( $item ) : $item ;
	}

	public function _callAfter( $method, $item )
	{
		$method = 'after'.$method;

		return method_exists( $this, $method ) ? $this->$method( $item ) : $item ;
	}

	public function commit( $item )
	{
		$item = $this->_callBefore( 'commit', $item );

		$item = $item->isPersistent() ? $this->update($item) : $this->insert( $item ) ;

		return $this->_callAfter( 'commit', $item );
	}

	public function defaultValues(){ return []; }

	//compress or preprocess data befor storing in database
	public function deflateValue( $value, $field )
	{
		if( isset($this->valueDeflaters()[ $field ] )  )
		{
			$deflater = $this->valueDeflaters()[ $field ];

			return $this->$deflater( $value, $field );
		}

		return $value;
	}


	public function delete( $item  )
	{
		$this->_callBefore( 'delete', $item );

		$item->getDB()->_delete( $item );
	}

	public function getNULLItem()
	{
		$class = $this->getItemCLass('null');
		return new $class('null');
	}

	public function getItemCLass( $context )
	{


		if( isset( $this->items()[$context] ) )
		{
			$class = $this->items()[$context] ;

			return is_array( $class ) ? $class['class'] : $class ;
		}

		if( 'null' == $context )
		{
			return '\\Jhul\\Components\\Database\\Store\\Data\\_NULL';
		}

		throw new \Exception( 'Context "'.$context.'" Not Defined In "'.get_called_class().'" ' );
	}




	public function getQueryColumns( $item )
	{
		if( isset( $this->items()[$item->context()]['select'] ) )
		{
			$fields = $this->items()[$item->context()]['select'];

			if( is_array($fields)) return $fields;

			if( strpos( $fields, ':' ) ) return explode( ':', $fields );

			if( $fields == '*' ) return '*';

			return [$fields];
		}

		throw new \Exception( 'No fields selected for context "'.$fields.'" in "'.get_called_class().'" ' , 1);
	}


	public function getDB(){ return \Jhul::I()->cx('dbm')->getDB(); }

	public static function I()
	{
		return \Jhul::I()->cx('dbm')->getStore( get_called_class() );
	}


	//expands data to readable
	public function inflateValue( $value, $field )
	{
		if( isset($this->valueInflaters()[$field] )  )
		{
			$inflater = $this->valueInflaters()[$field];

			return $this->$inflater( $value, $field );
		}

		return $value;
	}

	// - initilize fields of newly created Item
	// - Check if all fields are initilized
	public function initilizeFields( $item, $params )
	{
		foreach ( $this->defaultValues() as $key => $value)
		{
			$item->write( $key, $value );
		}

		foreach ( $params  as $key => $value)
		{
			$item->write($key, $value);
		}

		// //we dont have to check for keyname because they will be auto created
		// foreach ( $item->accessibleColumns()  as $field )
		// {
		// 	if( !$item->has($field) && $field != $item->keyName() )
		// 	{
		// 		throw new \Exception( 'Field "'.$field.'" not initialized for item "'.get_class($item).'" ' , 1);
		// 	}
		// }

		return $item;
	}

	//Updates Already existing recotd
	private function update( $item )
	{
		$item = $this->_callBefore( 'update', $item );

		$this->getDB()->update( $item );

		$item->_oData()->_set( $item->_pData()->_get() );

		$item->_pData()->_set( $item->_mData()->_get() );

		return $this->_callAfter( 'update', $item );
	}

	public function useNULLDataModel(){ return FALSE; }

	public function valueDeflaters(){ return []; }

	public function valueInflaters(){ return []; }

}
