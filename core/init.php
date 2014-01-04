<?php

	session_start();
	error_reporting(0);
	
	require ("functions/general.php");
	require ("functions/dsw.php");
	require ("functions/ninewest.php");
	require ("functions/urban.php");
	require ("functions/forever21.php");
	
	$dbc = mysqli_connect('localhost', 'root', 'mnw1527', 'clearance');
	
	// Sets default timezone for datetime purposes of posted items
	date_default_timezone_set("America/New_York");

?>