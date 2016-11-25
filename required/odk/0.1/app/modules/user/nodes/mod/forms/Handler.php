<?php namespace _modules\user\nodes\mod\forms;

class Handler extends \Jhul\Core\Application\Node\Handler\_Class
{
	protected function nextNodeNameType()
	{
		return 'alnum' ;
	}

	public function run()
	{
		$this->J()->cx('uiloader')->MBreadCrumb()->add( 'FORMS', $this->getApp()->url().'/manage_forms' );

		if( !$this->getApp()->endUser()->isLoggedIn() ) return ;

		if( $this->isEnd() && $this->getApp()->endUser()->m()->canManageForms() )
		{
			$xForms = \_modules\user\models\xform\M::I()->store()->fetchAll();

			return $this->getApp()->outputAdapter()->cook( 'xform_list', [ 'xForms'=> $xForms ] );
		}

		$this->moveToNext();

		if( $this->current() == 'upload' )
		{
			$this->J()->cx('uiloader')->MBreadCrumb()->add( 'UPLOAD', $this->getApp()->url().'/manage_forms/upload' );
			$this->runLocalActivity( 'upload\\Activity' );
		}

		$xform_ik = $this->current();



		if( ctype_digit($xform_ik) )
		{
			$xform = \_modules\user\models\xform\M::I()->store()->byIk($xform_ik)->fetch() ;
		}


		if( !empty($xform) )
		{
			if( $this->next() == 'delete' )
			{
				if( isset($_POST['action']) )
				{
					if( 'y' == $_POST['action'] ) { $xform->store()->deleteForm( $xform ); }

					$this->getApp()->redirect( $this->getApp()->url().'/manage_forms' );
				}

				return $this->getApp()->outputAdapter()->cook('xform_confirm_deletion', [ 'xform' => $xform ] );
			}
		}

	}
}
