<?php namespace Jhul\Components\BFD;

class BFD
{

	//@structure [ (string) form_name => (digit) identity_key ],
	private $_forms = [];

	private $_delay_threshold_map = [];

	public function __construct( $config )
	{
		if( isset($config['forms']) )
		{
			$this->registerForm( $config['forms'] );
		}

		if( isset($config['delay_threshold']) )
		{
			$this->addDelayThreshold( $config['delay_threshold'] );
		}
	}

	public function registerForm( $name, $identity_key = NULL )
	{
		if( is_array( $name ) )
		{
			foreach ( $name as $n => $k )
			{
				$this->registerForm( $n, $k );
			}

			return;
		}

		if( empty( $identity_key ) ) throw new \Exception( 'Identity Key Must Have Value' , 1);


		if( isset( $this->_forms[$name] ) && $this->_forms[$name] != $identity_key )
		{
			throw new \Exception( 'form "'.$name.'" registering with new ik "'.$identity_key.'" is already has ik "'.$this->_form[$name].'"' , 1);
		}

		if( NULL != ( $n = array_search( $identity_key, $this->_forms ) ) )
		{
			if($n != $name ) throw new \Exception( ' Identity Key "'.$identity_key.'" registering for form "'.$name.'" is already registered to form "'.$n.'" ' , 1);
		}

		$this->_forms[$name] = $identity_key;
	}

	public function addDelayThreshold( $onAttemptCount, $delayTime = NULL )
	{
		if( is_array($onAttemptCount) )
		{
			foreach ($onAttemptCount as $a => $d)
			{
				$this->addDelayThreshold( $a, $d );
			}

			return;
		}

		$this->_delay_threshold_map[ $onAttemptCount ] = $delayTime;
	}

	public function getFormIK( $name )
	{
		if( isset( $this->_forms[$name] ) )
		{
			return $this->_forms[ $name ];
		}

		throw new \Exception( 'Form "'.$name.'" not registered', 1);
	}

	public function DB()
	{
		return DB\Attempt::I()->store();
	}

	public function has( $UIK, $formName )
	{
		return NULL != $this->get( $UIK, $formName );
	}

	public function get( $UIK, $form_name, $autoSleep = TRUE )
	{
		$form_ik = $this->getFormIK( $form_name );

		$params  = [ 'user_ik' => $UIK, 'form_ik' => $form_ik ];

		$attempt = $this->DB()->byParams( $params )->fetch();

		if( empty( $attempt )  )
		{
			$attempt = $this->DB()->make( $params );
		}

		//delaying depends on the number of attempts
		if( $autoSleep )
		{
			$this->delay( $attempt->countAttempts() );
		}

		return $attempt;
	}



	//Delaying according to the threshold set on map;
	public function delay( $countAttempts )
	{

		$tKey = 1;

		foreach ( $this->_delay_threshold_map as $key => $time )
		{
			if(  $countAttempts > $key && $key > $tKey  )
			{
				$tKey = $key;
			}
		}

		if( isset( $this->_delay_threshold_map[ $tKey ] ) )
		{
			sleep( $this->_delay_threshold_map[ $tKey ] );
		}
	}

}
