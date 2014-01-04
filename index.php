<?php
		
	include("core/init.php");
	
	echo "<h1>Forever 21</h1>";
	
	getF21($dbc);
	
	echo "<h1>Urban Outfitters</h1>";
	
	getUrban($dbc);
	
	echo "<h1>Nine West</h1>";
	
	getNineWest($dbc);

	echo "<h1>DSW</h1>";
	
	getDSW($dbc);
	
?>