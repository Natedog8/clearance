<?php
	
	function getDSW($dbc){
		$url = "http://www.dsw.com/shoes-clearance/collection/womens/styles+under+%2425/dsw12cat1990008/page-1?categoryId=dsw12cat1990008&view=all";
		
		$sourceCode = getHtml($dbc, $url);
		
		$dom = new DOMDocument();
		$dom->loadHTML($sourceCode);
	
		$xpath = new DOMXPath($dom);
		$linkList = $xpath->query("//div[@class='productName']//a/@href");
		$nameList = $xpath->query("//div[@class='productName']//a");
		$priceList = $xpath->query("//div[@class='clearance']");
		$imageList = $xpath->query("//div[@class='productImage']//img/@src");
			
		$linkArray = array();
		$nameArray = array();
		$priceArray = array();
		$imageArray = array();
			
		foreach($linkList as $n){
			$linkArray[] = $n->nodeValue;
		}
		
		foreach($nameList as $n){
			$nameArray[] = $n->nodeValue;
		}
		
		foreach($priceList as $n){
			$priceArray[] = $n->nodeValue;
		}
		
		foreach($imageList as $n){
			$imageArray[] = $n->nodeValue;
		}
		
		for($i = 0, $count = count($priceArray); $i < $count; $i++) {
			$link  = "http://www.dsw.com".$linkArray[$i];
			$name = $nameArray[$i];
			$price = $priceArray[$i];
			$image = $imageArray[$i];
			
			// Query inserts all items found into the items table of the database. 
			//Needs to be updated to check if items already exist, or dump all the items and replace
			
			mysqli_query($dbc, "INSERT INTO items (name, siteURL, price, imageURL) VALUES ('$name', '$link', '$price', '$image')");
		}
	}

?>