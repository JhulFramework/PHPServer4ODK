<xforms xmlns="http://openrosa.org/xforms/xformsList" >

<?php foreach ($xforms as $xform): ?>

<xform>

	<formID><?= $xform->key() ?></formID>
	<name><?= $xform->name() ?></name>
	<hash>md5:<?= $xform->md5(); ?></hash>
	<downloadUrl><?= $xform->url() ?></downloadUrl>
</xform>


<?php endforeach; ?>

</xforms>
