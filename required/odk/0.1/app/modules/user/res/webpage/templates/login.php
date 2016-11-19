<?php $this->embedCss(); ?>
<div class="form" >
<form action="" method="post" >

	<div class="field" >

	<label><?= $form->string('IName') ?></label>
	<input type="text" maxlength="15" <?= $form->fieldName('iname') ?> />
	</div>

	<div class="field" >
	<label><?= $form->string('Password') ?></label>
	<input type="password"	 <?= $form->fieldName('password') ?>  />
	</div>

	<div class="field" >
	<button><?= $form->string('Login') ?></button>
	</div>

</form>
</div>
