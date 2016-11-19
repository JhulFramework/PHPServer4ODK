<?php namespace Jhul\Components\Database\Store\Data;

/* @Author : Manish DHruw [1D3N717Y12@gmail.com]
+-----------------------------------------------------------------------------------------------------------------------
| @Created : 2016-August
| IMPORTANT
| After Committing _modified_data it is imporant to update persistData, since entity maynot be reloaded, and may contain old values
+=====================================================================================================================*/
//after commit we should refresh  _data with newly acommitted data , since the class is not reloaded //IMPORTANT
//TODO CHeck if IsChanged() and isModified() working correctly

trait _WriteAccessKey
{
	protected $_editor;

	public function isPersistent()
	{
		return !empty( $this->persistentData()['ik'] );
	}

	public function _populate( array $data, $executedSQL ){ return parent::_populate( $data, $executedSQL ); }

	public function editor()
	{
		if( empty( $this->_editor ) )
		{
			$class = $this->editorClass();

			$this->_editor = new $class( $this );
		}

		return $this->_editor;
	}

	//Overrid to user custom editor
	public function editorClass()
	{
		return __NAMESPACE__.'\\Editor';
	}

	public function commit()
	{
		if( !empty( $this->_editor ) )
		{
			return $this->editor()->commit();
		}
	}

	public function accessMode()
	{
		return 's';
	}

	final public function delete()
	{
		return $this->editor()->delete();
	}

	public function hasInflators()
	{
		return FALSE;
	}

	//Value changed but no committed
	public function isModified()
	{
		if( !empty($this->_editor) )
		{
			return $this->editor()->ifDataModified();
		}

		return FALSE;
	}

	//value changed and committed
	public function isChanged()
	{
		if( !empty($this->_editor) )
		{
			return $this->editor()->ifDataModified();
		}

		return FALSE;
	}

	public function read( $field, $byPass = FALSE )
	{
		if( $this->isPersistent() )
		{
			return parent::read( $field, $byPass );
		}

		//new values are always empty
		return NULL;
	}

	public function _updatePersistentData( $key, $value )
	{
		$this->_persistent_data[$key] = $value;
	}

	public function write( $key, $value, $byPass = FALSE )
	{
		$this->editor()->write( $key, $value, $byPass );
		return $this;
	}

	public function modifiedData()
	{
		return $this->editor()->modifiedData();
	}
}
