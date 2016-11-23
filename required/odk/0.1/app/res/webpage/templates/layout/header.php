
<ul id="slide-out" class="side-nav">
	<li> <a href="#" class="button-close"><i class="material-icons">play_arrow</i>Close</a></li>
	<li><a href="sass.html"><i class="material-icons">cloud</i> Data</a></li>
	<?php if( $this->getApp()->endUser()->isLoggedIn() ): ?>
	<li><a href="<?= $this->getApp()->url() ?>/manage_users"><i class="material-icons">supervisor_account</i>Manage Users</a></li>
	 <li><a href="<?= $this->getApp()->url() ?>/manage_forms"><i class="material-icons">assignment</i>Manage XForms</a></li>
	 <li><a href="<?= $this->getApp()->url() ?>/logout" ><i class="material-icons">power_settings_new</i>Logout</a></li>
	 <?php endif; ?>
</ul>

 <nav >
     <div class="nav-wrapper">
       <a href="<?= $this->getApp()->url(); ?>" class="brand-logo" style="font-size:24px;"><?= $this->getApp()->name() ?></a>
       <ul class="right">
		<?php if( !$this->getApp()->endUser()->isLoggedIn() ): ?>
			 <li><a href="<?= $this->getApp()->url() ?>/login" >LOGIN</a></li>
		<?php endif; ?>
         <li> <a href="#" data-activates="slide-out" class="button-collapse show-on-large"><i class="material-icons">menu</i></a></li>
       </ul>
     </div>
 </nav>
