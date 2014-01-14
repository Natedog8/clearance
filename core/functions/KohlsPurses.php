<?php
	
	function getKohlspurses($dbc){
		$url = "http://www.kohls.com/catalog/womens-clearance-handbags-purses-accessories.jsp?CN=4294720878+4294736457+4294717955+4294717956";
		
		$sourceCode = getHtml($dbc, $url);
		
		$dom = new DOMDocument();
		$dom->loadHTML($sourceCode);
	
		$xpath = new DOMXPath($dom);
		$linkList = $xpath->query("//div[@class='url']//a[contains(@href, 'http://www.kohls.com')]/@href");<!---issue finding link---/>
		$nameList = $xpath->query("//div[@class='title']//a");
		$priceList = $xpath->query("//div[@class='sale_add']");
		$imageList = $xpath->query("//div[@class='product-image']//img/@src");
			
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
			$link  = "http://www.kohls.com".$linkArray[$i];
			$name = $nameArray[$i];
			$price = $priceArray[$i];
			$image = $imageArray[$i];
			
			// Query inserts all items found into the items table of the database. 
			//Needs to be updated to check if items already exist, or dump all the items and replace
			
			mysqli_query($dbc, "INSERT INTO items (name, siteURL, price, imageURL) VALUES ('$name', '$link', '$price', '$image')");
		}
	}

?>