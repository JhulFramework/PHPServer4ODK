<?php $this->embedCss(); ?>
<div class="form" >
	<div class="title" >USER LOGIN</div>
<form action="" method="post" >

	<div class="field" >

	<label><i class="uk-icon-user"></i><?= $form->string('INAME') ?></label>
	<input type="text" maxlength="15" <?= $form->fieldName('iname') ?> />
	</div>

	<div class="field" >
	<label><i class="uk-icon-key"></i><?= $form->string('PASSWORD') ?></label>
	<input type="password"	 <?= $form->fieldName('password') ?>  />
	</div>

	<div class="field" >
	<button><?= $form->string('LOGIN') ?></button>
	</div>

</form>
</div>
