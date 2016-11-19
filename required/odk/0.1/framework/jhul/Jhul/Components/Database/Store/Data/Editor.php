<?php namespace Jhul\Components\Database\Store\Data;

/* @Author : Manish DHruw [1D3N717Y12@gmail.com]
+-----------------------------------------------------------------------------------------------------------------------
| @Created : 2016-August
|
+-IMPORTANT
| - After Committing _modified_data it is imporant to update persistData, since entity maynot be reloaded, and may contain
|   old values
|
| @Modified : 2016-September-04
|
+=====================================================================================================================*/

class Editor
{

	use \Jhul\Core\_AccessKey;

	// new records are those which are not yet saved in database
	private $_isNewRecord = TRUE;

	protected $_modified_data = [];

	protected $_old_data = [];

	protected $_callingDeflator = [];


	protected $_entity;

	protected function callBefore( $method )
	{
		$method = 'before'.$method;

		if( method_exists($this, $method ) )
		{
			$this->$method();
		}
	}

	protected function callAfter( $method )
	{
		$method = 'after'.$method;

		if( method_exists($this, $method ) )
		{
			$this->$method();
		}
	}

	public function __construct( $entity )
	{
		$this->_entity = $entity;
	}

	public function delete()
	{
		$this->callBefore('delete');
		$this->entity()->store()->delete( $this->entity()->ik() );
		$this->callAfter('delete');
	}

	//public function encode( $string ) { return htmlspecialchars( $string, ENT_QUOTES, 'utf-8' ); }

	protected function entity()
	{
		return $this->_entity;
	}

	private function create()
	{
		$this->callBefore('create');

		$ik = $this->store()->insert( $this->_modified_data );

		$newItem = $this->store()->byIK( $ik )->fetch();

		foreach ( $newItem->persistentData() as $key => $value)
		{
			$this->entity()->_updatePersistentData( $key, $value );
		}

		$this->callAfter('create');

		return TRUE;
	}

	//Move data in temp to persistent storage
	private function _moveData()
	{
		//registering old values
		$this->_old_data = $this->persistentData();

		//IMPORTANT
		foreach( $this->_modified_data as $key => $value )
		{
			//updating new values
			$this->entity()->_updatePersistentData( $key, $value );
		}
	}

	public function commit()
	{
		$this->callBefore('commit');

		if( $this->_commit() )
		{
			$this->callAfter('commit');

			return TRUE;
		}
	}

	final protected function _commit()
	{
		return $this->entity()->isPersistent() ?  $this->update() : $this->create() ;
	}

	// value CHANGED but NOT COMMITTED
	public function isDataModified( $field )
	{
		foreach ($this->_modified_data as $key => $value)
		{
			if( $this->_modified_data[$key] != $this->persistentData()[$key] ) return TRUE;
		}

		return FALSE;
	}

	//value CHANGED AND COMMITTED
	public function ifDataChanged( $field )
	{
		foreach ($this->_old_data as $key => $value)
		{
			if( $this->_old_data[$key] != $this->persistentData()[$key] ) return TRUE;
		}

		return FALSE;
	}

	// value CHANGED but NOT COMMITTED
	public function ifValueModified( $field )
	{
		return array_key_exists( $field, $this->_modified_data ) && ( $this->_modified_data[$field] != $this->persistentData()[$field] );
	}

	//value CHANGED AND COMMITTED
	public function ifValueChanged( $field )
	{
		return array_key_exists( $field, $this->_old_data )&& ( $this->_old_data[$field] != $this->persistentData()[$field] );
	}

	private function persistentData()
	{
		return $this->entity()->persistentData();
	}


	// values of tmp fields MUST be synced after UPDATE
	private function update()
	{
		$this->callBefore('update');
		$this->store()->updateRow( $this->entity()->ik(), $this->_modified_data ) ;
		$this->_moveData();
		$this->callAfter('update');
	}

	public function store()
	{
		return $this->entity()->store();
	}


	final public function write( $field, $value, $byPass = FALSE )
	{
		if( $this->entity()->has($field) )
		{
			$this->_modified_data[$field] = $byPass ? $value : $this->_deflate( $field, $value, $byPass ) ;

			return $this;
		}

		throw new \Exception( 'DATABASE ERROR : Column "'.$field.'" Not Found In Table "'.$this->store()->name().'" in database "'.$this->store()->database()->name().'" '  );
	}

	protected function _deflate( $field, $value, $byPass = FALSE )
	{

		$deflators = $this->deflators();

		if(  isset( $deflators[$field] ) )
		{
			$deflator = $deflators[$field] ;

			if( isset( $this->_callingDeflator[$deflator] ) )
			{
				throw new \Exception('Pass third argumnet TRUE when calling "write()" inside method "'.get_called_class().'::'.$deflator.'" ', 1);

			}

			if( method_exists( $this, $deflator ) )
			{
				$this->_callingDeflator[ $deflator ] =  $field;

				$data = $this->$deflator( $value, $field ) ;

				unset( $this->_callingDeflator[ $deflator ] );

				return $data;
			}

			throw new \Exception('Direct setting is disabled for field "'.$field.'" in ActiveModel "'.get_called_class().'" ');
		}

		$deflators = [];

		if( $this->entity()->hasDeflators() && method_exists( $this->entity(), 'deflators' ) )
		{
			$deflators = $this->entity()->deflators();
		}

		if(  isset( $deflators[$field] ) )
		{
			$deflator = $deflators[$field] ;

			if( isset( $this->_callingDeflator[$deflator] ) )
			{
				throw new \Exception('Pass third argumnet TRUE when calling "write()" inside method "'.get_class($this->entity()).'::'.$deflator.'" ', 1);
			}

			if( method_exists( $this->entity(), $deflator ) )
			{
				$this->_callingDeflator[ $deflator ] =  $field;

				$data = $this->entity()->$deflator( $value, $field ) ;

				unset( $this->_callingDeflator[ $deflator ] );

				return $data;
			}

			throw new \Exception('Direct setting is disabled for field "'.$field.'" in ActiveModel "'.get_class( $this->entity() ).'" ');
		}

		return $value;

	}


	// Defiene method here to encode values before inserting it into database
	protected function deflators() { return []; }

}
