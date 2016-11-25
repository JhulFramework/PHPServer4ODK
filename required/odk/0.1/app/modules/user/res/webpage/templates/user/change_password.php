<?php $this->embedCss('password'); ?>
<h1>Urpinion</h1>
<h2>Create a new account</h2>
<form class="form" action="#">

  <fieldset class="form-fieldset ui-input __first">
    <input type="text" id="username" tabindex="0" />
    <label for="username">
	<span data-text="Username">Username</span>
    </label>
  </fieldset>

  <fieldset class="form-fieldset ui-input __second">
    <input type="email" id="email" tabindex="0" />
    <label for="email">
	<span data-text="E-mail Address">E-mail Address</span>
    </label>
  </fieldset>

  <fieldset class="form-fieldset ui-input __third">
    <input type="password" id="new-password" />
    <label for="new-password">
	<span data-text="New Password">New Password</span>
    </label>
  </fieldset>

  <fieldset class="form-fieldset ui-input __fourth">
    <input type="password" id="repeat-new-password" />
    <label for="repeat-new-password">
	<span data-text="Repeat New Password">Repeat New Password</span>
    </label>
  </fieldset>

  <div class="form-footer">
    <input type="submit" class="btn" value="Create Account" />
  </div>
</form>
</div>
