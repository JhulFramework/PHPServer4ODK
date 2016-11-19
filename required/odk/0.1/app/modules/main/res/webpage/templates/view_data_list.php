<table><tr><td>IdentityKey</td><td>Name</td><td>Year</td><td>Month</td><td>Day</td><td>Submitted On</td></tr>
<?php foreach ( $data as $row  ): ?>
	<tr>
		<?php   foreach ($row->persistentData() as $value): ?><td><?= $value ?></td><?php endforeach; ?>
			<td><a href=" <?= $row->url() ?>">VIEW</a></td></tr>
<?php endforeach ; ?></table>
