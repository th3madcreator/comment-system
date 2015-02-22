<?php
	require_once 'database.php';
	require_once 'functions.php';
?>
<!doctype html>
<html>
	<head>
		<title>YouTube Comment Test</title>
		<link rel="stylesheet" href="styles.css">
	</head>
	<body>
		<?php
			get_comments('1234');
		?>
	</body>
</html>