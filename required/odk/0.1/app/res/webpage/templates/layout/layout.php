<?php $resources_url = $this->getApp()->url().'/resources'; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="Content-Type" content="text/html">

		<meta name="Content-Language" content="hi" >

		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">

		<link rel="shortcut icon" href="<?= $resources_url ?>/icons/favicon.ico">

		<link rel="stylesheet" href="<?= $resources_url ?>/uikit/css/uikit.min.css" />

		<link rel="stylesheet" href="<?= $resources_url ?>/css/main.css">


		<?= $head ;?>
	</head>

	<body>

	<?= $body ; ?>


	<!-- top bar -->
	<script
			  src="https://code.jquery.com/jquery-3.1.1.min.js"
			  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
			  crossorigin="anonymous"></script>
	<script src="<?= $resources_url ?>/uikit/js/uikit.min.js"></script>
	<script src="<?= $resources_url ?>/uikit/js/uikit-icons.min.js"></script>

	<script>
	UIkit.offcanvas(element, options);
	</script>

	<?= $script ?>
	</body>
</html>
