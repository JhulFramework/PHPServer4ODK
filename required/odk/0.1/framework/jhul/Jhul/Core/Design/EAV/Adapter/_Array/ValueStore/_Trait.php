<?php namespace Jhul\Core\Design\EAV\Adapter\_Array\ValueStore;

//Used in BIM , Tags

trait _Trait
{
	protected $_seperator = '|';

	protected $_map = [] ;

	protected $_entity;

	protected $_name;

	abstract public function _value();

	public function __construct( $name, $entity )
	{
		$this->_name = $name;
		$this->_entity = $entity;
		$this->awake();
	}

	public function name()
	{
		return $this->_name;
	}

	public function entity()
	{
		return $this->_entity;
	}

	public function add( $value )
	{
		$this->map()[] = $value;
	}

	public function awake()
	{

		if( !empty($this->_value()) )
		{
			$this->_map = explode( $this->_seperator, $this->_value() );
		}
	}

	public function sleep()
	{
		return implode( $this->_seperator, $this->map() );
	}

	public function getKey( $value )
	{
		return array_search( $value, $this->map() );
	}

	public function has( $value )
	{
		return in_array( $value, $this->map() );
	}

	public function &map()
	{
		return $this->_map;
	}

	public function remove( $value )
	{
		if( $this->has( $value) )
		{
			unset( $this->map()[ $this->getKey( $value ) ] );
		}
	}

	public function countItems()
	{
		return count( $this->map() );
	}

}
