<?php $this->embedCss('header'); ?>


<div class="header B" >
	<a class="IB name"  href="<?= $this->getApp()->url() ?>" ><?= $this->getApp()->name() ?></a>
	<a class="FR" href="#side-nav" data-uk-offcanvas="{mode:'slide'}"> <i class="uk-icon-chevron-left" ></i> </a>
</div>

<!-- This is the off-canvas sidebar -->
<div id="side-nav" class="uk-offcanvas">
	<div class="uk-offcanvas-bar uk-offcanvas-bar-flip" style="background:#555; ">
		<ul class="menu" >
			<li class="bottomBorder"><a href="#side-nav" > <i class="uk-icon-chevron-right" ></i>CLOSE</a></li>

			<?php if( $this->getApp()->endUser()->isLoggedIn() ): ?>

			<li class="bottomBorder" ><a href="<?= $this->getApp()->url() ?>/manage_users"><i class="uk-icon-user" ></i>USERS</a></li>
			<li class="bottomBorder" ><a href="<?= $this->getApp()->url() ?>/manage_forms"><i class="uk-icon-wpforms" ></i>FORMS</a></li>
			<li class="bottomBorder" ><a href="<?= $this->getApp()->url() ?>/logout"><i class="uk-icon-power-off" ></i>LOGOUT</a></li>

			<?php else :?>

			<li class="bottomBorder" ><a href="<?= $this->getApp()->url() ?>/login"><i class="uk-icon-power-off" ></i>LOGIN</a></li>

			<?php endif; ?>
		</ul>
	</div>
</div>
