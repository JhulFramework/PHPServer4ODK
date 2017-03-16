<?php namespace Jhul\Components\Database\Traits;

/* @Author : Manish DHruw [1D3N717Y12@gmail.com]
+-----------------------------------------------------------------------------------------------------------------------
| IMPORTANT
| After Committing _newData it is imporant to update persistData, since entity maynot be reloaded, and may contain old values
+=====================================================================================================================*/
//after commit we should refresh  _data with newly acommitted data , since the class is not reloaded //IMPORTANT

trait Write_Access
{

	// new records are those which are not yet saved in database
	private $_isNewRecord = TRUE;

	protected $_newData = [];

	protected $_dataBeforeCommit = [];

	protected $_callingDataWriter = [];



	protected function afterCommit(){}

	protected function beforeCommit(){}

	protected function beforeCommittingNewRecord(){}

	public function beforeDelete(){}




	public function newData()
	{
		return $this->_data;
	}

	private function insert()
	{

		$this->beforeCommittingNewRecord();

		$this->beforeCommit();

		if( $this->table()->insert( $this->_newData ) )
		{
			$this->_data[ static::table()->primaryKey() ] = $this->getDatabase()->pdo()->lastInsertId();
			return TRUE;
		}
	}

	public function commit()
	{
		$this->beforeCommit();

		if( $this->_commit() )
		{

			//registering old values
			$this->_dataBeforeCommit = $this->_data;

			//IMPORTANT
			foreach ($this->_newData as $key => $value)
			{
				//updating new values
				$this->_data[ $key ] = $value;
			}

			$this->afterCommit();

			return TRUE;
		}
	}

	final protected function _commit()
	{
		return $this->isNewRecord() ? $this->insert() : $this->update();
	}

	public function dataWriters() { return [] ; }

	final function delete()
	{
		return $this->table()->deleteRow( $this->ik() );
	}

	public function isNewRecord() { return TRUE === $this->_isNewRecord ; }

	public function ifValueChanged( $field )
	{
		return array_key_exists( $field, $this->_newData );
	}

	public function populate( array $data, $executedSQL )
	{
		$this->_isNewRecord = FALSE;

		return parent::populate( $data, $executedSQL );
	}

	// values of tmp fields MUST be synced after UPDATE
	private function update()
	{
		return static::table()->updateRow( $this->ik(), $this->_newData ) ;
	}

	// Sets values directly
	function _w( $field, $value )
	{
		if( $this->has($field) )
		{
			$this->_newData[$field] = $value ;

			return $this;
		}

		throw new \Exception( 'DATABASE ERROR : Column "'.$field.'" Not Found In Table "'.static::table()->name().'" in database "'.static::table()->database()->name().'" '  );
	}

	final function w( $field, $value, $byPass = FALSE )
	{

		if( !$byPass && isset( $this->dataWriters()[$field] ) )
		{

			$dataWriter = $this->dataWriters()[$field] ;

			if( isset( $this->_callingDataWriter[$dataWriter] ) )
			{
				throw new \Exception('Pass third argumnet TRUE when calling "write()" inside method "'.get_called_class().'::'.$dataWriter.'" ', 1);

			}

			if( method_exists( $this, $dataWriter ) )
			{
				$this->_callingDataWriter[ $dataWriter ] =  $field;

				$this->$dataWriter( $value, $field ) ;

				unset( $this->_callingDataWriter[ $dataWriter ] );

				return $this;
			}

			throw new \Exception('Direct setting is disabled for field "'.$field.'" in ActiveModel "'.get_called_class().'" ');
		}

		return $this->_w( $field, $value ) ;

	}

	function write( $field, $value, $byPass = FALSE )
	{
		return $this->w( $field, $value, $byPass);
	}

	function canWrite()
	{
		return TRUE;
	}


	//Read entitiy field value
	function _r( $field )
	{
		return array_key_exists( $field, $this->_newData) ? $this->_newData[ $field ] : parent::_r($field);
	}

}
