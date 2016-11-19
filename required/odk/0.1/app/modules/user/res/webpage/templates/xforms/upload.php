
<form action = "" method = "post" enctype = "multipart/form-data">
	<div>
	<div for="xform_name">Form Name :</div>
	<input id="xform_name" type="text"  <?= $form->fieldname('xform_name') ?> value="<?= $form->restore('xform_name') ?>" />
	<?= $form->showError('xform_name') ?>
	</div>

	<div>
	<input type = "file" <?= $form->fieldname('xform_body') ?> />
	</div>

	<div>
	<button type="submit"><?= $form->string('Upload') ; ?></button>
	</div>
</form>
