+
+<?php
+        
+	function getUggs($dbc){
+			$url = "http://www.uggaustralia.com/women-sale/";
+			
+			$sourceCode = getHtml($dbc, $url);
+			
+			$dom = new DOMDocument();
+			$dom->loadHTML($sourceCode);
+	
+			$xpath = new DOMXPath($dom);
+			$linkList = $xpath->query("//div[@class='name-link']//a[contains(@href, 'http://www.uggaustralia.com')]/@href");
+			$nameList = $xpath->query("//div[@class='name-link']");
+			$priceList = $xpath->query("//font[@class='product-sale-price']");
+			$imageList = $xpath->query("//[@class='product-image]//img[contains(@id, 'image')]/@src");
+					
+			$linkArray = array();
+			$nameArray = array();
+			$priceArray = array();
+			$imageArray = array();
+					
+			foreach($linkList as $n){
+					$linkArray[] = $n->nodeValue;
+			}
+			
+			foreach($nameList as $n){
+					$nameArray[] = $n->nodeValue;
+			}
+			
+			foreach($priceList as $n){
+					$priceArray[] = $n->nodeValue;
+			}
+			
+			foreach($imageList as $n){
+					$imageArray[] = $n->nodeValue;
+			}
+			
+			for($i = 0, $count = count($priceArray); $i < $count; $i++) {
+					$link  = $linkArray[$i];
+					$name = $nameArray[$i];
+					$price = $priceArray[$i];
+					$image = $imageArray[$i];
+					
+					// Query inserts all items found into the items table of the database.
+					//Needs to be updated to check if items already exist, or dump all the items and replace
+					
+					// mysqli_query($dbc, "INSERT INTO items (name, siteURL, price, imageURL) VALUES ('$name', '$link', '$price', '$image')");
+					
+					echo "<img src='".$image."' width='100'><br><a href='".$link."'>".$name."</a><br>".$price."<br><br>";
