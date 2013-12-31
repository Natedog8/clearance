<?php

	function getHtml($dbc, $url){
		// create curl resource
		$ch = curl_init();
	
		// set url
		curl_setopt($ch, CURLOPT_URL, $url);
	
		//return the transfer as a string
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
	
		// $output contains the output string
		$sourceCode = curl_exec($ch);
		
	
		// close curl resource to free up system resources
		curl_close($ch); 
		
		return $sourceCode;
	}
	
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
			
		foreach ($linkList as $n){
			$linkArray[] = $n->nodeValue;
		}
		
		foreach ($nameList as $n){
			$nameArray[] = $n->nodeValue;
		}
		
		foreach ($priceList as $n){
			$priceArray[] = $n->nodeValue;
		}
		
		foreach ($imageList as $n){
			$imageArray[] = $n->nodeValue;
		}
		
		for($i = 0, $count = count($linkArray);$i<$count;$i++) {
			$link  = $linkArray[$i];
			$name = $nameArray[$i];
			$price = $priceArray[$i];
			$image = $imageArray[$i];
			echo "<img src='".$image."'><br><a href='http://www.dsw.com".$link."'>".$name."</a><br>".$price."<br><br>";
		}
	}

?>