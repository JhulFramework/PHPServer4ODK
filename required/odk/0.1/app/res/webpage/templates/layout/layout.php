<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="Content-Type" content="text/html">
		<meta name="Content-Language" content="hi" >
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">

		<link rel="shortcut icon" href="<?= $this->getApp()->url() ?>/resources/icons/favicon.ico">



		<link rel="stylesheet" href="<?= $this->getApp()->url().'/resources/uikit/css/flat.css' ;?>" />
		<!-- <link rel="stylesheet" href=" $this->getApp()->url().'/resources/fontello/embed.css' ;?>" /> -->


		<?= $head ;?>

	</head>

	<body>
		<?= $body ; ?>
		<!-- Compiled and minified JavaScript -->
		<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
		<script src="<?= $this->getApp()->url() ; ?>/resources/uikit/js/uikit.min.js"></script>

		<?= $js ; ?>
	</body>
</html>
