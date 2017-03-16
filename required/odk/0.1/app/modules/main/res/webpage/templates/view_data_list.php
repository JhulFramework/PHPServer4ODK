<?php $this->embedCss('data_list'); ?>

<div class="uk-container uk-container-large uk-align-center" >
	<ul class="uk-breadcrumb">
	    <li><span>HOME</span></li>
	</ul>
</div>

<?php if( empty( $data ) ) : ?>
<div class="uk-container-center" style="display:block; margin:auto; width:100%; max-width:400px; text-align:center;padding:60px 0;"  >
<h2 style="color:#aaa;"> No Data Submitted by Collect yet </h2>
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

	<td><span><?= $row->read('ik') ;		?></span></td>
	<td><span><?= $row->read('name');		?></span></td>
	<td><span><?= $row->read('year');		?></span></td>
	<td><span><?= $row->read('month');		?></span></td>
	<td><span><?= $row->read('day');		?></span></td>
	<td><span><?= $row->read('created');	?></span></td>

	<td><a href="<?= $row->url() ?>">VIEW</a></td>
	<td><a href="<?= $row->xmlUrl() ?>"><i class="uk-icon-download" ></i>XML</a></td>
	<td><a href="<?= $row->jsonurl() ?>"><i class="uk-icon-download" ></i>JSON</a></td>

	</tr>
<?php endforeach ; ?>

</table>

<?php endif; ?>
