<?php
		
	include("core/init.php");
	
	echo "<h1>Nine West</h1>";
	
	getNineWest($dbc);

	echo "<h1>DSW</h1>";
	
	getDSW($dbc);
	
?>