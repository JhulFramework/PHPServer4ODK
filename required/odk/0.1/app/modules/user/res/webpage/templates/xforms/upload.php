<form action="" method="post" enctype = "multipart/form-data">

	<div class="row">
		<div class="input-field col s6">
				<input id="xform_name" type="text" <?= $form->fieldname('xform_name') ?> value="<?= $form->restore('xform_name') ?>" >
				<label for="xform_name">Form Name</label>
		</div>
 	</div>


	<div class="row">
	<div class="file-field input-field col s6 ">
     <div class="btn">
	 <span>XForm</span>
	 <input type="file" <?= $form->fieldname('xform_body') ?> />
     </div>
     <div class="file-path-wrapper">
	 <input class="file-path validate" type="text">
     </div>
   </div>
   </div>


	   <div class="row">
		   <div class="col s6">
  <button class="btn waves-effect waves-light" type="submit"><?= $form->string('Upload') ; ?>
   	<i class="material-icons right">file_upload</i>
 </button>
 </div>
 </div>
 </form>
