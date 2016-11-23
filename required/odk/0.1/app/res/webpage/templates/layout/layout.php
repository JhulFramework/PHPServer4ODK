<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="Content-Type" content="text/html">
		<meta name="Content-Language" content="hi" >
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">

		<link rel="shortcut icon" href="<?= $this->getApp()->url() ?>/resources/icons/favicon.ico">

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

			<link rel="stylesheet" href="<?= $this->getApp()->url().'/resources/fontello/css/embed.css'  ?>">
			 <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

		<?= $head ;?>

	</head>

	<body> <?= $body ; ?>
		<!-- Compiled and minified JavaScript -->
		<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
		 <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.min.js"></script>
		 <script type="text/javascript" >
		 $('.button-collapse').sideNav({
menuWidth: 240, // Default is 240
edge: 'right', // Choose the horizontal origin
closeOnClick: true, // Closes side-nav on <a> clicks, useful for Angular/Meteor
draggable: true // Choose whether you can drag to open on touch screens
}
);

	  $('.button-close').sideNav('hide');
	 </script>
	</body>
</html>
