<?php namespace _modules\main\models\data\content;

class M  extends \Jhul\Components\Database\Store\Data\_Class
{
	use \Jhul\Components\Database\Store\Data\_WriteAccessKey;

	protected $_name;

	protected $_asArray;

	protected $_asXML;

	public function setName( $name ) { $this->_name = $name; }

	public function name(){ return $this->_name ; }

	public function storeClass()
	{
		return __NAMESPACE__.'\\Store';
	}

	public function tableName()
	{
		return 'submitted_data_content';
	}

	public function keyName(){ return 'data_key'; }


	public function asArray()
	{
		if( empty( $this->_asArray ) )
		{
		 	$this->_asArray = unserialize( $this->read('content') );
		}

		return $this->_asArray;
	}

	public function asXML()
	{
		if( empty( $this->_asXML ) )
		{
			$this->getApp()->m('user');
			$this->_asXML = $this->getApp()->mDataType('xml')->arrayToXML( '<nm id="'.$this->name().'" ></nm>', $this->asArray() );
		}

		return $this->_asXML;
	}

	public function raw()
	{
		return $this->read('content');
	}

	public function context()
	{
		return 'write';
	}


	protected function putCSV($input, $delimiter = ',', $enclosure = '"')
	{
		// Open a memory "file" for read/write...
		$fp = fopen('php://temp', 'r+');
		// ... write the $input array to the "file" using fputcsv()...
		fputcsv($fp, $input, $delimiter, $enclosure);
		// ... rewind the "file" so we can read what we just wrote...
		rewind($fp);
		// ... read the entire line into a variable...
		$data = fread($fp, 1048576);
		// ... close the "file"...
		fclose($fp);
		// ... and return the $data to the caller, with the trailing newline from fgets() removed.
		return rtrim($data, "\n");
	}

	public function asCSV()
	{
		return $this->_asCSV( $this->asArray() );
	}

	public function _asCSV( $array )
	{
		$csvString = '';

		foreach ( $array as $field )
		{
			if( is_array( $field) )
			{
				$csvString .= $this->putCSV( $this->_asCSV($array) );
			}
			else
			{

				$csvString .= $this->putCSV($fp, $field);
			}
		}

		return $csvString;
	}

	public function asJSON()
	{
		return json_encode( $this->asArray() );
	}

}
