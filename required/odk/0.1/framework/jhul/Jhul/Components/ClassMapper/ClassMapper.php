<?php namespace Jhul\Components\ClassMapper;

class ClassMapper
{
      protected $_map = [];

      static function I()
      {
            return new static();
      }


      public function register( $name, $class = NULL, $checkClassExists = TRUE )
      {
		if( is_array($name) )
		{
			foreach ( $name as $n => $c)
			{
				$this->register($n, $c, $checkClassExists);
			}

			return ;
		}

            if( !empty( $this->_map[$name] ) && $class != $this->_map[$name] )
            {
                  throw new \Exception( 'Identity Key "'.$name.'" is already assigned to class "'.$this->_map[$name].'", Cannot be used for "'.$class.'" ' );
            }

		if( $checkClassExists && !class_exists( $class) ) throw new \Exception( 'Class "'.$class.'" Not Found' , 1);

            $this->_map[$name] = $class;
      }

      public function isSingleton()
      {
            return TRUE ;
      }

      public function getClass( $name )
      {
            if( isset( $this->_map[ $name ] ) )
            {
                  return $this->_map[$name];
            }

            throw new \Exception( 'No Class Mapped With Identity Key "'.$name.'" !', 1);

      }

      public function getObject( $name, $params = [] )
      {

      }
}
