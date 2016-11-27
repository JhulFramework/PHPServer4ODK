<?php namespace _modules\user\nodes\mod\forms\upload;

class Activity extends \Jhul\Core\Application\Node\Activity\_Class
{
	public function cookWebPage()
	{

		$form = new Form;


		if( $form->collect() &&  isset($_FILES[ $form->name() ]['tmp_name']['xform_body'] ) && $form->xform_name->isValid() )
		{

			$dxform = \_modules\user\models\xform\M::I()->store()->byName( $form->xform_name->value() )->fetch();

			if( !empty( $dxform ) )
			{
				$form->addError( 'xform_name', 'Form Name Already Used');
			}

			$r_form_path = $this->getApp()->config('xform_dir').'/'.$form->xform_name->value().'.xml';



			if( !is_file($_FILES[ $form->name() ]['tmp_name']['xform_body']) )
			{
				$form->addError( 'xform_name', 'Please Select XForm To Upload');
			}

			if( !$form->hasError('xform_name')  )
			{
				$md5 = md5_file( $_FILES[ $form->name() ]['tmp_name']['xform_body'] );

				move_uploaded_file( $_FILES[ $form->name() ]['tmp_name']['xform_body'], $this->getApp()->publicRoot().'/'.$r_form_path );
				\_modules\user\models\xform\M::I()->store()->make
				    ([ 'name' => $form->xform_name, 'r_url' => $r_form_path, 'md5' => $md5 ] );

				    $this->getApp()->redirect( $this->getApp()->url().'/manage_forms' );
			}


		}

		$this->cook( 'xform_upload', [ 'form'=> $form ] );
	}
}
