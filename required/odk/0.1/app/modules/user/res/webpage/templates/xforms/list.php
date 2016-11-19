<?php $this->embedCss('list') ; ?>

<div class="pure-g bb">
    <div class="pure-u-1-2"><span class="IB P8">XFORM LIST</span></div>
    <div class="pure-u-1-2"><a href="<?= $this->getApp()->url() ?>/manage_forms/upload"><span class="IB FR P8"> + UPLOAD XFORM</span></a></div>
</div>
<table class="list">
<?php foreach ($xForms as $xf) : ?>
<tr> <td><?= $xf->name() ?></td> <td><a href="<?= $xf->url() ?>">DOWNLOAD</a></td> <td><a href="<?= $xf->deletionUrl() ?>">DELETE</a></td></tr>
<?php endforeach; ?>
</table>
