<?php $this->embedCss(); ?>

<div class="uk-container" >
<ul class="uk-breadcrumb">
    <li><a href="<?= $this->getApp()->url() ?>"></a>HOME</li>
    <li><span href="">LOGIN</span></li>
</ul>
</div>

<div class="form" >
<form action="" method="post" >

	<div class="field" >

	<label><i class="uk-icon-user"></i><?= $form->string('INAME') ?></label>
	<input type="text" maxlength="15" name="<?= $form->fieldName('iname') ?>" />
	</div>

	<div class="field" >
	<label><i class="uk-icon-key"></i><?= $form->string('PASSWORD') ?></label>
	<input type="password"	 name="<?= $form->fieldName('password') ?>"  />
	</div>

	<div class="field" >
	<button><?= $form->string('LOGIN') ?></button>
	</div>

</form>
</div>
