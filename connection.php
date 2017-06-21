<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "userdb";
	
	$conn = mysql_connect($servername, $username, $password);
	$dbconn = mysql_select_db($dbname);
	// Check connection
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	
	if (!$dbconn) {
		die("Connection failed: " . mysql_error());
	}
?>