<?php

	include("core/init.php");
	
	include("includes/header.php");
	
	$displayAllQuery = mysqli_query($dbc, "SELECT id, name, siteURL, price, imageURL FROM items");
	
	while($row = mysqli_fetch_array($displayAllQuery, MYSQLI_ASSOC)){
		$id = $row['id'];
		$name = $row['name'];
		$link = $row['siteURL'];
		$price = $row['price'];
		$image = $row['imageURL'];
		
		echo "<div class='product'><a href='".$link."'><img id='".$id."' src='".$image."' width='160'><br><br>".$name."</a><br>".$price."</div>";
	}

	include("includes/footer.php");
	
?>