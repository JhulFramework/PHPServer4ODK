<?php require(__DIR__.'/top_bar.php') ?>

<?= $content ; ?>


<div class="footer" >
	<items>
		<a href="https://github.com/JhulFramework/PHPServer4ODK" ><span  uk-icon="icon: github" ></span> Github </a>
		<a href="https://opendatakit.org/"><span  uk-icon="icon: link" ></span> OpenDataKit </a>
	</items>
	<div><center><?= $this->getApp()->name(); ?></div></center>
</div>
