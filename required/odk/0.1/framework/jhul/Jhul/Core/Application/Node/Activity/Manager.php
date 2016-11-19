<?php namespace Jhul\Core\Application\Node\Activity;

/* @Author Manish Dhruw < 1D3N717Y12@gmail.com >
+=======================================================================================================================
| @Created : 2016-October-16
+---------------------------------------------------------------------------------------------------------------------*/

class Manager
{
	use \Jhul\Core\_AccessKey;

	protected $_activities = [];

	public function register( $module_name, $name, $class = NULL, $checkIfClassExists = TRUE )
	{

		if( is_array($name) )
		{
			foreach ( $name as $n => $c)
			{
				$this->register( $module_name, $n, $c, $checkIfClassExists );
			}

			return;
		}

		if( empty($class) ) throw new \Exception( 'Activity "'.$name.'" class must not be empty ', 1);

		$class = trim( $class, '\\' );

		if( $checkIfClassExists && !class_exists( $class ) ) throw new \Exception( 'Activity "'.$name.'" class "'.$class.'" not found', 1);


		if( isset( $this->_activities[$name] )  && $this->_activities[$name] != $class )
		{
			throw new \Exception( 'clash for activity name "'.$name.'" betwen alreday registered class "'.$this->_activities[$name].'" and new class "'.$class.'" ', 1);
		}

		$this->_activities[ $module_name.'.'.$name] = $class;
	}

	public function map()
	{
		return $this->_activities;
	}


	public function getActivity( $activity_name )
	{
		$a = explode( '.', $activity_name );

		if( isset($a[0]) && isset($a[1]) )
		{
			$this->getApp()->m( $a[0] );


			if( isset( $this->map()[$activity_name]) )
			{
				return $this->map()[$activity_name];
			}

			throw new \Exception( 'Module "'.$h[0].'" does not contains any Activity named "'.$h[1].'" ' , 1);
		}

		throw new \Exception( 'Invalid Activity name formate "'.$activity_name.'". Use <(module_name).(activity_name)> ', 1 );
	}

	//accespts name of registered activity or class
	public function run( $activity_name )
	{
		$activity_class = $activity_name;

		$makeType = 'cook'.$this->getApp()->outputAdapter()->type() ;

		if( !strrpos($activity_name, '\\') )
		{
			$activity_class = $this->getActivity( $activity_name );
		}

		$activity_class::I()->$makeType();
	}

}
