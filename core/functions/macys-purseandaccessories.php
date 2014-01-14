<?php
	
	function getFreePeople($dbc){
		$url = "http://www1.macys.com/shop/handbags-accessories/sale-clearance?id=28273&edge=hybrid#!fn=SPECIAL_OFFERS%3DClearance/Closeout%26sortBy%3DORIGINAL%26productsPerPage%3D100&!qvp=iqvp";
		
		$sourceCode = getHtml($dbc, $url);
		
		$dom = new DOMDocument();
		$dom->loadHTML($sourceCode);
	
		$xpath = new DOMXPath($dom);
		$linkList = $xpath->query("//div[@class='shortDescription']//a[contains(@href, 'http://www1.macys.com')]/@href");
		$nameList = $xpath->query("//div[@class='title']//a");
		$priceList = $xpath->query("//div[@class='priceSale']");
		$imageList = $xpath->query("//div[@class='thumbnailImage']//img/@src");
			
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
			$link  = "http://www1.macys.com".$linkArray[$i];
			$name = $nameArray[$i];
			$price = $priceArray[$i];
			$image = $imageArray[$i];
			
			// Query inserts all items found into the items table of the database. 
			//Needs to be updated to check if items already exist, or dump all the items and replace
			
			mysqli_query($dbc, "INSERT INTO items (name, siteURL, price, imageURL) VALUES ('$name', '$link', '$price', '$image')");
		}
	}

?>