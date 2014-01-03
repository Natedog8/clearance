<?php
	
	function getUrban($dbc){
		$url = "http://www.urbanoutfitters.com/urban/catalog/category.jsp?&id=SALE_W_SHOES&itemCount=72&priceMin=9.0&priceMax=295.0&priceLow=9.0&priceHigh=26.0";
		
		$sourceCode = getHtml($dbc, $url);
		
		$dom = new DOMDocument();
		$dom->loadHTML($sourceCode);
	
		$xpath = new DOMXPath($dom);
		$linkList = $xpath->query("//div[@class='category-product-media']//p[@class='category-product-image']//a/@href");
		$nameList = $xpath->query("//div[@class='category-product-media']//p[@class='category-product-image']//img/@alt");
		$priceList = $xpath->query("//div[@class='category-product-description']//span[@class='price-sale']");
		$imageList = $xpath->query("//div[@class='category-product-media']//p[@class='category-product-image']//img/@src");
			
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
			
			echo "<img src='".$image."' width='100'><br><a href='http://www.urbanoutfitters.com".$link."'>".$name."</a><br>".$price."<br><br>";
		}
	}

?>