<?php
	
	function getFreePeople($dbc){
		$url = "http://www.verabradley.com/category/Sale/Handbags/877/pc/785.uts";
		
		$sourceCode = getHtml($dbc, $url);
		
		$dom = new DOMDocument();
		$dom->loadHTML($sourceCode);
	
		$xpath = new DOMXPath($dom);
		$linkList = $xpath->query("//div[@class='url']//a[contains(@href, 'http://www.verabradley.com')]/@href");
		$nameList = $xpath->query("//div[@class='name']//a");
		$priceList = $xpath->query("//div[@class='pricerange']");
		$imageList = $xpath->query("//div[@class='image']//img/@src");
			
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