<?php

	//DB information file

	define('DB_SERVER', 'csci4145project.cffjtzdcv8ol.us-east-2.rds.amazonaws.com');
	define('DB_USERNAME', 'csci4145project');
	define('DB_PASSWORD', 'csci4145project');
	define('DB_NAME', 'csci4145project');
	 
	/* Attempt to connect to MySQL database */
	$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
	 
	// Check connection
	if($conn === false){
		die("ERROR: Could not connect. " . mysqli_connect_error());
	}
?>