<?= $this->J()->cx('uiloader')->mbreadcrumb() ?>
<?php $this->embedCSS('upload') ; ?>

<form action = "" method = "post" enctype = "multipart/form-data">
	<div>
	<label for="xform_name">Form Name :</label>
	<input id="xform_name" type="text"  <?= $form->fieldname('xform_name') ?> value="<?= $form->restore('xform_name') ?>" />
	<?= $form->showError('xform_name') ?>
	</div>

	<div class="field">
	<label for="form_body"> Select File </label>
	<input id="form_body" type = "file" <?= $form->fieldname('xform_body') ?> />
	</div>

	<div class="pad12" ></div>
	<div class="field">
	<button type="submit"> <i class="uk-icon-cloud-upload" style="padding: 0 12px; font-size:18px;" ></i> <?= $form->string('UPLOAD') ; ?></button>
	</div>
</form>
