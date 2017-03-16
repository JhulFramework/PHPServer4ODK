
<div class="list_head B"> <span class="IB title"> Form List</span>
<a href="<?= $this->getApp()->url() ?>/manage_forms/upload" class="IB FR button" ><i class=" uk-icon-medium uk-icon-cloud-upload" > </i> UPLOAD </a> </div>

<table class="list">
<?php
	if (empty($xForms) )
	{
		echo '<div class="B" style="text-align:center" ><h2 style="color:#999" >NO XFORMS AVAILABLE TO DOWNLOAD </h2><h3 style="color:#999" >please upload some forms first</h3></div>' ;
	}
?>

<?php foreach ($xForms as $xf) : ?>
<tr> <td><?= $xf->name() ?></td> <td><a href="<?= $xf->url() ?>">DOWNLOAD</a></td> <td><a href="<?= $xf->deletionUrl() ?>">DELETE</a></td></tr>
<?php endforeach; ?>
</table>
