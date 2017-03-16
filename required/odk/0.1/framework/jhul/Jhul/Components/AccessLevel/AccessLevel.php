<?php namespace Jhul\Components\AccessLevel;
/***********************************************************************************************************************
 *dsdasd
 *
 **********************************************************************************************************************/

class AccessLevel
{

	use \Jhul\Core\Traits\DependencyProvider;

	private $_levels = [

		'PRIVATE' => 0,
		'WORLD'	=> 1

	];

	private $_labels =
	[
		'PRIVATE' => 'VISIBILITY_SELF',

		'WORLD' => 'VISIBILITY_WORLD',
	];


	private $selected = [

		'PRIVATE' => '',
		'WORLD'	=> '',

	];

	public static function I()
	{
		return new static();
	}

	public function get( $name )
	{
		return $this->_levels[$name];
	}

	public function isValid( $accessLevel )
	{
		return in_array( $accessLevel, $this->_levels );
	}

	public function htmlOptions( $selected = 0 )
	{

		if(  NULL != ($key = array_search( (int) $selected, $this->_levels ) ) )
		{
			$this->selected[$key] = 'selected';
		}

		$html = '';

		foreach( $this->_levels as $k => $v )
		{
			$html .= '<option value="'.$v.'" '.$this->selected[$k].' >'.$this->com('Lipi')->P($this->_labels[$k]).'</option>';
		}

		return $html;
  	}

  	public function isWorld( $accessLevel )
  	{
  		return $this->_levels['WORLD'] == $accessLevel;
  	}

  	public function isPrivate( $accessLevel )
  	{
  		return $this->_levels['PRIVATE'] == $accessLevel;
  	}
}
