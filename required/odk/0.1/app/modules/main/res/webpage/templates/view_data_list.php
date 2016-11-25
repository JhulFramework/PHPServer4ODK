<?php $this->embedCss('data_list'); ?>
<?= $this->J()->cx('uiloader')->mBreadcrumb(); ?>

<?php if( empty( $data ) ) : ?>
<div class="uk-container-center" style="display:block; margin:auto; width:100%; max-width:400px; text-align:center"  >
<h2 style="color:#aaa;"> No Forms Submitted by Collect yet </h2>
<h3  style="color:#aaa;">Submit some forms before listing</h3>
</div>
<?php else: ?>
<table class="data_list">

	<tr class="head" >
	<td class="col"><span>IDENTITY KEY</span></td>
	<td class="col"><span>NAME</span></td>
	<td class="col" ><span>YEAR</span></td>
	<td class="col"><span>MONTH</span></td>
	<td class="col" ><span>DAY</span></td>
	<td class="col"><span>SUBMITTED ON</span></td>
</tr>

<?php foreach ( $data as $row  ): ?>
	<tr class="data" >
		<?php   foreach ($row->persistentData() as $value): ?>
			<td><span><?= $value ?></span></td>
			<?php endforeach; ?>
			<td><a href=" <?= $row->url() ?>">VIEW</a></td>
			<td><a href=" <?= $row->xmlUrl() ?>"><i class="uk-icon-download" ></i>XML</a></td>
			<td><a href=" <?= $row->jsonurl() ?>"><i class="uk-icon-download" ></i>JSON</a></td>
	</tr>
<?php endforeach ; ?>

</table>

<?php endif; ?>
