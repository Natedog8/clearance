<?php
	
	function getNineWest($dbc){
		$url = "http://www.ninewest.com/Sale-Shoes/526934,default,sc.html?pmin=0&pmax=25&prefn1=catalog-id&prefv1=ninewest-catalog&rfnd=trues";
		
		$sourceCode = getHtml($dbc, $url);
		
		$dom = new DOMDocument();
		$dom->loadHTML($sourceCode);
	
		$xpath = new DOMXPath($dom);
		$linkList = $xpath->query("//div[@class='innerProductImg']//a/@href");
		$nameList = $xpath->query("//span[@class='productName']");
		$priceList = $xpath->query("//span[starts-with(@class,'productSalePrice SalePrices')]");
		$imageList = $xpath->query("//div[@class='innerProductImg']//img[@class='prodImgOne']/@src");
			
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
		
		for($i = 0, $count = count($nameArray); $i <= $count; $i++) {
			$link  = $linkArray[$i];
			$name = trim($nameArray[$i]);
			$price = $priceArray[$i];
			$image = $imageArray[$i];
			
			echo "<img src='".$image."'><br><a href='".$link."'>".$name."</a><br>".$price."<br><br>";
		}

	}

?>