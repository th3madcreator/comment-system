<?php
	require_once 'database.php';
	require_once 'functions.php';

	$reply = $_REQUEST['text_cmt'];
	$date = date('Y-m-d H:i:s');

	$rand = generateRandomString();
		#checkString($rand);

	mysqli_query($connect, "INSERT INTO `comments` (`file_id`, `comment`, `com_code`, `is_child`, `par_code`, `author`, `date`) VALUES ('1234', '$reply', '$rand', '', '', 'Guest', '$date')");

	header("Location: /YouTube/comment%20system");
?>