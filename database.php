<?php
	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass ='';
	$dbname ='local';

	$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die(mysqli_error($connect));
?>