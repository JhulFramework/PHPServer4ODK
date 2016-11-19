<?php $this->embedCss('delete'); ?>

<div class="confirm_box">
<form method="post" action="" >
	<h3>Confirm XForm Deltion</h3>
	<div style="padding:14px; display:block;text-align:center;" >Delete Form <span style="font-size:20px; color:#fff"; >"<?= $xform->name(); ?>"</span> ?</div>
<button class="IB FL y" type="submit" name="action" value="y"  >YES</button><button class="IB FR n" type="submit" name="action" value="n">NO</button>
</form>
</div>
