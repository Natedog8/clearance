<?php
	
	function getDSW($dbc){
		$url = "http://www.coach.com/online/handbags/-handbags_feature_onlineexclusives-us-us-5000000000000305302-en?t1Id=5000000000000258802&t2Id=62&t3Id=5000000000000305302&LOC=SN2";
		
		$sourceCode = getHtml($dbc, $url);
		
		$dom = new DOMDocument();
		$dom->loadHTML($sourceCode);
	
		$xpath = new DOMXPath($dom);
		$linkList = $xpath->query("//div[@class='productName']//a[contains(@href, 'http://www.coach.com')]/@href");
		$nameList = $xpath->query("//div[@class='prod-title']//a");
		$priceList = $xpath->query("//div[@class='prodListPrice']");
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
			$link  = "http://www.coach.com".$linkArray[$i];
			$name = $nameArray[$i];
			$price = $priceArray[$i];
			$image = $imageArray[$i];
			
			// Query inserts all items found into the items table of the database. 
			//Needs to be updated to check if items already exist, or dump all the items and replace
			
			mysqli_query($dbc, "INSERT INTO items (name, siteURL, price, imageURL) VALUES ('$name', '$link', '$price', '$image')");
		}
	}

?>