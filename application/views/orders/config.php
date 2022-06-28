<?php
	const DBHOST = 'localhost';
	const DBUSER = 'wooapico_byron';
	const DBPASS = 'GOOgle86!!';
	const DBNAME = 'wooapico_dashboard';

	$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

	if ($conn->connect_error) {
	  die('Could not connect to the database!' . $conn->connect_error);
	}
?>