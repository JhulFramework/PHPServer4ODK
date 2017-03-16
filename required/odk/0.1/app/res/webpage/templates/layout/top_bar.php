<?php $app_url = $this->getApp()->url(); ?>

	<a class="uk-button uk-button-secondary uk-button hbutton logo"  href="<?= $this->getApp()->url() ?>" >ODK Aggregate</a>

<button class="uk-button uk-button-secondary uk-padding-small uk-button uk-align-right hbutton" uk-icon="icon: grid" type="button" uk-toggle="target: #offcanvas-slide"></button>

<div class="uk-width-1-1">
	<div id="offcanvas-slide" uk-offcanvas="flip: true" >
		<div class="uk-offcanvas-bar uk-background-primary">
			<button class="uk-button uk-button-default uk-offcanvas-close uk-width-1-1 uk-margin" type="button">Close</button>

			<div class="uk-width-1-1">
			  <ul class="uk-nav-secondary uk-nav-parent-icon" uk-nav="multiple: true">
				<li class="uk-active"><a href="<?= $this->getApp()->url(); ?>"><span class="uk-margin-small-right" uk-icon="icon: home"></span>HOME</a></li>
				<?php if( !$this->getApp()->user()->isAnon() ) : ?>
				<li class="uk-parent">
					<a href="#"><span class="uk-margin-small-right" uk-icon="icon: cog"></span>SETTINGS</a>
					<ul class="uk-nav-sub">
					  <li><a href="<?= $app_url ?>/manage_forms">Manage Forms</a></li>
					  <li><a href="<?= $app_url ?>/change_password">Change Password</a></li>
					</ul>
				</li>
				<li><a href="<?= $app_url ?>/logout"><span class="uk-margin-small-right" uk-icon="icon: user"></span>LOGOUT</a></li>
				<?php else: ?>
				<li><a href="<?= $app_url ?>/login"><span class="uk-margin-small-right" uk-icon="icon: user"></span>LOGIN</a></li>
			 	<?php endif; ?>

				<li><a href=""><span class="uk-margin-small-right" uk-icon="icon: download"></span>DOWNLOAD</a></li>
			  </ul>
			</div>

		</div>
	</div>
</div>
