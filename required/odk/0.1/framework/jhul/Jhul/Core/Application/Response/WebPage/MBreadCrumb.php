<?php namespace Jhul\Core\Application\Response\WebPage;

class MBreadCrumb
{

	private $_breadCrumbs = '';

     private $_bar;

	private $_urls;

	//last piece of crumb;
	private $_end;

     function __construct( $urls = [] )
     {
		$this->_urls = $urls;
     }

	function addMap( $map )
	{
		foreach( $map as  $breadcrumb)
		{
			$this->add( $breadcrumb['label'], $breadcrumb['url'] );
		}
	}

	function add( $key, $value = '' )
	{
		if(!isset( $this->_urls[$key] ))
		{
			$this->_urls[$key] = $value;
			$this->_end = $key;
		}
	}

      private function makePath( $name, $url )
      {
            $this->_bar->icon('arrow_right',14);

            if( !empty($url) && $this->_end != $name )
            {
                  $this->_bar->link($url)->fc('dd2');
            }

            $this->_bar->T($name);
      }

	private function prepare()
	{

            $this->_bar = \app\components\Bar::I([25,36])->FL() ;

            foreach( $this->_urls as $name => $url )
            {
                  $this->_breadCrumbs .= $this->makePath($name, $url);
            }
	}

      public function create()
      {
		$this->prepare();

            return '<div class="H36 B BGTP">'.$this->_bar->done().$this->_menu.'</div>' ;
      }

      public function __toString()
      {
            return $this->create();
      }

      public static function I( $urls = [] )
      {
            return new static( $urls );
      }

	/* BETA
	+===============================================================================================================*/
	protected $_menu ;

	public function attachMenu( $URL, $icon, $text )
	{
		$this->_menu = '<a href="'.$URL.'" >'.\app\components\Bar::I(36)->icon( $icon )->pr(12)->T( $text )->fr()->done().'</a>';
	}
	/*BETA
	----------------------------------------------------------------------------------------------------------------*/
}
