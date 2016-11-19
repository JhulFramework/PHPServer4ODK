<div class="header" ><div class="logo"><a href="<?= $this->getApp()->url() ?>" ><?= $this->getApp()->name() ?></a></div>

<?php if( $this->getApp()->endUser()->isLoggedIn() ): ?>
<div class="link"><a href="<?= $this->getApp()->url() ?>/logout">Logout</a></div>
<?php else : ?>
<div class="link"><a href="<?= $this->getApp()->url() ?>/login">Login</a></div>
<?php endif; ?>
</div>

<?php if( $this->getApp()->endUser()->isLoggedIn() ): ?>
<div class="pure-g">
	<div class="pure-u-1 pure-u-md-1-3">Data</div>
	<div class="pure-u-1 pure-u-md-1-3"><a href="<?= $this->getApp()->url() ?>/manage_forms"><span class="link">Manage Forms</span></a></div>
	<div class="pure-u-1 pure-u-md-1-3">Manage User</div>
</div>

<?php endif; ?>
