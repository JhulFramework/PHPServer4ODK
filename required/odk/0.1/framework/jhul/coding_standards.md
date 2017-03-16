- columns
	120

- indention
	tabs

- configuration key name starts with small letter, and underscores are used intead of camelCase
	[ 'some_value' => 120 ]

- protected and private properties starts with underscore and is camelCased
 	$\_protectedProperty;

- properties/methods which holds/returns manager starts with "m"

	//Handler Manager
	proptected $\_mHandler,
	public function mHandler() { return $this->\_mHandler ; }

- configuraton/Trait/AbstractClasses file name starts with underscore

	//Trait
	trait \_TraitName
	{

	}

	//Abstract Class
	abstract \_AbstractClass
	{

	}

	//configuration File
	\_config.php
