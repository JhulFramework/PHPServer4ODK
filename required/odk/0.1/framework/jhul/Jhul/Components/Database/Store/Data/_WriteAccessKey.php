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
	public function isPersistent(){ return $this->_pData()->hasValue( $this->keyName() ); }

	public function commit()
	{
		$this->store()->commit($this) ;
	}

	public function delete(){ return $this->store()->delete( $this ); }

	public function has( $key )
	{
		if( $this->isModified()  )
		{
			if( $this->_mData()->has( $key ) ) return TRUE;
		}

		return parent::has($key);
	}

	//Value changed but no committed
	public function isModified()
	{
		if( isset( $this->_dataBags['modified'] ) )
		{
			return !$this->_mData()->isEmpty() ;
		}

		return FALSE;
	}

	//value changed and committed
	public function isChanged()
	{
		if( isset( $this->_dataBags['old'] ) )
		{
			return !$this->_oData()->isEmpty() ;
		}

		return FALSE;
	}

	//modified Data
	public function _mData(){ return $this->getDataBag('modified'); }

	//old Data
	public function _oData(){ return $this->getDataBag('old'); }

	public function _read( $field, $silent = FALSE )
	{
		if( $this->_mData()->has($field)  )
		{
			return $this->_mData()->read( $field , $silent );
		}

		if( $this->isPersistent() )
		{
			return parent::_read( $field, $silent );
		}
	}

	public function _write( $key, $value )
	{
		$this->_mData()->write( $key, $value );

		//after write new value we need to reset prepared data from old values
		if( isset( $this->_prepared[$key] ) ) { unset( $this->_prepared[$key] ); }

		return $this;
	}

	public function write( $key, $value )
	{
		if( isset( $this->writeHandlers()[$key] ) )
		{
			$writeHandler = $this->writeHandlers()[$key] ;

			return $this->_write( $key, $this->$writeHandler( $value, $key ) ) ;
		}

		return $this->_write( $key, $this->store()->deflateValue( $value, $key ) );
	}

	public function writeHandlers(){ return []; }


}
