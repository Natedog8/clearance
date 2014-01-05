
<?php
        
	function getF21($dbc){
		$url = "http://www.forever21.com/Product/Category.aspx?br=f21&category=shoes_flats&color=&size=&price=20%2c24.99&sort=3&pagesize=100&page=1";
		
		$sourceCode = getHtml($dbc, $url);
		
		$dom = new DOMDocument();
		$dom->loadHTML($sourceCode);

		$xpath = new DOMXPath($dom);
		$linkList = $xpath->query("//div[@class='ItemImage']//a[contains(@href, 'http://www.forever21.com')]/@href");
		$nameList = $xpath->query("//div[@class='DisplayName']");
		$priceList = $xpath->query("//font[@class='price']");
		$imageList = $xpath->query("//div[@class='ItemImage']//img[contains(@id, 'image')]/@src");
				
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
				$price = $priceArray[$i];
				$image = $imageArray[$i];
				
				// Query inserts all items found into the items table of the database.
				//Needs to be updated to check if items already exist, or dump all the items and replace
				
				mysqli_query($dbc, "INSERT INTO items (name, siteURL, price, imageURL) VALUES ('$name', '$link', '$price', '$image')");
		}
	}
	
?>	
