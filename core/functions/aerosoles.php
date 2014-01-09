
<?php
        
	function getAerosoles($dbc){
		$url = "http://www.aerosoles.com/eng/categories/sale";
		
		$sourceCode = getHtml($dbc, $url);
		
		$dom = new DOMDocument();
		$dom->loadHTML($sourceCode);

		$xpath = new DOMXPath($dom);
		$linkList = $xpath->query("//div[@class='prodImage']//a[contains(@href, 'http://http://www.aerosoles.com')]/@href");
		$nameList = $xpath->query("//div[@class='itemName']");
		$priceList = $xpath->query("//font[@class='productPriceonsale']");
		$imageList = $xpath->query("//div[@class='prodImage']//img[contains(@id, 'image')]/@src");
				
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
				$link  = $linkArray[$i];
				$name = $nameArray[$i];
				<!-----COding is FUN!!!!/>
				$price = $priceArray[$i];
				$image = $imageArray[$i];
				
				// Query inserts all items found into the items table of the database.
				//Needs to be updated to check if items already exist, or dump all the items and replace
				
				mysqli_query($dbc, "INSERT INTO items (name, siteURL, price, imageURL) VALUES ('$name', '$link', '$price', '$image')");
		}
	}
	
?>	