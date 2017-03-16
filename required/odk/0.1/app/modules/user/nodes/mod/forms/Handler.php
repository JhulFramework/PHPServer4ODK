<?php namespace _modules\user\nodes\mod\forms;

class Handler extends \Jhul\Core\Application\Handler\_Class
{
	public function canHandleNextNode()
	{
		return TRUE;
	}

	public function handle()
	{
		if( $this->getApp()->user()->isAnon() ) return ;


		if( !$this->mPath()->hasNext() && $this->getApp()->user()->canManageForms() )
		{
			$xForms = \_modules\user\models\xform\M::D()->fetchAll();

			return $this->getApp()->response()->page()->cook( 'xform_list', [ 'xForms'=> $xForms ] );
		}



		if( $this->mPath()->next() == 'upload' )
		{
			$this->renderPage( __NAMESPACE__.'\\upload\\Page' );
		}

		$xform_key = $this->mPath()->next();



		if( ctype_digit($xform_key) )
		{
			$xform = \_modules\user\models\xform\M::D()->byKey($xform_key)->fetch() ;
		}


		if( !empty($xform) )
		{
			if( isset($_GET['a']) && $_GET['a'] == 'delete' )
			{
				if( isset($_POST['action']) )
				{
					if( 'y' == $_POST['action'] ) { $xform->store()->deleteForm( $xform ); }

					$this->getApp()->redirect( $this->getApp()->url().'/manage_forms' );
				}

				return $this->getApp()->response()->page()->cook('xform_confirm_deletion', [ 'xform' => $xform ] );
			}
		}

	}
}
