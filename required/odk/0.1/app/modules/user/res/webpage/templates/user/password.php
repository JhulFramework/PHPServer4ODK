<div class="uk-container uk-container-large uk-align-center" >

<ul class="uk-breadcrumb">
	<li><a href="<?= $this->getApp()->url() ?>">HOME</a></li>
	<li><span>CHANGE PASSWORD</span></li>
</ul>

<form id="form" class="uk-align-center" action="" method="post">

	  <div class="uk-margin">
		<label class="uk-form-label">OLD PASSWORD</label>
		<div class="uk-form-controls">
            	<input class="uk-input uk-width-1-1" type="password" name="<?= $form->fieldName('old_password') ?>" />
			<?= $form->showError('old_password') ?>
		</div>
	</div>


	  <div class="uk-margin">
		<label class="uk-form-label">NEW PASSWORD</label>
	      <div class="uk-form-controls">
	      	<input class="uk-input uk-width-1-1" type="password" name="<?= $form->fieldName('new_password') ?>" />
			<?= $form->showError('new_password') ?>
		</div>
	  </div>

	  <div class="uk-margin">
		<label class="uk-form-label">CONFIRM NEW PASSWORD</label>
	      <div class="uk-form-controls">
	      	<input class="uk-input uk-width-1-1" type="password" name="<?= $form->fieldName('new_password_confirm') ?>" />
			<?= $form->showError('new_password_confirm') ?>
		</div>
	  </div>

	  <button class="uk-button uk-button-primary uk-width-1-1" style="letter-spacing:1px;" type="submit">CHANGE PASSWORD</button>

</form>

</div>
